Views.Grid.Table = Views.Abstract.View.extend({
	
	url: '',
	
	/**
	 * Стили для таблицы
	 */
	_styles: '',
	/**
	 * Классы для таблицы
	 */
	_classes: '',
	
	/**
	 * Дефолтные стили для хедера 
	 */
	_default_header_styles: '',
	/**
	 * Дефолтные классы для хедера 
	 */
	_default_header_classes: '',
	
	/**
	 * Дефолтные стили для отдельных ячеек таблицы
	 */
	_default_cell_styles: '',
	/**
	 * Дефолтные классы для отдельных ячеек таблицы
	 */
	_default_cell_classes: '',
	
	/**
	 * Дефолтные стили для строк таблицы
	 */
	_row_styles: '',
	/**
	 * Дефолтные классы для строк таблицы 
	 */
	_row_classes: '',
	
	/**
	 * Дефолтные стили для строк таблицы
	 */
	_header_row_styles: '',
	/**
	 * Дефолтные классы для строк таблицы 
	 */
	_header_row_classes: '',
	
	events: {
		'click .grid-sortable': function(e){
			var $e = $(e.target);
			var dir = this.model.get('order') == 'asc' ? 'desc' : 'asc';
			
			this.model.set({
				order_by: $e.attr('data-item'),
				order: dir
			});
		}
	},

	_rows: null,

	_controls: null,
	
	_cell_settings: null,
	
	initialize: function(){
		this._rows = new Lib.Collection();
		
		var controls_class = this._setControlsClass();
		
		if (typeof controls_class == 'function'){
			this._controls = new controls_class();
		}
			
		this.fetch();
	},
	
	/**
	 * 1. Заполняем коллекцию даннымы здесь. 
	 * 2. Получаем состояние грида в модель Models.Grid.State
	 * 
	 * @param object state - состояние грида. 
	 * Если параметр не задан, то состояние по умолчанию будет взято на сторане сервера.
	 */
	fetch: function(state){
		var state = state;
		
		if (typeof state != 'object'){
			state = {};
		}
		
		this.collection = new Collections.Grid.Rows([{id: 1, title: 'AERDF0001'}, {id: 2, title: 'RRR9999'}]);
		this.model = new Models.Grid.State();
		
		this._disableUI();
		
		Lib.Requesty.read({
			url: this.url,
			data: state,
			success: $.proxy(function(nevermid, data){
				if (typeof data.state != 'object'){
					return false;
				}
				
				if (typeof data.rows != 'object'){
					return false;
				}
				
				this.model = new Models.Grid.State(data.state);
				this.collection = new Collections.Grid.Rows(data.rows);
				this.render();
				this.model.on('change', function(){
					this.refresh();
				}, this);
				this._enableUI();
			}, this),
			
			error: $.proxy(function(){
				this._enableUI();
			}, this)			
		});
	},
	
	refresh: function(){
		
		var state = this.model.toJSON();
		
		delete this.model;
		delete this.collection;
		
		this.fetch(state);
	},
	
	render: function(){
		this._removeOldViews();
		
		this._cell_settings = this._getCellSettings();
			
		var table = '';		
		
		for (var i in this._cell_settings){
			
			var header_classes = this._default_header_classes + ' ' + always_set(this._cell_settings[i], 'header_classes', '');
			var header_styles = this._default_header_styles + ' ' + always_set(this._cell_settings[i], 'header_styles', '');
			
			var label = typeof this._cell_settings[i].label == 'string' ?  this._cell_settings[i].label : '';
			
			var sortable = 'grid-sortable';
			
			if (this.model.get('order_by') == i){
				sortable += ' grid-sortable-active grid-sortable-' + this.model.get('order').toLowerCase();
			}
			
			if (this._cell_settings[i].sortable === false){
				sortable = '';
			}
			
			if (this._cell_settings[i].hidden !== true){
				table += '<th class="' + sortable + ' ' + header_classes + '" style="' + header_styles + '" data-item="' + i + '">' + label + '</th>';
			}
		}
		
		table = '<table id="table" style="' + 
		this._styles + '" class="' + 
		this._classes + '" ><tr class="' + 
		this._header_row_styles + '" styles="' + 
		this._header_row_classes + '">' + table + '</tr></table>';
		
		this.$el.html(table);
			
		this.collection.forEach(function(model){
			this._num_row ++;
			var row = new Views.Grid.Row({model: model, parent: this});
			this._rows.add(model.get('id'), row);
			this._appendRow(row);
		}, this);
				
		if (this._controls instanceof Views.Grid.Controls){
			this._controls.refresh(this.model);
		}
	},
	
	_removeOldViews: function(){
		this._rows.clear(function(row){
			row.remove();
		});
	},
	
	/**
	 * Добавляет строку к гриду
	 */
	_appendRow: function(row){
		this.$el.find('#table').append(row.getElement());
	},
	
	_initControls: function(model){
		return null;
	},
	
	_getCellSettings: function(){
		return {};
	},
	
	getPreperedCellSettings: function(){
		return this._cell_settings;
	},
	
	getDefaultCellStyles: function(){
		return this._default_cell_styles;
	},
	
	getDefaultCellClasses: function(){
		return this._default_cell_classes;
	},
	
	getRowStyles: function(){
		return this._row_styles;
	},
	
	getRowClasses: function(){
		return this._row_classes;
	},
	
	_disableUI: function(){
		
	},
	
	_enableUI: function(){
		
	}
});