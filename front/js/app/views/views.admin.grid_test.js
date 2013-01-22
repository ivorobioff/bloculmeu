$.proxy(function(value, model, view){
						var offset = model.get('current_page') * model.model.get('rows_per_page')
					}, this)
$(function(){
	Views.Admin.GridTest = Views.Abstract.AdminGrid.extend({
		el: $('#test-bb-table'),
		
		url: Resources.modules_list,
			
		_getCellSettings: function(){
			return {
							
				id: {
					label: 'ID <br/><span></span>',
					header_styles: 'width: 20px;',
					styles: 'text-align:center;'
				},
				
				title: {
					label: 'Тайтл ',
					sortable: false,
					styles: '',
					classes: '',
					header_styles: '',
					header_classes: ''
				},
				
				status: {
					label: 'Статус   <br/><span></span>',
					formatter: function(value){
						if (value == 1){
							return '<span style="color:green">Активен</span>';
						}
						
						return '<span style="color:red">Не активен</span>';
					}
				},
				
				order: {
					label: 'Порядок   <br/><span></span>'
				}
				
			}
		}
	});
});