$(function(){
	Views.Abstract.AdminGrid = Views.Grid.Table.extend({
		
		_classes: 'count_tb',
		
		_standard_formatters: null,
		
		_hide_controls: false,
		
		initialize: function(){
			Views.Grid.Table.prototype.initialize.apply(this, arguments);
			this._standard_formatters = new Helpers.Formatter.Standard(this);
		},
		
		_setControlsClass: function(){
			if (this._hide_controls){
				return {};
			}
			
			return Views.Admin.GridControls;
		}
	});
});