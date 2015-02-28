(function($){
	
	var slider = function(){
		
		var settings = {
				gallery_class : "div.gallery",
				images_class: "images", 
				current_image_class : "current",
				slider_wrapper_class : "slider-wrapper", 
				next_class : "next-slide", 
				prev_class : "prev-slide", 
				thumb_class : "gallery-item a"
		};
		
		var move = function(button){
			//do something 
			var current = this.parent().find('.'+settings.current_image_class);
			
			if(button == 'next'){
				var next = current.next();
				//make it circular
				if(!next.length){
					//grab the first image
					next = $('.'+settings.images_class+" img:first");
				}
			}else if(button == 'prev'){
				var next = current.prev();
				//make it circular
				if(!next.length){
					//grab the last image
					next = $('.'+settings.images_class+" img:last");
				}
			}else{
				//clicked a thumb, find the image that matches the href
				current = $('.'+settings.images_class).find('.'+settings.current_image_class);
				next = $('.'+settings.images_class).find('img[src="'+this.attr('href')+'"]');
			}
			
			current.hide().removeClass(settings.current_image_class);
			next.fadeIn().addClass(settings.current_image_class);
			
		}
		
		var setup_gallery = function(gallery){
			
			//move gallery after content 
			gallery.parent().before(gallery);
			
			//create large image display
			var images = $("<div class='"+settings.images_class+"'></div>");
			//grab images
			var first = true;
			$(gallery.find("dt a")).each(function(){
				images.append("<img src='"+$(this).attr("href")+"' class='"+(first ? settings.current_image_class : '')+"' />");
				first = false;
			});
			images.wrapAll("<div class='"+settings.slider_wrapper_class+"'></div>");
			gallery.append(images.parent());
			
			
			if($("."+settings.images_class+" img").size() > 1){
				//add navigation
				gallery.prepend("<div class='"+settings.next_class+"'></div><div class='"+settings.prev_class+"'></div>");
				
				//attach listeners for nav buttons
				$('.'+settings.next_class).click(function(){ move.call($(this), 'next'); });
				$('.'+settings.prev_class).click(function(){ move.call($(this), 'prev'); });
			}
			
			//listeners for thumbs 
			$('.'+settings.thumb_class).click(function(e){ e.preventDefault();  move.apply($(this));  });
			
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