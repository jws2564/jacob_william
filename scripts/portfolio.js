(function($){
	
	var views = function(){
		
		var settings = {
				view_buttons : ".view input",
				filter_buttons : ".filters .filter",
				action: "jws_get_posts",
				url : jws_ajax.ajax_url,
				container : ".items",
				thumbs : ".thumbs img"
		};
		
		var filter = function(){
			//get view value
			var view = $(settings.view_buttons+":checked").val();
			var filters = $(settings.filter_buttons+".active");
			var data = { view : view, filters : [], action : settings.action };
			filters.each(function(){
				data.filters.push($(this).data('term-name'));
			});
			
			$.post(settings.url, data, function(response){
				$(settings.container).html(response);
			});
		};
		
		var toggle = function(){			
			$(this).toggleClass('active');
			filter();
		};
		
		var gallery = function(image){
			var current = $(image).parent().prev();
			$(current).attr('src', $(image).attr('src'));
		};
		
		var init = function(){
			//add event handlers
			$(settings.filter_buttons).click(function(){ toggle.apply(this); });
			$(settings.view_buttons).change(function(){filter();});
			$(settings.container).on("click", settings.thumbs, function(){gallery(this);} );
		};
		
		return { init: init };
	}();
	
	
	
	
	//doc read 
	$(function(){
		var portfolio_views = views.init();
	});
	
})(jQuery);