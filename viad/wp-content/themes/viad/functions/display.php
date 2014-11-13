<?php
function viad_display_project_card($p_id) {
	
	$project = get_post($p_id);

	$pm = get_post_meta($p_id);
	$cats = wp_get_post_categories( $p_id);

	$html .= '<div class="third project card">';			
	$html .= '<div class="title">';
	$favorites = viad_get_favorites();
	
	
	if($favorites) {
		if(in_array($p_id, $favorites)) {
			$html .= '<a href="#" class="toggle-favorite" data-id="'.$p_id.'">'.viad_star_svg('blue').'</a>';
		} else {
			$html .= '<a href="#" class="toggle-favorite" data-id="'.$p_id.'">'.viad_star_svg().'</a>';
		}
	}
	$html .= '<a href="'.get_permalink($p_id).'">';
	$html .= '<h3>'.$project->post_title.'</h3>';
	$html .= '</a>';
	$html .=  '</div>';				
	$html .= '<div class="content">';
	$html .= '<p>'.date_i18n('F Y', $pm['start_date'][0]).'</p>';
	$tags = wp_get_post_tags($p_id);
	$html .= '<p>';
	foreach($tags as $t) {
		$level = $pm['level_'.$t->term_id][0];
		$html .= $t->name.' '.$level;
	}
	$html .= '</p>';
	$html .= '<p>';
	$cats = wp_get_post_categories($p_id);
	foreach($cats as $c) {
		$cat = get_category($c);
		$html .= $cat->name.', ';
	}
	$html .= '</p>';
	$html .=  '</div>';		
	
	$img = wp_get_attachment_image_src($pm['background_pic'][0], 'medium');

	$html .= '<div class="project-image" style="background-image:url('.$img[0].');"></div>';
	$html .=  '</div>';				
	
	return $html;
}

function viad_display_statistics($post_id) {
	
	$meta = get_post_meta($post_id);
	
	$post = get_post($post_id);	
	$owner_meta = get_user_meta($post->post_author);
	
	if($post->post_type == 'professionals') {
		$html =  '<h2>4.5</h2>';
		$html .= '<p>Gemiddelde waardering</p>';

		$html .= '<h2>12</h2>';
		$html .= '<p>Reviews</p>';
		
		$euro = '';
		if(is_numeric($meta['price'][0])) {
			$euro = '&euro; ';
		}
	
		$html .= '<h2>'.$euro.$meta['price'][0].'</h2>';
		$html .= '<p>Uurtarief</p>';

		$html .= '<h2>11</h2>';
		$html .= '<p>Opdrachten afgerond</p>';
	
	
		$html .= '<h2>'.$meta['region'][0].'</h2>';
		$html .= '<p>Regio</p>';
	} else if($post->post_type == 'projects') {


		$html .= '<p>Deadline inschrijvingen</p>';
		$html .= '<h2>'.date_i18n('j M y', $meta['deadline'][0]).'</h2>';

		$html .= '<p>Start datum</p>';
		$html .= '<h2>'.date_i18n('j M y', $meta['start_date'][0]).'</h2>';

		$html .= '<p>Eind datum</p>';
		$html .= '<h2>'.date_i18n('j M y', $meta['end_date'][0]).'</h2>';
		
		if($post->post_parent != 0) {
			$html .= '<p>Professionals ingeschreven</p>';
			$html .= '<h2>'.count($meta['subscribed']).'</h2>';
			
			$euro = '';
			if(is_numeric($meta['price'][0])) {
				$euro = '&euro; ';
			}


			$html .= '<p>Uurtarief</p>';
			$html .= '<h2>'.$euro.$meta['price'][0].'</h2>';
	
			$html .= '<p>Regio</p>';
			$html .= '<h2>'.$meta['region'][0].'</h2>';

		} 
		
		$html .= '<p>Opdrachtgever</p>';
		$html .= '<h2><a href="'.get_permalink($owner_meta['profile_id'][0]).'">'.$owner_meta['full_name'][0].'</a></h2>';
		
	
	}

	if(viad_is_author($post->post_author) == true && $post->post_type == 'companies' ||viad_is_author($post->post_author) == true && $post->post_type == 'professionals') {
		$html .= '<div class="editor">';
		$html .= '<a class="button edit-profile">Profiel bewerken</a>';
		$html .= '</div>';
	} else if(viad_is_author($post->post_author) == true && $post->post_type == 'projects') {

		$html .= '<div class="editor">';
		$html .= '<a class="button edit-project" data-id="'.$post->ID.'">Project bewerken</a>';
		$html .= '<a class="button delete" data-id="'.$post->ID.'" data-subject="dit project">Verwijderen</a>';
		$html .= '</div>';

	}


	
	return $html;
}

function viad_display_jobs($post_id) {

	$p = get_post($post_id);
	$meta = get_post_meta($post_id);
	$jobs = get_posts(array('post_type'=>'projects', 'post_parent'=>$post_id ));

		
	$background_pic = wp_get_attachment_image_src( $meta['background_pic'][0], 'medium');	
	$favorites = array();
	if (is_user_logged_in()) {
		$favorites = viad_get_favorites();
	}	
	
	foreach($jobs as $o) {
		$o_meta =  get_post_meta($o->ID);	

		$html .= '<div class="third project">';			
		
		$html .= '<div class="title">';

		$html .= '<a href="'.get_permalink($o->ID).'">';
		$html .= '<h4>'.$p->post_title.'</h4>';
		$html .= '</a>';
		
		if(in_array($o->ID, $favorites)) {
			$html .= '<a href="#" class="toggle-favorite" data-id="'.$o->ID.'">'.viad_star_svg('blue').'</a>';
		} else {
			$html .= '<a href="#" class="toggle-favorite" data-id="'.$o->ID.'">'.viad_star_svg().'</a>';
		}

		
		$html .= '<a href="'.get_permalink($o->ID).'">';
		$html .= '<h3>'.$o->post_title.'</h3>';
		$html .= '</a>';

		$html .=  '</div>';				

		$html .= '<div class="content">';
		$html .= '<p>'.date_i18n('F Y', $o_meta['start_date'][0]).'</p>';
		$html .= '<p>'.viad_content($o->post_content).'</p>';
		$html .=  '</div>';				

		$html .= '<div class="project-image" style="background-image:url('.$background_pic[0].');"></div>';
		$html .=  '</div>';				
	
	
	}
	
	
	return $html;

}

function viad_display_profile_head($id) {
	
	if(is_front_page()) {
	// User dashboard	
		$user_id = get_current_user_id();	
		$posts = get_posts(array('post_type' => array('companies','professionals'), 'author' => $user_id));
		$post = $posts[0];
	} else {
	// User profile or other profile
		$post = get_post($id);
		$user_id = $post->post_author;
	}
	
	
	$p_meta = get_post_meta($post->ID);
	if($post->post_type == 'projects' && $post->post_parent != 0) {
		
		$title = get_the_title($post->post_parent);
		$subtitle = $post->post_title;	
	
	} else {
		$title = $post->post_title;
		$subtitle = $p_meta['profession'][0];
	}
	
	
	$user_meta = get_user_meta($user_id);
	$thumb = wp_get_attachment_image_src( $user_meta['profile_pic'][0], 'thumbnail');
	

	$html = '';
	$html .= '<div class="container">';
	$html .= '	<div class="thumbnail profile_pic" style="background-image:url('.$thumb[0].');"></div>';
	$html .= '  <div class="title">';

	$html .= '		<h2>'.$title.'</h2>';
	$html .= '		<h3>'.$subtitle.'</h3>';
	
	$html .= '	</div>';
	$html .= '</div>';
	
	return $html;
}


function viad_content($c) {
	$content = apply_filters( 'the_content', $c );
	$content = str_replace( ']]>', ']]&gt;', $content );
	
	preg_match_all("^\[(.*?)\]^",$content,$meta);
	
	if($meta) {
		foreach($meta as $m) {
			$content = str_replace($m,'',$content);
		}
	}
	
	return $content;		
}

function viad_display_searchbar() {

	if(is_archive()) {
		$html =	'<div class="search">';

		$html .=  '<div class="container">';
		
		$html .= '<h2>Zoeken</h2>';
		$html .= '<div class="search-bar">';
		$html .=  '<input class="search" data-in="project" type="text" placeholder="Zoek op titel, bedrijf, regio, vakgebied"/>';
		$html .= '<a href="#" class="button search-button">Zoeken</a>';		
		$html .= '</div>';	
		$html .= '</div>';	
		$html .= '</div>';	

	}
	return $html;
}



function viad_archive_projects($type = 'archive') {

	
	$html = '<div class="container">';
	if($type == 'frontpage') {
		echo '<h2>Nieuw</h2>';
	}
	$html .='<div id="projects-list">';
	
	if($type == 'frontpage') {
		$projects = get_posts(
			array(
				'post_type' => 'projects', 
				'posts_per_page' => 10, 
				'orderby' => 'meta_value',
				'meta_key' => 'start_date',
				'order' => 'ASC'
			));
	} else {

		$projects = get_posts(
			array(
				'post_type' => 'projects', 
				'posts_per_page' => -1, 
				'orderby' => 'meta_value',
				'meta_key' => 'start_date',
				'order' => 'ASC'
		));
	}
	$favorites = array();
	if (is_user_logged_in()) {
		$favorites = viad_get_favorites();
	}

	
	foreach($projects as $p) {
		
		$html .= viad_display_project_card($p->ID);

	}
	
	$html .=  '</div>';
	$html .=  '</div>';	
	
	
	
	return $html;
}

function viad_display_projects($user_id) {
	$html =	 '<div class="container">';

	$html .= '<h2>Projecten</h2>';
	$projects = get_posts(array('post_type' => 'projects','author' => $user_id, 'posts_per_page' => -1));
	foreach ($projects as $p) {
		$html .= '<a href="'.get_permalink($p->ID).'">'.$p->post_title.'</a><br/>';
	}
	$html .= '</div>';
	
	
	if(viad_is_author($user_id)) {
		$html .= '<a href="#" class="button new-item" data-type="projects" data-user-id="'.$user_id.'" data-container="new-project">Nieuw project</a>';
	}
	
	return $html;	
}
function viad_display_user_projects() {
	$html =	 '<div class="container">';

	$html .= '<h2>Opdrachten</h2>';

	$html .= '</div>';
	
}



function viad_display_reviews($user_id) {

	$html = '<div class="container">';
	$html .=  '<h2>Reviews</h2>';
	
	$profile_id = get_user_meta($user_id, 'profile_id');	
	$profile = get_post($profile_id[0]);
	
	
	$reviews = get_posts(array('post_type' => 'reviews', 'author' => $user_id, 'meta_key'=>'approved','meta_value'=>1));
	
	echo '<ul class="reviews">';
	foreach($reviews as $r) {
		$r_meta = get_post_meta($r->ID);
		$w_meta = get_user_meta($r_meta['written_by'][0]);

		$html .=  '<li class="review">';
		$thumb = wp_get_attachment_image_src( $w_meta['profile_pic'][0], 'thumbnail');
		$html .= '<div class="thumb" style="background-image:url('.$thumb[0].')"></div>';
		$html .= '<div class="review-content">';
		$html .=  '<h4>'.$w_meta['full_name'][0].'<br/>';
		$html .= '<span>'.date_i18n('j F Y', strtotime($r->post_date)).'</span></h4>';
		$html .=  '<p>'.$r->post_content.'</p>';
		$html .= '</div>';
		
		$html .= '<div class="rating">';

		$html .= '<p>Waardering</p>';
		for($i = 0; $i < 5; $i++) {
			if($i < $r_meta['rating'][0]) {
				$html .= viad_star_svg('rate-star yellow');
			} else {
				$html .= viad_star_svg('rate-star white');
			}
		}
		$html .= '<h2>'.$r_meta['rating'][0].'</h2>';
		
		$html .= '</div>';
		
		$html .= '<br class="clear" />';
		$html .=  '</li>';	
	}	
	$html .=  '</ul>';
	
	
	if(!viad_is_author($profile->post_author)) {
		$html .= '<div id="review-text" contenteditable="true">Schrijf iets over...</div>';	
		$html .= '<div class="review-rate-star">';
		$html .= viad_star_svg('rate rate_1');
		$html .= viad_star_svg('rate rate_2');
		$html .= viad_star_svg('rate rate_3');
		$html .= viad_star_svg('rate rate_4');
		$html .= viad_star_svg('rate rate_5');
		$html .= '</div>';
		$html .= '<a href="#" class="button ongreen new-review" data-id="'.$user_id.'">Review plaatsen</a>';
	}
	
	$html .= '</div>';//container

	return $html;	

}

function viad_display_calendar($user_id, $start = 0, $end = 5) {


	$html .= '<div class="container">';
	
	

	$html .= '<h2>Agenda</h2>';

	$html .= '<div class="browse-calendar-container">';
	if($start > 0) {
		$html .= '<a style="float:left;" href="#" class="browse-calendar" data-id="'.$user_id.'" data-start="'.($start-1).'" data-end="'.($end-1).'"><div class="icon icon-essential-regular-01-chevron-left"></div></a>';
	}
	$html .= '<a  style="float:right;" href="#" class="browse-calendar"  data-id="'.$user_id.'" data-start="'.($start+1).'" data-end="'.($end+1).'"><div class="icon icon-essential-regular-02-chevron-right"></div></a>';
	$html .= '</div>';
	
	$user_na = get_user_meta($user_id, 'viad_not_available', true);
	$subscribed_projects =  viad_get_subscribed_projects();
	$projects = get_posts(array('post__in' => $subscribed_projects,'post_type'=>'projects'));
	$project_dates = array();
	foreach($projects as $p) {
		 $start_date = get_post_meta($p->ID, 'start_date');
		 $end_date = get_post_meta($p->ID, 'end_date');

		for($i = $start_date[0]; $i < $end_date[0]; $i += 86400) {
			$project_dates[$i] = $p->ID;
		}
	}
	
	for($i = $start; $i < $end; $i++) {

		$month =  strtotime('now + '.$i.' month');
		$class = '';
		if($i == 0) {
			$class = 'this-month';
		}
		$html .= '<div class="month">';
		$html .= '<div class="title '.$class.'"><h5 class="bold">'.date_i18n('F Y', $month).'</h5></div>';
		$days = date('t', $month) + 1;
		$m = date('m', $month);
		$y = date('Y', $month);
		$html .= '<div class="days">';
		$html .= '<div class="day bold">M</div>';
		$html .= '<div class="day bold">D</div>';
		$html .= '<div class="day bold">W</div>';
		$html .= '<div class="day bold">D</div>';
		$html .= '<div class="day bold">V</div>';
		$html .= '<div class="day bold">Z</div>';
		$html .= '<div class="day bold">Z</div>';
		$days_last_month = date('t', strtotime('01-'.($m-1).'-'.$y));
		$day_offset_start = date('N', strtotime('01-'.$m.'-'.$y));
		for($d = 1; $d < $day_offset_start; $d++) {
			$html .= '<div class="day gray">'.($days_last_month - $day_offset_start + $d +1).'</div>';
		}
		for($d = 1; $d < $days; $d++) {
			$class = '';
			if($d == date('j') && $i == 0) {
				$class = ' today';
			}
			$time_stamp = strtotime($d.'-'.$m.'-'.$y.' 00:00');

			if($user_na) {			
				if(in_array($time_stamp, $user_na)) {
					$class .= ' na';
				}
			}
			if($project_dates[$time_stamp]) {
				$class .= ' orange';
				$project_id = $project_dates[$time_stamp];

				$html .= '<a href="'.get_permalink($project_id).'" title="'.get_the_title($project_id).'">';
				$html .= '<div class="day'.$class.'" data-timestamp="'.$time_stamp.'">'.$d.'</div>';
				$html .= '</a>';

			} else {
				$html .= '<div class="day'.$class.'" data-timestamp="'.$time_stamp.'">'.$d.'</div>';
			}
		}		
		$day_offset_end = 42-($days+$day_offset_start) + 2;

		for($d = 0; $d < $day_offset_end; $d++) {
			$html .= '<div class="day gray">'.($d+1).'</div>';
		}
		$html .= '</div>'; // .days
		$html .= '</div>'; // .month
	}
	if(viad_is_author($user_id)) {
		$html .= '<div class="editor">';
		$html .= '<a class="button edit edit-calendar" data-user-id="'.$user_id.'" data-type="calendar">Edit</a>';
		$html .= '</div>';
	}
	
	$html .= '</div>';
	
	return $html;
}



function viad_display_user_info() {
	$html = '';
	if ( is_user_logged_in() ) {

		$user = wp_get_current_user();
		$user_meta = get_user_meta($user->ID);
		
		

		$thumb = wp_get_attachment_image_src( $user_meta['profile_pic'][0], 'thumbnail');


	 	$profile = get_post($user_meta['profile_id'][0]);
		$p_meta = get_post_meta($profile->ID);
		
		$tags = get_the_tags($profile->ID);		
		if($tags) {
			$tags = reset($tags);
		}
		
		$messages = get_posts(array('post_type' => 'messages', 'author' => $user->ID, 'meta_key' => 'read','meta_value'=> 0, 'posts_per_page' => -1));
		
		$msg_count = count($messages);
		$html .= '<input class="user_logged_in" type="hidden" />';
		$html .= '<div class="title">';

		if($msg_count) {
			$html .= '<div class="msg-count">'.$msg_count.'</div>';
		}

		$html .= '<div class="thumb profile_pic" style="background-image:url('.$thumb[0].');"></div>';
	 	$html .= '<h4><a href="'.get_permalink(viad_get_profile_id()[0]).'">'.$user_meta['full_name'][0].'</a></h4>';
		if($tags->name) {
			$html .= '		<h5>'.$tags->name.'</h5>';
		} else {
			$html .= '		<h5>&nbsp;</h5>';
		}	 	
	 	$html .= '</div>';
	 	
	 	if($_POST['self']) {
/* 	 	

	switch terug naar eigen profiel 

*/
//	 		$html .= '<form style="display:none;" id="switch'.$_POST['self'].'" method="post" action="/viad-trunk/viad/"><input type="hidden" name="as" value="'.$_POST['self'].'"></form>';
//			$html .= '<a class="button switch" href="#" data-switch-to="'.$_POST['self'].'">Terug</a>';
	 	} else {
	 		$html .= '<div id="info-notification">';
			$html .= '<a class="button" href="'.wp_logout_url(home_url()).'" title="Logout">Logout</a>';
			$html .= '</div>';
	 	}
	 	
	 	
 	} else {
 		
 		
 		$html .=  wp_login_form(array('echo'=>false, 'label_remember' => __( 'Onthouden' )));


 	
 	}

	return $html;
}

function viad_display_logo_svg($class) {
	return '<svg version="1.1" class="logo-svg '.$class.'" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
		 width="116px" height="32px" viewBox="0 0 116 32" enable-background="new 0 0 116 32" xml:space="preserve">
	<g>
		<polygon points="24.114,0.002 15.883,22.182 7.648,0.002 0,0.002 12.732,31.719 18.854,31.719 31.271,0.002 	"/>
		<rect x="37.128" width="6.931" height="31.719"/>
		<path d="M108.704,15.86c0-5.619-3.851-9.562-9.562-9.562h-5.391V25.42h5.391c5.711,0,9.562-3.853,9.562-9.47V15.86z
			 M99.143,31.719H86.771V0h12.372C109.111,0,116,6.842,116,15.769v0.092C116,24.786,109.111,31.719,99.143,31.719"/>
		<polygon points="81.046,31.719 73.577,31.719 65.346,9.539 57.111,31.719 49.705,31.719 62.198,0 68.315,0 	"/>
	</g>
	</svg>';
}

function viad_display_blog($user_id) {
	$html =	'<div class="container">';
	$html .= '<h2>Blog</h2>';
	$html .=	'<div>';
	$blog = get_posts(array('post_type' => 'blog','author' => $user_id, 'posts_per_page' => -1));
	$year = date('Y');
	$html .= '<div class="container"><p>'.$year.'</p>';
	if($blog) {
		$i = 0;
		foreach($blog as $b) {
			if(date('Y',strtotime($b->post_date)) < $year) {
				$year = date('Y',strtotime($b->post_date));
				$html .= '</div>';	
				$html .= '<div class="container"><p>'.$year.'</p>';
				$i = 0;
			}
			if($i%2==0) {
				$class = 'left';			
			} else {
				$class = 'right';			
			}
			$html .= '<article class="'.$class.'">';
			$html .= '<h3>'.$b->post_title.'</h3>';			
			$html .= viad_content($b->post_content);
			$html .= '<div class="date">';
			$html .= $b->post_date;
			$html .= '</div>';
			$html .= '</article>';
			$i++;
		}
	} else {
		$html .= '<article>';
		$html .= '<p>Niets gevonden</p>';
		$html .= '</article>';

	}
	$html .=	'<div>';
	if(viad_is_author($user_id)) {
		$html .= '<br class="clear" />';
		$html .= '<div class="editor">';
		$html .= '<a class="button edit onblue new-item" data-id="'.$user_id.'" data-type="blog">Nieuw bericht</a>';
		$html .= '</div>';
	}
	$html .= '</div>';
	return $html;
}


?>