

if(location.hash) {
	load_content(location.hash);
}
window.onhashchange = function() {
	load_content(location.hash);
};


function load_content(hash) {
	hash = hash.replace('#/','');
    $.ajax({
        url: ajaxurl,
        dataType:'JSON',
        data: {
            action:'viad_load_content',
            hash: hash
        },
        success:function(json) {
			$(json).each(function() {
				$(this.container).html(this.html);
			});		        
			
			$('ul.tab-menu li a[href="#/'+hash+'"]').addClass('selected');
		}
   });
}
