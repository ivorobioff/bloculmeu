var Views = {};
var Urls = {};

Views.Abstract = Class.extend({
	_id: '',
	_el: null,
	
	initialize: function(){
		this._el = $('#' + this._id);
	}
});

Views.AbstractForm = Views.Abstract.extend({
	
	_url: '',
	_id: 'single-form',
	_el: null,
	_data: {},
	
	initialize: function(){
		this._super();
		this._url = this._el.attr('action');
		this._el.submit($.proxy(function(){
			this._data = this._el.serialize();
			this.beforeSubmit();
			$.post(this._url, this._data, $.proxy(function(res){
				this.afterSubmit(res);
				
				if (typeof res.status != 'string'){
					throw 'wrong status';
				}
				
				if (res.status == 'success'){
					this.success(res.data);
				} else if (res.status == 'error') {
					this.error(res.data);
				} else {
					throw 'wrong status';
				}
			}, this), 'json');
			
			return false;
		}, this));
	},
	
	beforeSubmit: function(){
		this.disableUI();
	},
	
	afterSubmit: function(data){},
	success: function(data){},
	
	error: function(data){
		this._showErrors(data);
		this.enableUI();
	},
	
	disableUI: function(){
		this._el.find('input, select, textarea').each(function(){
			$(this).attr('disabled', 'disabled');
		});
	},
	
	enableUI: function(){
		this._el.find('input, select, textarea').each(function(){
			$(this).removeAttr('disabled');
		});
	},
	
	_showErrors: function(data){
		
		for (var i in data){
			alert(i + ': ' + data[i]);
		}
	}
});

Views.AutoRedirectForm = Views.AbstractForm.extend({
	_redirect_url: '',

	initialize: function(url){
		this._super();
		this._redirect_url = url;
	},
	
	success: function(){
		location.href = this._redirect_url;
	}
});


/*
 * TODO: возможно надо будет изменить метод подгрузки номеров зданий.
 */
Views.StreetNumbersLoader = Views.Abstract.extend({
	_streets_el: null,
	_id: 'buidling-address',
	
	initialize: function(){
		this._super();
		this._streets_el = this._el.find('[name=street]');
		
		this._streets_el.change($.proxy(function(){
			var id = this._streets_el.val();
			
			this._el.find('select[name=number] option[value!="0"]').remove();
			
			if (id > 0){
				this.disableUI();
				$.get('/buildings/get-numbers/' + id + '/', $.proxy(function(res){
					this._el.find('[name=number]').append(res);
					this.enableUI();
				}, this));
			}
		}, this));
	},
	
	disableUI: function(){
		this._el.find('select').attr('disabled', 'disabled');
	},
	
	enableUI: function(){
		this._el.find('select').removeAttr('disabled');
	}
});

Views.SignupForm = Views.AutoRedirectForm.extend({});

Views.SigninForm = Views.AutoRedirectForm.extend({});

Views.NewDiscussionForm = Views.AutoRedirectForm.extend({});

Views.CourtyardForm = Views.AbstractForm.extend({
	success: function(data){
		Views.CourtyardBuildings.getInstance().addBuilding(data);
		this.enableUI();
	}
});

Views.CourtyardBuildings = Views.Abstract.extend({
	_el: 'buildings-container',
	
	addBuilding: function(data){
		alert('Building has been added !');
	},
});

Views.CourtyardBuildings._INSTANCE = null;

Views.CourtyardBuildings.getInstance = function(){
	if (Views.CourtyardBuildings._INSTANCE == null){
		Views.CourtyardBuildings._INSTANCE = new Views.CourtyardBuildings();
	}
	
	return Views.CourtyardBuildings._INSTANCE;
}
