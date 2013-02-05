var Views = {};
var Models = {};

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

Views.GeoSearch = Views.Abstract.extend({
	_id: 'geo-search',
	
	initialize: function(){
		this._super();
		this._el.find('input[type=button]').click($.proxy(function(){
			if (navigator.geolocation){
				 navigator.geolocation.getCurrentPosition($.proxy(this.onGetLocation, this));
			} else {
				alert('Ваш браузер не потдерживает этот сервис');
			}
		}, this));
	},
	
	onGetLocation: function(position){
		this.disableUI();
		$.get('/buildings/geo/' + position.coords.latitude + '/' + position.coords.longitude, $.proxy(function(data){
			this.enableUI();
			if (typeof data.data != 'object'){
				throw 'wrong data';
			}
	
			if (data.status == 'success'){
				if ($.trim(data.data.html) == ''){
					data.data.html = '<br/>Ваш дом не найден :-(';
				}
				this._el.find('#geo-buildings-list').html(data.data.html);
			}
		}, this), 'json');
	},
	
	disableUI: function(){
		this._el.find('input').attr('disabled', 'disabled');
	},
	
	enableUI: function(){
		this._el.find('input').removeAttr('disabled');
	}
});

Views.SigninForm = Views.AutoRedirectForm.extend({});

Views.NewDiscussionForm = Views.AutoRedirectForm.extend({});

Views.CourtyardForm = Views.AbstractForm.extend({
	success: function(data){
		Views.CourtyardBuildings.getInstance().addBuilding(data.html);
		this.enableUI();
	}
});

Views.CourtyardBuildings = Views.Abstract.extend({
	_id: 'buildings-container',
	
	addBuilding: function(html){
		this._el.prepend(html);
	}
});

Views.CourtyardBuildings._INSTANCE = null;

Views.CourtyardBuildings.getInstance = function(){
	if (Views.CourtyardBuildings._INSTANCE == null){
		Views.CourtyardBuildings._INSTANCE = new Views.CourtyardBuildings();
	}
	
	return Views.CourtyardBuildings._INSTANCE;
}



Views.InvitationsList = Views.Abstract.extend({
	_id: 'invitations-list',
	
	initialize: function(){
		this._super();
		this._el.find('.invitation-item').each(function(){
			new Views.InvitationsItem(this);
		});
	}
});

Views.InvitationsItem = Class.extend({
	
	_el: null,
	
	_invitation_id: null,
	
	_url: '/invitations/',
	
	initialize: function(el){
		this._el = $(el);
		this._invitation_id = this._el.find('[name=id]').val();
		this._el.find('[name=accept]').click($.proxy(this.accept, this));
		this._el.find('[name=decline]').click($.proxy(this.decline, this));
	},
	
	accept: function(){
		this._sendRequest('accept');
	},
	
	decline: function(){
		this._sendRequest('decline');
	},
	
	_sendRequest: function(type){
		this._el.find('[type=button]').attr('disabled', 'disabled');
		$.post(this._url + type + '/', {id: this._invitation_id}, $.proxy(function(res){
			if (res != 'ok'){
				throw 'unknown error';
			}	
			this._el.remove();
		}, this));
	}
});

Views.CourtyardSuggestions = Views.Abstract.extend({
	
	_id: 'courtyard-suggestions-list',
	
	initialize: function(){
		this._super();
		this._el.find('.suggestion-item').each(function(){
			new Views.CourtyardSuggestionItem(this);
		});
	}
});

Views.CourtyardSuggestionItem = Class.extend({
	_el: null,
	_building_id: 0,
	
	initialize: function(e){
		this._el = $(e);
		this._building_id = this._el.find('input').val();
		
		this._el.find('a').click($.proxy(function(){
			this.onClick();
			return false;
		}, this))
	},
	
	onClick: function(){
		if (confirm('Добавить данное здание в ваш двор?')){
			Views.SuggestionDisabler.getInstance().show();
			$.post('/courtyards/add-suggestion/', {id: this._building_id}, $.proxy(function(data){
				Views.SuggestionDisabler.getInstance().hide();
				if (data.status == 'success'){
					Views.CourtyardBuildings.getInstance().addBuilding(data.data.html);
					this._el.remove();
				}
			}, this), 'json')
		}
	}
});

Views.SuggestionDisabler = Views.Abstract.extend({
	_id: 'suggestions-disabler',
	
	show: function(){
		this._el.show();
	},
	
	hide: function(){
		this._el.hide();
	}
});

Views.SuggestionDisabler._INSTANCE = null;

Views.SuggestionDisabler.getInstance = function(){
	if (Views.SuggestionDisabler._INSTANCE == null){
		Views.SuggestionDisabler._INSTANCE = new Views.SuggestionDisabler();
	}
	
	return Views.SuggestionDisabler._INSTANCE;
}

Views.DialogsList = Views.Abstract.extend({
	
});

Views.DialogIO = Views.Abstract.extend({
	
});

Views.DialogItem = Class.extend({
	
});

Models.DialogPartner = Class.extend({
	
});
