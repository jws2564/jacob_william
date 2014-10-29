// Uploading files
var file_frame;
 
  jQuery('#upload_image_button').live('click', function( event ){
 
    event.preventDefault();
 
    // If the media frame already exists, reopen it.
    if ( file_frame ) {
      // Open frame
      file_frame.open();
      return;
    } else {
      // Set the wp.media post id so the uploader grabs the ID we want when initialised
    	console.log(wp.media.model.settings.post.id);
      wp.media.model.settings.post.id = jQuery("#post-attachment").data('parent_post');
      console.log(wp.media.model.settings.post.id);
      
    }
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: true  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
   
      var selection = file_frame.state().get('selection');
      console.log(selection);
      selection.map( function( attachment ) {
   
        attachment = attachment.toJSON();
        
        // Do something with attachment.id and/or attachment.url here
      });
    });
 
    // Finally, open the modal
    file_frame.open();
  });