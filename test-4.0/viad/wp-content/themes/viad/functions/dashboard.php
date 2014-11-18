<?php

function viad_db_main() {
	$html .= '<h2>Dashboard main</h2>';
	return $html;
}
function viad_db_payment() {
	$html .= '<h2>Betalen</h2>';
	return $html;
}
function viad_db_reviews() {
	$html .= '<h2>Reviews</h2>';
	return $html;
}
function viad_db_projects() {
	$html .= '<h2>Mijn projecten</h2>';
	return $html;
}
function viad_db_favorites() {
	$html .= '<h2>Mijn favorieten</h2>';
	return $html;
}
function viad_db_prefs() {
	$html .= '<h2>Instellingen</h2>';
	return $html;
}
function viad_db_edit_profile() {
	$html .= '<h2>Profiel bewerken</h2>';
	return $html;
}

function viad_db_notifications() {
	$html .= '<h2>Notificaties</h2>';
	
	$messages = get_posts(array('post_type' => 'messages', 'author' => get_current_user_id(), 'posts_per_page' => -1));
	if(count($messages) > 0) {
		$html .= '<ul class="all-messages">';
		foreach($messages as $m) {
			$m_meta = get_post_meta($m->ID);
			if($m_meta['read'][0] == 0) {
				$class = 'unread';
			} else {
				$class = 'read';
			}
			$s_meta = get_user_meta($m_meta['from'][0]); 
			$thumb = wp_get_attachment_image_src( $s_meta['profile_pic'][0], 'thumbnail');
			$html .= '<li class="message '.$class.' all">';
			$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
			$html .= '<a class="msg-title" data-msg-id="'.$m->ID.'" href="#">'.$m->post_title.'</a><br/>';
			$html .= '<a class="msg-from bold" href="'.get_permalink($s_meta['profile_id'][0]).'">'.$s_meta['full_name'][0].'</a>';
			$html .= '<p class="msg-text">'.$m->post_content.'</p>';
			$html .= '<span><div class="icon icon-essential-regular-45-user"></div><a href="#" class="delete" data-id="'.$m->ID.'" data-subject="dit bericht">Verwijderen</a></span>';
			$html .= '</li>';
		}
		$html .= '</ul>';
	} else {
		$html .= '<p>Geen berichten gevonden</p>';	
	}	
	
	
	return $html;

}

function viad_db_nav() {

	$html .= '<a class="button gray" href="'.get_permalink(viad_get_profile_id()).'">Profiel</a>';

	$html .= '<ul class="tab-menu">';
	$html .= '<li><a href="#/dashboard"><div class="icon">]</div>Dashboard</span></li>';
	$html .= '<li><a href="#/notificaties"><div class="icon">]</div>Notificaties</a></li>';
	$html .= '<li><a href="#/reviews"><div class="icon">]</div>Reviews</a></li>';
	$html .= '<li><a href="#/projecten"><div class="icon">]</div>Mijn projecten</a></li>';
	$html .= '<li><a href="#/favorieten"><div class="icon">]</div>Mijn favorieten</a></li>';
	$html .= '<li><a href="#/instellingen"><div class="icon">]</div>Mijn favorieten</a></li>';
	$html .= '<li><a href="#/bewerken"><div class="icon">]</div>Profiel bewerken</a></li>';
	$html .= '<li><a href="#/betalen"><div class="icon">]</div>Betalen</a></li>';
	$html .= '</ul>';

	return $html;
}

function viad_read_message() {
	update_post_meta($_REQUEST['msg_id'],'read',1);
	exit();
}
add_action( 'wp_ajax_viad_read_message', 'viad_read_message' );

/*
function viad_display_professionals_db() {
	
	$html .= '<div class="container">';
	$html .= '<aside class="left">';
	$html .= 'dashboard left<br/>';
	$html .= '</aside>';
	$html .= '<div class="content">';
	$html .= viad_db_main();
	$html .= '</div>';
	
	return $html;

}
*/

function viad_display_companies_db() {
	
	$html .= '<div class="container">';
	
	$html .= '<h2>Dashboard</h2>';

	$html .= '<div class="third messages-widget">';
	$html .= viad_notifications_widget();
	$html .= '</div>';


	$html .= '<div class="third professionals-widget">';
	$html .= viad_professionals_widget();
	$html .= '</div>';


	$html .= '<div class="third professionals-widget">';
	$html .= viad_projects_widget();
	$html .= '</div>';

	$html .= '<div class="third">';
	$html .= viad_prefs_widget();
	$html .= '</div>';


	$html .= '</div>';
	
	return $html;

}

function viad_save_prefs() {
	$user_id = get_current_user_id();
	print_r($_REQUEST);

	foreach($_REQUEST['save'] as $i => $save) {
			
			if(substr($save['key'], 0, 2) == 'um') {
				$key = str_replace('um_','',$save['key']);
				update_user_meta($user_id, $key, $save['val']);
			} else if(substr($save['key'], 0, 2) == 'u_') {
				$key = str_replace('u_','',$save['key']);
			}
			
			if($key == 'email') {
				wp_update_user( array( 'ID' => $user_id, 'user_email' => $save['val'] ) );
			}
			
			if($key == 'password') {
				wp_update_user( array( 'ID' => $user_id, 'user_pass' => $save['val'] ) );
			}
		
	
	}
	exit();
}
add_action( 'wp_ajax_viad_save_prefs', 'viad_save_prefs' );

function viad_prefs_widget() {
	$html .= '<h3 class="widget-title">Instellingen</h3>';
	
	$user = wp_get_current_user();
	$user_meta = get_user_meta($user->ID);

	$html .= '<p style="margin-left:30px;">';
	if($user_meta['email_notifications'][0] == 1) {
		$checked = 'checked="checked"';
	}

	$html .= '<input class="save" name="um_email_notifications" id="i1" type="checkbox" '.$checked.'/><label for="i1">Notificaties per email sturen</label>'; 
	$html .= '</p>';
	
	$html .= '<p>Emailadres</p>';
	$html .= '<input class="save" type="email" name="u_email" value="'.$user->user_email.'" />';

	$html .= '<p>Nieuw wachtwoord (alleen als je het wachtwoord wilt wijzigen)</p>';
	$html .= '<input class="save" type="password" name="u_password" />';
	
	$html .= '<p>Nieuw wachtwoord herhalen</p>';
	$html .= '<input class="save" type="password" name="u_password_again" />';
	$html .= '<br class="clear"/>';
	$html .= '<a href="#" class="button save-prefs">Instellingen opslaan</a>';
		
	return $html;
	
}

function viad_spotlight_widget() {
	$html .= '<h3 class="widget-title">Spotlight</h3>';

	$user_id = get_current_user_id();
	$user_meta = get_user_meta($user_id);

	$html .= '<p style="margin-left:30px;">';
	if(viad_user_in_spotlight($user_id)) {
		$points = viad_spotlight_points_left($user_meta['spotlight_start'][0], $user_meta['spotlight_points'][0]);
		$checked = 'checked="checked"';
	} else {
		$user_meta = get_user_meta($user_id);
		$points = $user_meta['spotlight_points'][0];
	}
	$dagen = 'dagen';
	if($points == 1) {
		$dagen = 'dag';
	}
	$html .= '<input id="i0" type="checkbox" '.$checked.' class="toggle-spotlight"/><label for="i0">Zet jezelf nog '.$points.' '.$dagen.' in de spotlight</label>'; 

	$html .= '</p>';
	
	
	return $html;
}

function viad_professionals_widget() {
	$html .= '<h3 class="widget-title">Mijn professionals</h3>';
	$professionals = get_user_meta(get_current_user_id(),'is_professional');
	$html .= '<ul class="widget professionals">';
	foreach ($professionals as $prof_id) {
		$prof = get_userdata($prof_id);
		$user_meta = get_user_meta($prof->ID);
		$profile_meta = get_post_meta($user_meta['profile_id'][0]);
		$thumb = wp_get_attachment_image_src( $profile_meta['profile_pic'][0], 'thumbnail');
		$html .= '<li class="professional">';
		$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
		$html .= '<form style="display:none;" id="switch'.$prof->ID.'" method="post" action="'.get_permalink($user_meta['profile_id'][0]).'"><input type="hidden" name="as" value="'.$prof->ID.'"><input type="hidden" name="self" value="'.get_current_user_id().'"></form>';
		$html .= '<a class="switch bold" href="#" data-switch-to="'.$prof->ID.'">'.$user_meta['full_name'][0].'</a><br/>';
		$html .= '<span>'.$profile_meta['profession'][0].'</span>';
		$html .= '</li>';
	}
	$html .= '</ul>';
	return $html;
}


function viad_projects_widget() {
	// Mijn projecten op companies Dashboard
	$html .= '<h3 class="widget-title">Mijn projecten</h3>';
	
	
	$projects = get_posts(array('post_type' => 'projects', 'post_parent' => 0, 'author' => get_current_user_id()));
	
	$html .= '<ul class="widget jobs">';	
	foreach($projects as $project) {
		$project_meta = get_post_meta($project->ID);
		$thumb = wp_get_attachment_image_src( $project_meta['background_pic'][0], 'thumbnail');
		
		$gray = '';
		if($project->post_status == 'draft') {
			$gray = 'gray';
		}
		$html .= '<li class="job '.$gray.'">';
		$html .= '<div class="thumb" style="background-image:url('.$thumb[0].');"></div>';
		$html .= '<a class="bold" href="'.get_permalink($project->ID).'">';
		$html .= $project->post_title;
		$html .= '</a>';
		$html .= '<br/>';


		
		$str = 'professionals';
		if(count($project_meta['subscribed']) ==1 ) { 
			$str = 'professional';
		}
		$html .= '<span><div class="icon icon-essential-regular-45-user"></div> '.count($project_meta['subscribed']).' '.$str.' ingeschreven</span>';
		$html .= '<span><a href="'.get_permalink($project->ID).'#/edit-project"><div class="icon icon-essential-regular-42-pen"></div>Project bewerken</a></span>';

		$html .= '<br class="clear" />';
		$html .= '</li>';
		
	
	
	}
	$html .= '</ul>';	

	$html .= '<a class="button new-item" data-type="projects">Nieuw project</a>';


	return $html;
}

function viad_jobs_widget() {
	// Mijn projecten op professionals Dashboard

	$html .= '<h3 class="widget-title">Mijn projecten</h3>';
	$profile_id = get_user_meta(get_current_user_id(),'profile_id');
	
	
	$job_ids = get_post_meta($profile_id[0], 'subscribed');
	
	if($job_ids) {
		$jobs = get_posts(array('post__in' => $job_ids, 'post_type' => 'projects'));
		$html .= '<ul class="jobs">';
		foreach($jobs as $job) {
		
		
		
			$job_meta = get_post_meta($job->ID);
			$project_meta = get_post_meta($job->post_parent);
			$owner_meta = get_user_meta($job->post_author);


					
			$thumb = wp_get_attachment_image_src( $owner_meta['profile_pic'][0], 'thumbnail');
	
			$html .= '<li class="job">';
			$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
			$html .= '<a class="bold" href="'.get_permalink($job->ID).'">';
			$html .= $job->post_title;
			$html .= '</a>';
			$html .= '<br/>';
			$html .= '<a href="'.get_permalink($owner_meta['profile_id'][0]).'">'.$owner_meta['full_name'][0].'</a>';
			$html .= '<br/>';
			
			$html .= '<span><div class="icon icon-essential-regular-86-clock"></div> '.date_i18n('j F Y', $job_meta['deadline'][0]).'</span>';
			
			$str = 'professionals';
			if(count($project_meta['subscribed']) ==1 ) { 
				$str = 'professional';
			}
			$html .= '<span><div class="icon icon-essential-regular-45-user"></div> '.count($job_meta['subscribed']).' '.$str.' ingeschreven</span>';
			$html .= '<a href="'.get_permalink($job->ID).'">'.viad_arrow_svg('blue').'</a>';
			$html .= '<br class="clear"/>';
			$html .= '</li>';
		}
		
		$html .= '</ul>';
	} else {
		$html .= '<p>Geen projecten gevonden</p>';
	}	
	return $html;
}



function viad_favorites_widget() {

	if(viad_get_favorites()) {
		$favorites = get_posts(array('post__in' => viad_get_favorites(), 'post_type' => 'projects'));
	
	
		$html .= '<h3 class="widget-title">Mijn favorieten';
		if(count($favorites) > 0) {		
			$html .= '<div class="notification-count">'.count($favorites).'</div>';
		}	
		$html .= '</h3>';
		
		$html .= '<ul class="favorites">';
		
		foreach($favorites as $fav) {
			
			$fav_meta = get_post_meta($fav->ID);
			$project_meta = get_post_meta($fav->post_parent);
			$owner_meta = get_user_meta($fav->post_author);
			
					
			$thumb = wp_get_attachment_image_src( $owner_meta['profile_pic'][0], 'thumbnail');
	
			$html .= '<li class="favorite">';
			$html .= '<a href="#" class="toggle-favorite" data-id="'.$fav->ID.'">'.viad_star_svg('blue').'</a>';
			$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
			$html .= '<a class="bold" href="'.get_permalink($fav->ID).'">';
			$html .= $fav->post_title;
			$html .= '</a>';
			$html .= '<br/>';
			$html .= '<a href="'.get_permalink($owner_meta['profile_id'][0]).'">'.$owner_meta['full_name'][0].'</a>';
			$html .= '<br/>';
			
			$str = 'professionals';
			if(count($project_meta['subscribed']) ==1 ) { 
				$str = 'professional';
			}			

			$html .= '<span><div class="icon icon-essential-regular-86-clock"></div> '.date_i18n('j F Y', $fav_meta['deadline'][0]).'</span>';
			$html .= '<span><div class="icon icon-essential-regular-45-user"></div> '.count($fav_meta['subscribed']).' '.$str.' ingeschreven</span>';
	
			$html .= '<a href="'.get_permalink($fav->ID).'">'.viad_arrow_svg('blue').'</a>';
	
			$html .= '<br class="clear"/>';
			
			$html .= '</li>';
			
		}
		$html .= '</ul>';

	} else {
		$html .= '<h3 class="widget-title">Mijn favorieten</h3>';
		$html .= '<p>Geen favorieten gevonden</p>'	;
	}
	
	return $html;
	
}


function viad_notifications_widget() {
	
	$user_id = get_current_user_id();

	$unread_messages = get_posts(array('post_type' => 'messages', 'author' => $user_id, 'posts_per_page' => -1, 'meta_key' => 'read', 'meta_value' => '0', 'orderby' => 'post_date'));
	
	$messages = get_posts(array('post_type' => 'messages', 'author' => $user_id, 'posts_per_page' => 5));
	$html .= '<h3 class="widget-title">Notificaties ';
	if(count($unread_messages) > 0) {		
		$html .= '<div class="notification-count red">'.count($unread_messages).'</div>';
	}	
	$html .= '</h3>';
	
	if(count($messages) > 0) {
		$html .= '<ul class="messages">';
		foreach($messages as $m) {
			$m_meta = get_post_meta($m->ID);
			if($m_meta['read'][0] == 0) {
				$class = 'unread';
			} else {
				$class = 'read';
			}
			$s_meta = get_user_meta($m_meta['from'][0]); 
			$thumb = wp_get_attachment_image_src( $s_meta['profile_pic'][0], 'thumbnail');
			$html .= '<li class="message '.$class.'">';
			$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
			$html .= '<a class="msg-title" data-msg-id="'.$m->ID.'" href="#">'.$m->post_title.'</a><br/>';
			$html .= '<a class="msg-from bold" href="'.get_permalink($s_meta['profile_id'][0]).'">'.$s_meta['full_name'][0].'</a>';
			$html .= '<p class="msg-intro">'.substr($m->post_content, 0, 30).'...</p>';
			$html .= '<p class="msg-text">'.$m->post_content.'</p>';
			$html .= '</li>';
		}
		$html .= '<br class="clear" />';
		$html .= '<a href="'.home_url().'#/all-messages" class="button all-messages">Alle notificaties</a>';
		$html .= '</ul>';
	} else {
		$html .= '<p>Geen berichten gevonden</p>';	
	}	
	
	return $html;
}
















?>