jQuery(document).ready(function($) {
	$('#sog-form').submit( function(event) {
		event.preventDefault();
		$('.submit-button').hide();
		$('#loader-image').show();

		var post_types = $(this).serialize();
		
		// console.log(post_types);
		$.post(ajaxurl, post_types , function(resp) {
			// console.log(resp);
			$('.submit-button').show();
			$('#loader-image').hide();
			if (resp == true) {
				$('.seetings-msg').html("Saved!");
			}else{

				$('.seetings-msg').html("Settings Not changed!");
			};
		});
	});
});