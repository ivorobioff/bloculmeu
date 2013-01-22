$(function(){
	Views.Admin.GridControls = Views.Grid.Controls.extend({
		
		_template: $('#test-bb-controls-tmp'),
		
		events: {
			'click [data-page]': function(e){
				var $e = $(e.target);
				var page = $e.attr('data-page');
				
				this.model.set('current_page', page);
				
				return false;
			},
			
			'change [name=rows_per_page]': function(e){
				var $e = $(e.target);
				var rows_per_page = $e.val();
				
				this.model.set({
					current_page: 1,
					rows_per_page: rows_per_page
				});
			},
			
			'change [name=current_page]': function(e){
				var $e = $(e.target);
				var num = parseInt($e.val());
		
				if (isNaN(num)){
					num = 1;
				}
				
				if (num > this._getTotalPages()){
					num = 1;
				}
				
				this.model.set('current_page', num);
			},
			
			'keypress [name=current_page]': function(e){
				var $e = $(e.target);
				if (e.which == '13'){
					$e.blur();
				}
			}
		},
		
		render: function(){
			var tmp = Handlebars.compile(this._template.html());
			
			var data = this.model.toJSON();
			
			Handlebars.registerHelper('on_page', function(value){
				if (data.rows_per_page == value){
					return 'selected="selected"';
				}
				return '';
			});
			
			Handlebars.registerHelper('pages_line', $.proxy(function(){
				var total_pages = 0;
				
				if (data.total > 0){
					total_pages = this._getTotalPages();
				}
				
				if (data.total <= data.rows_per_page * 1){
					return new Handlebars.SafeString('<b>1</b>');
				}
			
				var line = '';
				var d = '';
				
				var count = total_pages > 3 ? 3 : total_pages;
								
				for (var i = 1; i <= count; i ++){
					line += d + this._numWrapper(i, data);
					d = ' ';
				}
								
				if (total_pages > 6){
					var page_value = '';
				
					if (data.current_page > 3 && data.current_page < total_pages - 2){
						page_value = data.current_page;
					}
					
					line += d + '<input type="text" class="bmw-5" name="current_page" value="' + page_value + '" />';
				}
			
				if (total_pages > 3){
					for (var i = total_pages-2; i <= total_pages; i ++){
						line += d + this._numWrapper(i, data);
					}
				}
				
				return new Handlebars.SafeString(line);
								
			}, this));
			
			this.setElement($(tmp(data)));
			
			this.$el.insertAfter('#test-bb-table');
		},
		
		_getTotalPages: function(){
			return Math.ceil(this.model.get('total') / this.model.get('rows_per_page'));
		},
		
		_numWrapper: function(num, data){
			if (data.current_page == num){
				return '<b>' + num + '</b>';
			}
			
			return '<a href="#" data-page="' + num + '">' + num + '</a>';
		},
		
		_refresh: function(){
			this.remove();
			this.render();
		}
	});
});