Views.Abstract.From = Views.Abstract.View.extend({
	events: {
		'click [type=submit]': function(){
			this._onSubmit(this.$el.serialize());
		}
	},
	
	initialize: function(){
		 Views.Abstract.View.prototype.initialize.apply(this, arguments);
		 this._blockRealSubmission();
	},
	
	enableUI: function(){
		this.$el.find('[type=submit]').removeAttr('disabled');
	},
	
	disableUI: function(){
		this.$el.find('[type=submit]').attr('disabled', 'disabled');
	},
	
	_onSubmit: function(data){
		
	},
		
	_blockRealSubmission: function(){
		this.$el.submit(function(){ return false});
	}
});