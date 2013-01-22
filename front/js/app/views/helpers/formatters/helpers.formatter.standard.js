Helpers.Formatter.Standard = Class.extend({
	
	_grid: null,

	_counter: 0,
	
	initialize: function(grid){
		this._grid = grid;
	},
	
	/**
	 * форматер для вывода текущей нумерации записи
	 */
	counter: function(value, model, view){
		
		if (!view.getParam('counter', false)){
			this._counter ++;
			view.assign('counter', this._counter);
		}
			
		return view.getParam('counter');
	}
});