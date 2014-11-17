
function screen_notification(text) {
	$('#info-notification').html('<p>'+text+'</p>');	
	$('.user-info').addClass('notify');			
	setTimeout(function() {
		$('.user-info').removeClass('notify');			
	    $.ajax({
	        url: ajaxurl,
	        dataType: 'JSON',
	        data: {
	            'action':'viad_update_userinfo'
	        },
	        success:function(json) {
				$(json).each(function() {
					$(this.container).html(this.html);
				});		        
	        }
	    });
	},1500)	
}


$(document).ready(function() {
		

		//////////////////////
		// BROWSE CALENDAR
		/////////////////////
		$(document).on('click','.browse-calendar', function(e){
			e.preventDefault();
		    $.ajax({
		        url: ajaxurl,
 		        dataType: 'JSON', 
		        data: {
		            action:'viad_browse_calendar',
		            id: $(this).data('id'),
		            start: $(this).data('start'),
		            end: $(this).data('end')
		        },
		        success:function(json) {
					$(json).each(function() {
						$(this.container).html(this.html);
					});		        
				}
		    });
		
		});


		//////////////////////
		// TOGGLE FAVS
		/////////////////////
		$(document).on('click','.toggle-favorite', function(e){
			e.preventDefault();

			var svg = $(this).find('.svg-star');
			var classes = svg.attr('class');
			if(classes.indexOf('blue') != -1) {
				svg.attr("class", "svg-star gray");
				screen_notification('Verwijderd uit favorieten');

			} else {
				svg.attr("class", "svg-star blue");
				screen_notification('Toegevoegd aan favorieten');
			}

		    $.ajax({
		        url: ajaxurl,
		        dataType: 'JSON',
		        data: {
		            action:'viad_toggle_favorite',
		            project_id: $(this).data('id')
		        },
		        success:function(json) {
					$(json).each(function() {
						$(this.container).html(this.html);
					});		        
				}
		    });
		});

		//////////////////////
		// SUBSCRIBE PROJECT
		/////////////////////
		$(document).on('click','.project-subscribe', function(e){
			e.preventDefault();

			var project_id = $(this).data('project-id');

		    $.ajax({
		        url: ajaxurl,
/* 		        dataType: 'JSON', */
		        data: {
		            action:'viad_subscribe_project',
		            project_id: project_id
		        },
		        success:function(json) {
		        	console.log(json);
				//	$(json).each(function() {
				//		$(this.container).html(this.html);
				//	});		        
				}
		    });

			
		});

		/////////////////////
		// TOGGLE SPOTLIGHT
		/////////////////////
		$(document).on('change', '.toggle-spotlight', function() {
			var val = 'off';	
			if($(this).is(':checked')) {
				val = 'on';
			}
		    $.ajax({
		        url: ajaxurl,
		        data: {
		            action:'viad_toggle_spotlight',
		            spotlight:val
		        },
		        success:function(html) {
					console.log(html);
		        }
		    });
			
		});

		/////////////////////
		// UPDATE USERINFO 
		/////////////////////
		if($('.logged-in').length > 0 /* && !$('.switch').length */) {
			var update = setInterval(function() {
			    $.ajax({
			        url: ajaxurl,
			        dataType: 'JSON',
			        data: {
			            'action':'viad_update_userinfo'
			        },
			        success:function(json) {
						$(json).each(function() {
							if($(this.container).hasClass('notify') == false ) {
								$(this.container).html(this.html);
							}
						});		        
			        }
			    });
			}, 15000);
		}

				
		/////////////////////
		// REGISTER
		/////////////////////
		$('input[name="type"]').change(function() {
			if($(this).val() == 'companies') {
				$('.contact').removeClass('hidden');
			} else {
				$('.contact').addClass('hidden');
			}
		});
		$('input[name="membership"]').change(function() {
			if($(this).val() == 'plus' || $(this).val() == 'premium') {
				$('.payment').removeClass('hidden');
			} else {
				$('.payment').addClass('hidden');
			}
		});
		
		
		$('input[name="user_name"]').focus(function() {
			
			var name = $('input[name="name"]').val();
			var ins = $('input[name="insertion"]').val();
			var last_name = $('input[name="last_name"]').val();
			var user_name = '';
			if(name && last_name) {
				user_name = name+'.'+last_name.toLowerCase();
			} 
			if(name && last_name && ins) {
				user_name = name+'.'+ins+'.'+last_name.toLowerCase();
			}
			$(this).val(user_name);
			
			/* Ajax check username */
		});

		$('.register-button').click(function() {
			$('.required').removeClass('empty');
			$('.required').each(function() {
				if(!$(this).val()) {
					$(this).addClass('empty');
				}
			});
			if($('input[name="password_again"]').val() != $('input[name="password"]').val()) {
				$('input[name="password_again"]').addClass('empty');
			}
		    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    if(re.test($('input[name="email"]').val()) == false) {
		    	$('input[name="email"]').addClass('empty');
		    }
 			
 			if($('.empty').length == 0) {
				$('.register-form').ajaxSubmit({
					url: ajaxurl, 
				    delegation: true,
				    data :{'action':'viad_register'},
				    beforeSend: function() {
				    },
					complete: function(xhr) {
						console.log(xhr.responseText);
						$(window).css({scrollTop:$('section.register').offset().top});
		 				$('section.register').html(xhr.responseText);
		 				
					}
				}); 
 			}


		
		
		});



		/////////////////////
		// UPLOAD IMAGES FORM
		/////////////////////
		
		$(document).on('click', '.select-img', function(e) {
			e.preventDefault();
			console.log($(this).parent().find('input[type="file"]'));
			console.log($(this).parent().parent().find('input[type="file"]'));
		
		});
		
 		$(document).on('change', '.upload-form', function(e) { 
			
		
			var key = $(this).find('input[name="key"]').val();
			var progressbar = $(this).find('input[type="submit"]');
			console.log(this, progressbar, key);
			

			
			$(this).ajaxForm({
				url: ajaxurl,           
			    beforeSend: function() {
					console.log('iets');
			    },
			    uploadProgress: function(event, position, total, percentComplete) {
			        var percentVal = percentComplete + '%';
			        $('#'+key+'_progress')
			        .text(percentVal)
					.width(percentComplete*1.6);
					progressbar.css({
						'background': '-webkit-gradient(linear, left top, right top, color-stop('+percentComplete+'%,#8ec63f), color-stop('+percentComplete+'%,#00adef)'					
					}).val(percentVal);
			    },
			    success: function() {
					progressbar.css({
						'background': '#8ec63f'					
					}).val('100%');
			    },
				complete: function(xhr) {

					progressbar.css({
						'background': '#00adef'					
					}).val('upload');
					console.log(xhr.responseText, key)
					$('.'+key).css({'background-image':'url('+xhr.responseText+')', 'background-size':'cover'});

				}
			}); 
		
 		}); 


	/////////////////////
	// AGENDA
	/////////////////////
	$(document).on('click', '.edit-calendar', function(e) {
		e.preventDefault();

		$('.day').not('.gray').css({'cursor':'pointer'});

		$(document).on('click', '.day', function(e) {
			if($(this).hasClass('.gray') == false) {
				$(this).toggleClass('na');	
			}
		});

		$(this)
		.text('Save')
		.removeClass('edit-calendar')
		.addClass('save-calendar');
		
		$(document).on('click', '.save-calendar', function(e) {
			var dates = [];
			
			$('.na').each(function() {
				dates.push($(this).data('timestamp'));
			});
			
		    $.ajax({
		        url: ajaxurl,
		        data: {
		            'action':'viad_save_calendar',
		            'dates': JSON.stringify(dates)
		        },
		        success:function(html) {
					$('.calendar').html(html);
		        }
		    });
		});
	
	});
	
	
	/////////////////////
	// DISPLAY FROM USER INFOBOX
	/////////////////////
	$(document).on('click', '.display', function(e) {
		e.preventDefault();
		var func = $(this).data('display').replace('-','_');
		var user = $(this).data('user');
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            'action':'viad_display',
	            'func':func,
	            'user':user
	        },
	        success:function(html) {
		        var classes = $('.profile-container').attr('class');
		        classes = classes.split(' ');
		        if(classes.length > 1) {
			        $('.profile-container').removeClass(classes[classes.length - 1]);
		        }
		        console.log(html);
				$('.profile-container').html(html).addClass(func);
				$('html, body').animate({'scrollTop':$('.profile-container').offset().top},300);
	        }
	    });

	 });  

	
	/////////////////////
	// EDIT PROFILE 
	/////////////////////
	if(location.hash == '#/edit-profile') {
		var id = $('#id').data('id');
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_edit_profile'
	        },
	        success:function(html) {
  	        	$('.profile.content').html(html); 
 	        	
	        }
	    });

	}
	
	$(document).on('click', '.edit-profile', function(e) {
		e.preventDefault();
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_edit_profile'
	        },
	        success:function(html) {
  	        	$('.profile.content').html(html); 
 	        	
	        }
	    });
	});
	
	/////////////////////
	// DELETE (PROJECT)
	/////////////////////
	$(document).on('click', '.delete', function(e) {
		e.preventDefault();
		var id = $(this).data('id');
		var subject = $(this).data('subject');
		
		
		var sure = confirm('Weet u het zeker dat u '+subject+' wilt verwijderen?');
		if (sure == true) {
		    $.ajax({
		        url: ajaxurl,
		        data: {
		            action:'viad_delete',
		            id:id,
		            subject:subject
		        },
		        success:function(html) {
		        	if(subject == 'dit bericht') {
		        		$('section.dashboard.main').html(html);
		        	} else {
		 	        	window.location = html;
	 	        	}
		        }
		    });
	    }
	});
	

	/////////////////////
	// EDIT PROJECT 
	/////////////////////
	
	if(location.hash == '#/edit-project') {

		var id = $('#id').data('id');
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_edit_project',
	            id:id
	        },
	        success:function(html) {
 	        	$('.content').html(html);
	        }
	    });

	}
	
	$(document).on('click', '.edit-project', function(e) {
		e.preventDefault();
		var id = $(this).data('id');
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_edit_project',
	            id:id
	        },
	        success:function(html) {
 	        	$('.content').html(html);
	        }
	    });
	});
	/////////////////////
	// SAVE PROFILE 
	/////////////////////
	$(document).on('click', '.save-profile', function(e) {
		e.preventDefault();
		
		var save = [];
		
		if($(this).data('publish') == true) {
			save.push({key:'publish',val:'true'});
		} else if($(this).data('publish') == false) {
			save.push({key:'publish',val:'false'});
		}
		
		$('.save').each(function(i) {
			if($(this).val()) {
				
				if($(this).is('input[type="checkbox"]')) {
					if($(this).is(':checked')) {
						save.push({  key: $(this).attr('name') , val:$(this).val()});
					}
					
				} else  {
					save.push({  key: $(this).attr('name') , val:$(this).val()});
				}
			}
		});
		var profile_text = $('#profile-text').html();
		profile_text = profile_text.replace('\n','<br/>');		
		save.push({key:'profile_text', val:profile_text});
	    $.ajax({
	        url: ajaxurl,
 	        dataType:'JSON', 
	        data: {action : 'viad_save_profile', save:save},
	        success:function(json) {
				console.log(json);	        
				$(json).each(function(i) {
					$(json[i].container).html(json[i].html);
				});
	        }
	    });
	});

	/////////////////////
	// TOGGLE JOBS IN WIDGET 
	/////////////////////
	$(document).on('click', '.toggle-jobs', function(e) {
		e.preventDefault();
		var id = $(this).data('id');	
		$('.job[data-id="'+id+'"]').toggleClass('hidden');
//		$('.job.hidden[data-id="'+id+'"]').show();
	
	});
	/////////////////////
	// SAVE PROJECT 
	/////////////////////
	$(document).on('click', '.save-project', function(e) {
		e.preventDefault();
		var save = [];
		$('.save').each(function(i) {
			if($(this).val()) {
				
				if($(this).is('input[type="checkbox"]')) {
					if($(this).is(':checked')) {
						save.push({  key: $(this).attr('name') , val:$(this).val()});
					}
					
				} else  {
					save.push({  key: $(this).attr('name') , val:$(this).val()});
				}
			}
		});
		
		
		var project_text = $('#project-text').html();
		
		
		save.push({key:'project_text', val:project_text});

		var project_id = $(this).data('project-id');
		

	    $.ajax({
	        url: ajaxurl,
   	        dataType:'JSON', 
	        data: {action:'viad_save_project', project_id:project_id, save:save},
	        success:function(json) {
				$(json).each(function(i) {
					$(json[i].container).html(json[i].html);
				});
	        }
	    });
	});


	/////////////////////
	// READ MESSAGE
	/////////////////////
	$(document).on('click','.msg-title', function(e){
		e.preventDefault();
		

		var li = $(this).parent().parent();
		$(li).removeClass('unread');
		
		if($(li).hasClass('open') == false) {
 			var h = $(li).find('p.msg-text').height();
	 		$(li).height(70+h);
 			$(li).find('p.msg-text').css({'opacity':1.0});
			$(li).addClass('open');
		} else {
	 		$(li).height(50);
 			$(li).find('p.msg-text').css({'opacity':0.0});
			$(li).removeClass('open');
		}
		
	    $.ajax({
	        url: ajaxurl,
	        data: {action:'viad_read_message', msg_id:$(this).data('msg-id')},
	        success:function(json) {
	        	console.log(json);
	        }
	    });

	
	});

	/////////////////////
	// SAVE PREFS
	/////////////////////

	$(document).on('click', '.save-prefs', function(e) {
		e.preventDefault();

		var save = [];
		$('.save').each(function(i) {
			if($(this).val()) {

		    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			    if(re.test($('input[name="u_email"]').val()) == false) {
			    	$('input[name="u_email"]').addClass('empty');
			    } else {
			    	$('input[name="u_email"]').removeClass('empty');
			    }

				if($('input[name="u_password_again"]').val() != $('input[name="u_password"]').val()) {
					$('input[name="u_password_again"]').addClass('empty');
				} else {
					$('input[name="u_password_again"]').removeClass('empty');
				}


				if($(this).is('input[type="checkbox"]')) {
					if($(this).is(':checked')) {
						save.push({  key: $(this).attr('name') , val:1});
					} else {
						save.push({  key: $(this).attr('name') , val:0});
					}
					
				} else  {
					save.push({  key: $(this).attr('name') , val:$(this).val()});
				}
				
				
			}
		});
		
		if($('.empty').length == 0) {
		    $.ajax({
		        url: ajaxurl,
		        data: {
		            action:'viad_save_prefs',
		            save: save
		        },
		        success:function(html) {
					console.log(html);
		        }
		    });
	    }
	 });   

	/////////////////////
	// SWITCH
	/////////////////////
	$(document).on('click', '.switch', function(e){
		e.preventDefault();
		var as = $(this).data('switch-to');
		$('#switch'+as).submit();
	
	});


	/////////////////////
	// REVIEWS
	/////////////////////
	var rating = 0;
	$(document).on('click', '.new-review', function(e){
		e.preventDefault();
		var text = $('#review-text').html();
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            'action':'viad_write_review',
	            'id' : $(this).data('id'),
	            'rating':rating,
	            'text' : text
	        },
			success:function(html) {
				console.log(html);
			}
		});	
	});
	$(document).on('click', '.rate', function(e){
		$('.star').css({'fill':'white'});
		$(this).find('.star').css({'fill':'orange'});
		$(this).prevAll().find('.star').css({'fill':'orange'});
		rating = $(this).attr('class').split(' ')[2].replace('rate_','');
	});
	$(document).on('click', '.approve-review', function(e){
		e.preventDefault();
		var id = $(this).attr('id').split('-')[1];
		var approve = $(this).attr('id').split('-')[0];
		
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            'action':'viad_approve_review',
	            'id' : id,
	            'approve':approve,
	        },
			success:function(html) {
				console.log(html);
			}
		});	
		
	});
	
	/////////////////////
	// NEW ITEM
	/////////////////////
	$(document).on('click', '.new-item', function(e) {
		e.preventDefault();
		var id = $(this).data('id');
		var type = $(this).data('type');
/*   		var container = $(this).data('container');  */
		
		
		var btn = $(this);
	    $.ajax({
	        url: ajaxurl,
	        data: {
	            'action':'viad_new_item',
	            'id' : id,
	            'type' : type
	        },
	        success:function(html) {
	        	if(type == 'projects') {	
					window.location = html;	
				} 
				else if(type == 'blog') {
					btn.before(html);
					btn
					.text('Plaatsen')
					.removeClass('new-item')
					.addClass('save-item');
				}       	
				        	
	        }
	    });
	 });   
	/////////////////////
	// SAVE / PUBLISH PROJECT
	/////////////////////
/*
	$(document).on('click', '.save-project, .publish-project', function(e) {
		e.preventDefault();
		var id = $('#id').val();
		var type = 'projects';		
		var status = 'draft';
		if($(this).hasClass('publish-project')) {
			status = 'publish';
		}
		var title = $('input.title').val();
		var text = $('.text-editor').text();
		var project_pic = $('.project_pic').css('background-image');
		var categories = $("input.category:checkbox:checked").map(function(){
		      return $(this).val();
	    }).get();
		var regions = $("input.regions:checkbox:checked").map(function(){
		      return $(this).val();
	    }).get();
		
		console.log(id,title,text,project_pic,categories,regions);
		
		$.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_save_project',
	            id 	 : id,
	            type:type,
	            status:status,
	            title: title,
	            text : text,
	            project_pic:project_pic,
	            categories:categories,
	            regions:regions
	        },
	        success:function(html) {
				$('section.'+type).html(html);
	        }
		});	
	});
*/

	/////////////////////
	// SAVE ITEM
	/////////////////////
	$(document).on('click', '.save-item', function(e) {
		e.preventDefault();
		var id = $(this).prev().attr('id').split('-');
		var title = $('#'+id[0]+'-'+id[1]+' .new-title').text();
		var text = $('#'+id[0]+'-'+id[1]+' .new-text').text();
		var user = $(this).data('user-id');
		var type = $(this).data('type');
		$.ajax({
	        url: ajaxurl,
	        data: {
	            action:'viad_save_item',
	            id 	 : id[1],
	            type : id[0],
	            user : user,
	            text : text,
	            title: title
	        },
	        success:function(html) {
				$('section.'+type).html(html);
	        }
	    });
				
	
	});

	/////////////////////
	// CATEGORY LIST -> ONCHANGE GET SUB CATEGORY
	/////////////////////
	
	$(document).on('click','.toggle-parent-profession', function(e){
		e.preventDefault();
		var id = $(this).parent().data('id');
		$('.child[data-id="'+id+'"]').toggleClass('visible');
 		$(this).toggleClass('rotate');
	});
	
/*
	$(document).on('change', '.parent input', function(e){
		var id = $(this).parent().data('id');		
		if($(this).is(':checked')) {
			$('.child[data-id="'+id+'"]').show();
		} else {
			$('.child[data-id="'+id+'"]').hide();
		}		
	});

*/

	$(document).on('change', '.child input', function(e){
		var id = $(this).parent().data('id');		
		if($(this).is(':checked')) {
			$('li.parent[data-id="'+id+'"]').find('input').attr('checked','checked');
		} else {
			$('li.parent[data-id="'+id+'"]').find('input').attr('checked','');
		}		
	});


	/////////////////////
	// EDIT PROFILE: PROFESSION ADD REMOVE
	/////////////////////
	$(document).on('click','.add-profession',function(e){
		e.preventDefault();
		var profession = $('.profession:first').clone();
		
		profession.find('option').removeAttr('selected');
		profession.find('option[disabled]').attr('selected','');
				
		$('.profession:last').after(profession);
	});

	$(document).on('click','.remove-profession',function(e){
		e.preventDefault();
		if($('.profession').length > 1) {
			$('.profession:last').remove();
		}
	});
	

});
