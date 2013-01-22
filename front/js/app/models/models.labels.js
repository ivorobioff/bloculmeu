Models.Labels = Models.Abstract.Model.extend({
	
});

Models.Labels._INSTANCE = null;

Models.Labels.install = function(data){
	if (Models.Labels._INSTANCE == null){
		Models.Labels._INSTANCE = new Models.Labels(data);
	}
}

Models.Labels.getInstance = function(){
	return Models.Labels._INSTANCE;
}