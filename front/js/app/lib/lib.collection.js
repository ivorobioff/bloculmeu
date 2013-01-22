Lib.Collection = Class.extend({
	_data: null,
	
	initialize: function(){
		this._data = {};
	},
	
	add: function(key, value){
		var data = {};
		data[key] = value;
		$.extend(this._data, data);
		return this;
	},
	
	get: function(key, def){
		return always_set(this._data, key, def);
	},
	
	remove: function(key){
		delete this._data[key]; 
	},

	/**
	 * Очищает список. Перед удалением каждого из элементов, вызывает колбэк.
	 */
	clear: function(func, context){
		this.each(function(item, key){
			if (typeof func === 'function'){
				$.proxy(func(item, key), typeof context == 'undefined' ? this : context);
			}
			this.remove(key);
		});
	},
	
	each: function(func, context){
		_.each(this._data, func, _.isUndefined(context) ? this : context);
	}
});