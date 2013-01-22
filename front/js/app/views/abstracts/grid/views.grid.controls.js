Views.Grid.Controls = Views.Abstract.View.extend({
	model: null,
	
	refresh: function(model){
		var flag = this.model == null;
		
		this.model = model;
		
		if (flag){
			this.render();
			return true;
		}
		
		this._refresh();
	},
	
	render: function(){
		
	},
	
	_refresh: function(){
		
	}
});