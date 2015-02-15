(function($){
	
	var slider = function(){
		
		var settings = {
				gallery_class : "div.gallery",
				images_class: "images", 
				current_image_class : "current",
				slider_wrapper_class : "slider-wrapper", 
				next_class : "next-slide", 
				prev_class : "prev-slide"
		};
		
		var next = function(){
			//do something 
			var current = this.parent().find('.'+settings.current_image_class);
			var next = current.next();
			
			var images = this.parent().next();
			
			
			current.removeClass(settings.current_image_class);
			next.addClass(settings.current_image_class);
			
			//resize
			
		}
		
		var setup_gallery = function(gallery){
			
			//add navigation
			gallery.prepend("<div class='"+settings.next_class+"'>NEXT</div><div class='"+settings.prev_class+"'>PREV</div>");
			
			//create large image display
			var images = $("<div class='"+settings.images_class+"'></div>");
			//grab images
			var first = true;
			$(gallery.find("dt a")).each(function(){
				images.append("<img src='"+$(this).attr("href")+"' class='"+(first ? settings.current_image_class : '')+"' />");
				first = false;
			});
			images.wrapAll("<div class='"+settings.slider_wrapper_class+"'><div class='slide'></div></div>");
			gallery.prepend(images.parent().parent());
			
			//set the height and width
			images.css({'height' : images.find('.'+settings.current_image_class).height(), 'width': images.find('.'+settings.current_image_class).width() });
			
			//attach listeners 
			
			$('.'+settings.next_class).click(function(){ next.apply($(this)); });
			
		};
		
		var init = function(){
			//find all the gallerys and turn them into sliders 
			$(settings.gallery_class).each(function(){
				setup_gallery($(this));
			});
		};
		
		return { init: init };
	}();
	
	//doc ready
	$(function(){
		var jws_slider = slider.init();
	});
	
})(jQuery);