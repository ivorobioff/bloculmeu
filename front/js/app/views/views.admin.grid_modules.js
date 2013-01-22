$(function(){
	Views.Admin.GridModules = Views.Abstract.AdminGrid.extend({
		el: $('#test-bb-table'),
		
		url: Resources.modules_list,
		
		_hide_controls: true,
		
		_getCellSettings: function(){
			return {				
				counter: {
					label: '#',
					header_styles: 'width: 20px;',
					styles: 'text-align:center;',
					formatter: $.proxy(this._standard_formatters.counter, this._standard_formatters),
					sortable: false,
				},
				
				install: {
					label: 'Установить/<br/>Удалить',
					sortable: false,
					
					events: {
						'click input': function(e, model){
							var $e = $(e.target);
							var url = Resources.install_module;
							
							if (!$e.attr('checked')){
								url = Resources.uninstall_module;
							}
							
							Lib.Requesty.post({
								url: url,
								data: {name: model.get('name')},							
								error: function(error_handler){
									error_handler.alert();
								},
								
								followers: model
							});
						}
					},
					formatter: function(value, model){
						var checked = '';
						if (model.has('guid')){
							checked = 'checked="checked"';
						}
						
						return '<input type="checkbox" name="install" ' + checked + ' />';
					},
					
					styles: 'text-align: center;',
					header_styles: 'width: 70px;'
				},
				
				title: {
					label: 'Имя',
					sortable: false,
					styles: '',
					classes: '',
					header_styles: '',
					header_classes: ''
				},
				
				description: {
					label: 'Описание',
					sortable: false
				},
				
				pin: {
					label: 'Прикрепить',
					header_styles: 'width: 80px',
					styles: 'text-align: center',
					sortable: false,
					
					events:{
						'click span': function(value, model){
							if (!model.has('guid')){
								return ;
							}
							Lib.Requesty.post({
								url: Resources.pin_module,
								data: {name: model.get('name')},
								followers: model
							});
						}
					},
					
					formatter: function(value, model, view){
						
						if (!model.has('guid')){
							return '';
						}
						
						var cls = 'ui-icon-pin-w';
						
						if (value * 1 == 1){
							cls = 'ui-icon-pin-s';
						}
						
						return '<span class="light-icons cursor-pointer ' + cls + '"></span>';
					}
				},
				
				refresh: {
					label: 'Обновить',
					header_styles: 'width: 80px',
					styles: 'text-align: center',
					sortable: false,
					
					events: {
						'click span': function(value, model){
							if (!model.has('guid')){
								return ;
							}
							
							Lib.Requesty.post({
								url: Resources.refresh_module,
								data: {name: model.get('name')},
								followers: model
							});
						}
					},
					
					formatter: function(view, model){
						if (!model.has('guid')){
							return '';
						}
						return '<span class="light-icons cursor-pointer ui-icon-refresh"></span>';
					}
				}
			}
		}
	});
});