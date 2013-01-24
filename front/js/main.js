var Views = {};

$(function(){
	Views.AbstractForm = Class.extend({
		
		_url: '',
		_id: 'signup-form',
		_el: null,
		
		initialize: function(){
			this._el = $('#' + this._id);
			this._url = this._el.attr('action');
			alert(this._url);
		}
	});
});