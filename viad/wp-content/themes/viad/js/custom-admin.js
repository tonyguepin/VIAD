

var ajaxurl = '/wp-admin/admin-ajax.php';





(function($) {



	$(document).on('click', '#publish-mail', function(e) {
	
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            'action':'viad_test_email',
	            'post_id': acf.post_id,
	            'emails': $('#acf-field-emailadressen').html()
	            
	        },
	        success:function(data) {
				console.log(data);
	        }
	    });
	});

})(jQuery);


