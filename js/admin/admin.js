jQuery(document).ready(function($) {
	
	var original_to_editor = window.original_send_to_editor;
	
	$('#image-button').click(function() {
		tb_show('Add an Image', 'media-upload.php?type=image&amp;TB_iframe=true');
		window.original_send_to_editor = window.send_to_editor;

		window.send_to_editor = function(html,t){
			imgurl = $('img',html).attr('src');
	 		$('#image-field').val(imgurl);	 
	 		tb_remove();

	 		callback();
		
		};

     	return false;
		
	});

	var callback = function(){
		window.original_send_to_editor = original_to_editor;
	}

	
	
});