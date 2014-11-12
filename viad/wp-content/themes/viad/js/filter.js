////////////////
// INIT
////////////////



var mode = 'projects';


if($('section.professionals').length) {
    mode = 'professionals';
    
    
    $( "#slider-price" ).slider({
		range: true,
		min:0,
		max:200,
		step:10,
		values: [ 0, 200 ],
		slide: function( event, ui ) {
			var handles = $(this).find('.ui-slider-handle');
			$(handles[0]).text(ui.values[0]);
			$(handles[1]).text(ui.values[1]);
		},
		create: function( event, ui ) {
			var handles = $(this).find('.ui-slider-handle');
			$(handles[0]).text(0);
			$(handles[1]).text(200);
		},
		stop: function(event, ui) {
		
		    filter(1,mode);
		
		}
	});
    $( "#slider-hours" ).slider({
		range: true,
		min:0,
		max:50,
		step:5,
		values: [ 0, 50 ],
		slide: function( event, ui ) {
			var handles = $(this).find('.ui-slider-handle');
			$(handles[0]).text(ui.values[0]);
			$(handles[1]).text(ui.values[1]);
		},
		create: function( event, ui ) {
			var handles = $(this).find('.ui-slider-handle');
			$(handles[0]).text(0);
			$(handles[1]).text(50);
		},
		stop: function(event, ui) {
		
		    filter(1,mode);
		
		}
	});
    
    
    $(document).on('change','select.filter-project',function() {
    
    	$('li.green').removeClass('green');
		$('li').find('input').prop('checked',false);

    
	    $.ajax({
	        url: ajaxurl,
 		    dataType: 'JSON', 
	        data: {
	            action:'viad_apply_project_filter',
	            id:$(this).val()
	        },
	        success:function(json) {
	        	console.log(json);

				$.each(json.regions, function(i, val) {
					$('.region[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);

				});
				$.each(json.categories, function(i, val) {
					$('.child-category[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
					$('.parent-category[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
				});
				$.each(json.tags, function(i, val) {
					$('.tag[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
				});
				filter(1,mode);

			}
	    });

    });
    
    filter(1,mode);
}



if($('section.projects').length) {
	 mode = 'projects';	
    filter(1,mode);
}
function filter(page, what) {
	
	var filter = [];
	$('li.green').each(function() {
		var val = $(this).data('value');
		var key = $(this).attr('class').split(' ')[0];
		filter.push({key:key,val:val})
	});
	
	filter.push({key:'s', val:$('input.search').val()});
	filter.push({key:'p', val:page});
	
	if(what == 'professionals') {
		filter.push({key:'price', val:$('#slider-price').slider('values')});
		filter.push({key:'hours', val:$('#slider-hours').slider('values')});
	}

    $.ajax({
        url: ajaxurl,
        data: {
            action: 'viad_filter_'+what,
            filter: filter
        },
        success:function(html) {
			$('.results').html(html);	
//			$('aside.filter').height($('.results').height());
//			console.log($('.results').height());
//			location.hash = '#/results/'+page;

		}
	});
}


$('input.search').keypress(function(e) {
  if(e.which == 13) {
	filter(1,mode);
  }
});

$(document).on('click','.search-button',function(e) {
	e.preventDefault();
	filter(1,mode);
});

$(document).on('click','.show-all',function(e) {
	e.preventDefault();
	$('li.green').removeClass('green');
	$('a.green').addClass('gray');
	$('a.green').removeClass('green');
	$('input.search').val('');
	$('li').find('input').prop('checked',false);
	filter(1,mode);
    $('.filter-profile').text("Profiel toepassen");	
	$('.filter-project').val($('option:first').val());
    
	
});


$(document).on('click','.page-nav',function(e) {
	e.preventDefault();
	filter($(this).data('page'),mode);
});

$(document).on('click','.filter-profile',function(e) {
	e.preventDefault();
	$(this).toggleClass('green');
	$(this).toggleClass('gray');
	
    var text = $(this).text();
    $(this).text(text == "Profiel toepassen" ? "Selectie ongedaan maken" : "Profiel toepassen");	
	
	$('li.green').removeClass('green');
	$('li').find('input').prop('checked',false);
	
	if($(this).hasClass('green') == true) {
	    $.ajax({
	        url: ajaxurl,
		        dataType: 'JSON',
	        data: {
	            action:'viad_filter_profile'
	        },
	        success:function(json) {
				$.each(json.regions, function(i, val) {
					$('.region[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);

				});
				$.each(json.categories, function(i, val) {
					$('.child-category[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
					$('.parent-category[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
				});
				$.each(json.tags, function(i, val) {
					$('.tag[data-value="'+val+'"]').addClass('green').find('input').prop('checked',true);
				});
				filter(1,mode);
			}
	    });
	} else {
		filter(1,mode);
	}
});



$(document).on('change','.parent-category input',function() {
	var $li = $(this).parent();
	$li.toggleClass('green');
	
	var id = $li.data('id');

	if($li.find('input').is(':checked') == false) {
		$('.child-category[data-id="'+id+'"]').removeClass('green').find('input').prop('checked',false);
	}
	
	filter(1,mode);
	
});

$(document).on('change','.child-category input',function() {
	var $li = $(this).parent();
	$li.toggleClass('green');

	var id = $li.data('id');
	var parent_checked = false;
	$('.child-category[data-id="'+id+'"]').find('input').each(function() {
		if($(this).is(':checked')) {
			parent_checked = true;
		} 
	});
	
	if(parent_checked == true) {
		$('.parent-category[data-id="'+id+'"]').addClass('green').find('input').prop('checked', true);

	} else {
		$('.parent-category[data-id="'+id+'"]').removeClass('green').find('input').prop('checked', false);
	}
	filter(1,mode);

});

$(document).on('change','.tag input, .region input',function() {
	var $li = $(this).parent();
	$li.toggleClass('green');
	filter(1,mode);
});


$(document).on('click','.more-categories',function(e) {
	var id = $(this).data('id');
	$(this).toggleClass('rotate');
	$('.child-category[data-id!="'+id+'"]').removeClass('open');
	$('.child-category[data-id="'+id+'"]').toggleClass('open');
});

var open = false;
$(document).on('click','.more-tags',function(e) {
	e.preventDefault();
	if(open == false) {
		$('.tag').addClass('open');		
		open = true;
		$(this).text('Bekijk minder');

	} else {
		$('.tag').removeClass('open');
		$('.tag').filter(function() {
		    return  $(this).data('count') >= 1 || $(this).hasClass('green'); 
		}).addClass('open');
		open = false;
		$(this).text('Bekijk meer');
	}

});

