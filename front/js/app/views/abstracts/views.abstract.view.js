Views.Abstract.View = Backbone.View.extend({
	
	_models: null,
	_params: null,
		
	
	_routes: null,

	initialize: function(){
		this._assignRoutes();
		this._models = new Lib.Collection();
		this._params = new Lib.Collection();
	},

	_assignRoutes: function(){
		if (_.isObject(this._routes)){
			for (var i in this._routes){
				Lib.Router.getInstance().on('route:' + i, this._routes[i], this);
			}		
		}
	},
	
	addModel: function(key, model){
		this._models.add(key, model);
		return this;
	},
	
	getModel: function(key){
		return this._models.get(key);
	},
	
	getElement: function(){
		return this.$el;
	},
	
	/**
	 * Позволяет прикрепить вьюшке дополнительные параметры
	 */
	assign: function (key, value){
		
		this._params.add(key, value);
		
		return this;
	},
	
	/**
	 * получает прикрепленный параметр
	 */
	getParam: function(key, def){
		return this._params.get(key, def);
	}
});