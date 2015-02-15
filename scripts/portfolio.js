(function($){
	
	var views = function(){
		
		var settings = {
				view_buttons : ".view input",
				filter_buttons : ".filters .filter",
				action: "jws_get_posts",
				url : jws_ajax.ajax_url,
				container : ".items",
				thumbs : ".thumbs .thumb",
				loader: ".loading"
		};
		
		var filter = function(){
			//get view value
			var view = $(settings.view_buttons+":checked").val();
			var filters = $(settings.filter_buttons+".active");
			var data = { view : view, filters : [], action : settings.action };
			filters.each(function(){
				data.filters.push($(this).data('term-name'));
			});
			var scroll = $(window).scrollTop();
			$(settings.container).hide();
			$(settings.loader).show();

			$.post(settings.url, data, function(response){
				$(settings.container).html(response);
				$(settings.loader).fadeOut(function(){ $(settings.container).show(); $(window).scrollTop(scroll); });
				
				
			});
		};
		
		var toggle = function(){			
			$(this).toggleClass('active');
			filter();
		};
		
		var gallery = function(image){
			var current = $(image).parent().prev().children('img');
			$(current).attr('src', $(image).children('img').attr('src'));
			current.parent().next().find('.current').toggleClass('current');
			$(image).addClass('current');
		};
		
		var init = function(){
			//add event handlers
			$(settings.filter_buttons).click(function(e){ toggle.apply(this); });
			$(settings.view_buttons).change(function(){filter();});
			$(settings.container).on("click", settings.thumbs, function(){gallery(this);} );
			//reset the view on page load
			$(settings.view_buttons +"[value='list']").attr("checked", true);
			$(settings.view_buttons +"[value='grid']").attr("checked", false);
		};
		
		return { init: init };
	}();
	
	//doc read 
	$(function(){
		var portfolio_views = views.init();
	});
	
})(jQuery);