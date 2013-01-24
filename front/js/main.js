var Views = {};

Views.AbstractForm = Class.extend({
	
	_url: '',
	_id: 'signup-form',
	_el: null,
	_data: {},
	
	initialize: function(){
		this._el = $('#' + this._id);
		this._url = this._el.attr('action');
		this._el.submit($.proxy(function(){
			this._data = this._el.serialize();
			this.beforeSubmit();
			$.post(this._url, this._data, $.proxy(function(res){
				this.afterSubmit(res);
				if (typeof res.status == 'success'){
					this.success(res.data);
				} else {
					this.error(res.data);
				}
			}, this));
			return false;
		}, this));
	},
	
	beforeSubmit: function(){},
	afterSubmit: function(data){},
	success: function(data){},
	error: function(data){}
});
