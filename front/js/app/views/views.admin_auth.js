$(function(){
	Views.AdminAuth = Views.Abstract.From.extend({
		
		el: $('#auth_container'),
		
		_onSubmit: function(data){
			this.disableUI();
			
			Lib.Requesty.post({
				data: data,
				url: Resources.admin_auth,
				
				success: $.proxy(function(followers, res){
					if (!_.isUndefined(res.url)){
						location.assign(res.url);
					}
					
					this.enableUI();
				}, this),
				
				error: $.proxy(function(error_handler){
					error_handler.alert();
					this.enableUI();
				}, this)
			});
		}
	});
});