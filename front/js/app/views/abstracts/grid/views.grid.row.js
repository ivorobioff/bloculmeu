Views.Grid.Row = Views.Abstract.View.extend({
	
	tagName: 'tr',

	_settings: null,
	_parent: null,
	
	events: null,
		
	initialize: function(){
		Views.Abstract.View.prototype.initialize.apply(this, arguments);
		this._parent = this.options.parent;
		this._settings = this._parent.getPreperedCellSettings();		
		this._initEvents();
		this.render();
		
		this.model.on('change', function(){
			this.refresh();
		}, this);
	},
	
	_initEvents: function(){
		this.events = {};
		
		for (var i  in this._settings){
			var events = this._settings[i].events;
			
			if (typeof events == 'object'){
				this._assignEvents(events, i);
			}
		}
	},
	
	_assignEvents: function(events, item){
		var new_events = {};
		
		for (var i in events){
			new_events[this._prepareEvents(i, item)] = function(e){
				events[i](e, this.model, this);
			}
		}
		
		this.events = _.extend(this.events, new_events);
	},

	_prepareEvents: function(name, item){
		var full_name  = name;
		var event_name = trim(full_name.split(' ')[0]);
		full_name = trim(full_name.replace(event_name, ''));
		
		return event_name + ' #' + item + ' ' + full_name;
	},
	
	refresh: function(){
		this.render();
	},
	
	render: function(){
		var row = '';
		
		this.$el.attr('style', this._parent.getRowStyles());
		this.$el.attr('class', this._parent.getRowClasses());
		
		for (var i  in this._settings){
			var value = '';
			
			if (this.model.has(i)){
				value = this.model.get(i);
			}
			
			value = _.escape(value);
			
			value = this._passThroughFormatters(value, i);

			if (this._settings[i].hidden !== true){
				var cell_classes = this._parent.getDefaultCellClasses() + ' ' + always_set(this._settings[i], 'classes', '');
				var cell_styles = this._parent.getDefaultCellStyles() + ' ' + always_set(this._settings[i], 'styles', '');
				row += '<td class="' + cell_classes + '"  style="' + cell_styles + '" id="' + i + '">' + value + '</td>';
			}
		}
		
		this.$el.html(row);
		this.delegateEvents();
	},
	
	_passThroughFormatters: function(value, item){
		var value = value;
		var formatters = this._settings[item].formatter;
		
		if (typeof formatters == 'undefined'){
			return value;
		}
		
		if (typeof formatters == 'function'){
			return formatters(value, this.model, this);
		}
		
		for (var i in formatters){
			value = formatters[i](value, this.model, this);
		}
		
		return value;
	}
});