<?php

/*

$users = get_users();

foreach($users as $u) {

	$usermeta = get_user_meta($u->ID);
	print_r($u->ID);
	echo '<br/><br/>';
	print_r($usermeta);
	$fullname = $usermeta['first_name'][0];
	if($usermeta['last_name'][0]) {
		$fullname .= ' '.$usermeta['last_name'][0];
	}
	
	update_user_meta($u->ID, 'full_name', $fullname);	
}
*/

function viad_browse_calendar() {
	$update = array();
	$update[0]['container'] = 'section.profile.calendar';
	$update[0]['html'] = viad_display_calendar($_REQUEST['id'], $_REQUEST['start'], $_REQUEST['end']);

	echo json_encode($update);
	exit();
}
add_action( 'wp_ajax_viad_browse_calendar', 'viad_browse_calendar' );

function viad_write_review() {

	$user_meta = get_user_meta(get_current_user_id(),'full_name');

	$post = array('post_type' => 'reviews', 'post_title' => $user_meta[0], 'post_content' => $_REQUEST['text'], 'post_author' => $_REQUEST['id'], 'post_status' => 'publish');
	$post_id = wp_insert_post($post);
	update_post_meta($post_id, 'approved', 0);
	update_post_meta($post_id, 'rating', $_REQUEST['rating']);
	update_post_meta($post_id, 'written_by', get_current_user_id());
	update_post_meta($post_id, 'status', 'draft');
	
	$msg_content = $_REQUEST['text'].' (Rating '.$_REQUEST['rating'].')<br/>';
	$msg_content .= '<a href="#" id="a-'.$post_id.'" class="approve-review">Plaatsen</a> ';	
	$msg_content .= '<a href="#" id="d-'.$post_id.'" class="approve-review">Afwijzen</a>';	

	viad_send_message($_REQUEST['id'], get_current_user_id(), 'Review van '.$user_meta[0], $msg_content);
	
	exit();
}
add_action( 'wp_ajax_viad_write_review', 'viad_write_review' );

function viad_edit_profile() {
	
	echo viad_display_edit_profile();	
	die();
}
add_action( 'wp_ajax_viad_edit_profile', 'viad_edit_profile' );

function viad_save_profile() {
	$u_id = get_current_user_id();
	$u_meta = get_user_meta($u_id);	
	$p_id = $u_meta['profile_id'][0];
	
	$tags = array();
	$cats = array();

	$search_str = '[';

	
	
	foreach($_REQUEST['save'] as $i => $save) {
		if(substr($save['key'],0,2) == 'um') {
			$key = str_replace('um_','',$save['key']);
			update_user_meta($u_id, $key, $save['val']);
			
			if($key == 'full_name') {
				wp_update_post(array('ID' => $p_id, 'post_title' => $save['val']));
				update_user_meta($u_id, 'full_name', $save['val']);

			}
			
		} else if(substr($save['key'],0,2) == 'pm') {
			$key = str_replace('pm_','',$save['key']);
			update_post_meta($p_id, $key, $save['val'], false);
		}
		
		if($save['key'] == 'profession') {
			$tag = get_tag($save['val']);
			$tags[] .= $tag->name;	
			update_post_meta($p_id, 'level_'.$tag->term_id, $_REQUEST['save'][$i +1]['val'], false);
			$search_str .= $tag->name.' '.$_REQUEST['save'][$i +1]['val'].' ';
			
		}

		if($save['key'] == 'category') {
			$cats[] .= $save['val'];
			$category = get_category($save['val']);
			$search_str .= $category->name.' '; 			
		}
		
		if($save['key'] == 'profile_text') {
			$content = $save['val'];
		}
		if($save['key'] == 'pm_region') {
			$search_str .= $save['val'].' '; 
		}		
		
		if($save['key'] == 'publish' && $save['val'] == true) {
			$status = 'publish';
		} else if($save['key'] == 'publish' && $save['val'] == false){
			$status = 'draft';
		}
	}
	update_post_meta($p_id, 'status', $status);	
	
	$search_str .= ']';
	$content .= $search_str;
		
	
	$new_url = sanitize_title($title);
	wp_update_post(array('ID' => $p_id,'tags_input' => $tags, 'post_category' => $cats, 'post_content' => $content, 'post_name' => $new_url, 'post_status' => 'publish'));
	
	
	
	$update = array();
	$update[0]['container'] = 'aside.user-info';
	$update[0]['html'] = viad_display_user_info();
	$update[1]['container'] = 'section.profile.content';
	$update[1]['html'] = viad_display_edit_profile();
	$update[2]['container'] = 'section.profile-head';
	$update[2]['html'] = viad_display_profile_head($p_id);
	$update[3]['container'] = 'aside.user-info';
	$update[3]['html'] = viad_display_user_info();

	
	echo json_encode($update);
		
	die();
}
add_action( 'wp_ajax_viad_save_profile', 'viad_save_profile' );


function viad_display_edit_profile() {
	
	
	
	$u_meta = get_user_meta(get_current_user_id());	
	$p_id = $u_meta['profile_id'][0];
	$p_meta = get_post_meta($p_id);
	$profile = get_post($p_id);
	

	
	
	if(viad_get_user_type() == 'professionals') {
		$html .= '<h3>Personalia</h3>';
	} else if(viad_get_user_type() == 'companies') {
		$html .= '<h3>Bedrijfsgegevens</h3>';
	}
	
	
	$html .= '<p>Personalia zoals in je profiel zichtbaar voor anderen</p>';
	
	$html .= '<p>Naam</p>';
	$html .= '<input class="save" type="text" name="um_full_name" value="'.$u_meta['full_name'][0].'"/>';

	$html .= '<p>Website</p>';
	$html .= '<input class="save" type="text" name="pm_website" value="'.$p_meta['website'][0].'" />';

	$html .= '<p>Adres</p>';
	$html .= '<input class="save" type="text" name="pm_address" value="'.$p_meta['address'][0].'" />';

	$html .= '<p>Postcode</p>';
	$html .= '<input class="save" type="text" name="pm_postal_code" value="'.$p_meta['postal_code'][0].'"/>';

	$html .= '<p>Plaats</p>';
	$html .= '<input class="save" type="text" name="pm_place" value="'.$p_meta['place'][0].'"/>';

	$html .= '<p>BTW Nummer</p>';
	$html .= '<input class="save" type="text" name="pm_vat" value="'.$p_meta['vat'][0].'"/>';

	$html .= '<p>KvK Nummer</p>';
	$html .= '<input class="save" type="text" name="pm_coc" value="'.$p_meta['coc'][0].'"/>';

	$html .= '<p>Bankrekeningnummer</p>';
	$html .= '<input class="save" type="text" name="pm_bank" value="'.$p_meta['bank'][0].'"/>';

	
	$html .= '<h3>Social media</h3>';

	$html .= '<p>LinkedIn</p>';
	$html .= '<input class="save" type="text" name="pm_linkedin" value="'.$p_meta['linkedin'][0].'" />';

	$html .= '<p>Twitter</p>';
	$html .= '<input class="save" type="text" name="pm_twitter" value="'.$p_meta['twitter'][0].'"  />';

	$html .= '<p>Facebook</p>';
	$html .= '<input class="save" type="text" name="pm_facebook" value="'.$p_meta['facebook'][0].'"/>';
	


		


	
	if(viad_get_user_type() == 'professionals') {			
		$html .= '<div class="third">';

		$html .= '<h3>CV</h3>';
		$html .= '<p>Functie / Ervaring</p>';
		$all_tags = get_tags(array('hide_empty' => 0));
		$tagged_with = wp_get_post_tags($p_id);
		$levels = array('Junior','Medior','Senior','N.v.t.');
		if($tagged_with) {
			foreach($tagged_with as $tag_w) {	
				$html .= '<div class="profession">';
				$html .= '<select class="profession-list save" name="profession">';
				$html .= '<option disabled>Functie</option>';
				foreach($all_tags as $tag) {
					if($tag->term_id == $tag_w->term_id) {
						$select = 'selected';
						$level = get_post_meta($p_id, 'level_'.$tag->term_id);
					} else {
						$select = '';
					}
					$html .= '<option value="'.$tag->term_id.'" '.$select.'>'.$tag->name.'</option>';
				}
				$html .= '</select>';
				$html .= '<select class="save" name="level">';
				$html .= '<option disabled>Ervaring</option>';
				foreach($levels as $l) {
				if($level[0] == $l) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				$html .= '<option '.$selected.'>'.$l.'</option>';
	
				}
				$html .= '</select>';
				$html .= '</div>';
			}
		} else {

			$html .= '<div class="profession">';
			$html .= '<select class="profession-list save" name="profession">';
			$html .= '<option selected disabled>Functie</option>';
			foreach($all_tags as $tag) {
				$html .= '<option value="'.$tag->term_id.'">'.$tag->name.'</option>';
			}
			$html .= '</select>';
		
			$html .= '<select name="level">';
			$html .= '<option selected disabled>Ervaring</option>';
			$html .= '<option>Junior</option>';
			$html .= '<option>Medior</option>';
			$html .= '<option>Senior</option>';
			$html .= '<option>N.v.t.</option>';
			$html .= '</select>';
		
			$html .= '</div>';
		
		}
	
		$html .= '<div>';
		$html .= '<a class="small-button add-profession" href="#"><div class="icon-essential-regular-18-plus-square"></div></a>';
		$html .= '<a class="small-button remove-profession" href="#"><div class="icon-essential-regular-19-close-square"></div></a>';
		$html .= '</div>';
		
		$html .= '<p>Vakgebied</p>';
		
		$categories = get_categories(array(	'hide_empty' => 0, 'parent' => 0, 'exclude' => 1));
		
		
		$in_categories = get_the_category($p_id);
		$in_cat_ids = array();
		foreach($in_categories as $ic) {
			$in_cat_ids[] .= $ic->term_id;
		}
		
		
		$html .= '<ul>';
		$c = 0;
		foreach ($categories as $i => $parent_cat) {
	
			$sub_categories = get_categories(array(	'hide_empty' => 0, 'parent' => $parent_cat->term_id));
	
			$html .= '<li class="parent" data-id="'.$parent_cat->term_id.'">';	
			if(in_array($parent_cat->term_id, $in_cat_ids)) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			
			$html .= '<input id="pcb'.$c.'" class="save" type="checkbox" name="category" value="'.$parent_cat->term_id.'" '.$checked.' />';		
			$html .= '<label for="pcb'.$c.'">'.$parent_cat->name.'</label>';
	
			if($sub_categories) {
				$html .= '<a class="small-button toggle-parent-profession" href="#"><div class="icon icon-essential-regular-16-plus-cricle"></div></a>';
	
	
			}
	
	
			$html .= '</li>';	
			foreach ($sub_categories as $j => $child_cat) {
	
				if(in_array($child_cat->term_id, $in_cat_ids)) {
					$checked = 'checked';
				} else {
					$checked = '';
				}
	
				$html .= '<li class="child" data-id="'.$parent_cat->term_id.'">';	
				$html .= '<input id="ccb'.$c.'" class="save" type="checkbox" name="category" value="'.$child_cat->term_id.'" '.$checked.' />';		
				$html .= '<label for="ccb'.$c.'">'.$child_cat->name.'</label>';
				$html .= '</li>';	
				$c++;
			}
			$c++;
		}
		$html .= '</ul>';
	
	
		$html .= '<p>Uurtarief</p>';
		$html .= '<input class="save" type="text" name="pm_price" value="'.$p_meta['price'][0].'" />';
	
		$html .= '<p>Beschikbare uren per week</p>';
		$html .= '<input class="save" type="text" name="pm_hours" value="'.$p_meta['hours'][0].'"  />';
	
		$html .= '<p>Regio</p>';
		$regions = array('Noord','Oost','Midden','Zuid','West');
		
		$html .= '<ul>';		
		foreach($regions as $i => $r) {
			$checked = '';
			if($p_meta['region'][0] == $r) {
				$checked = 'checked';
			}
			
			$html .= '<li>';
			$html .= '<input class="save" id="r'.$i.'" type="checkbox" name="pm_region" value="'.$r.'" '.$checked.' />';
			$html .= '<label for="r'.$i.'">'.$r.'</label>';
			$html .= '</li>';	
	
		}
		$html .= '</ul>';
	
	} else if(viad_get_user_type() == 'companies') {

		$html .= '<h3>Contactpersoon</h3>';
		

		$html .= '<p>Naam</p>';
		$html .= '<input class="save" name="um_contact_name" type="text" value="'.$u_meta['contact_name'][0].'"/>';

		$html .= '<p>Achternaam</p>';
		$html .= '<input class="save" name="um_contact_last_name" type="text" value="'.$u_meta['contact_last_name'][0].'"/>';

		$html .= '<p>Mailadres</p>';
		$html .= '<input class="save" name="um_contact_email" type="email"  value="'.$u_meta['contact_email'][0].'"/>';
		
		$html .= '<p>Telefoonnummer</p>';
		$html .= '<input class="save" name="um_contact_phone" type="text"  value="'.$u_meta['contact_phone'][0].'"/>';		


	}
	//col 3
		
	$html .= '<h3>Profiel</h3>';
	
	$html .= '<p>Profiel tekst</p>';

	$html .= '<div id="profile-text" class="editor" contenteditable="true">';	

	$html .= viad_content($profile->post_content);

	$html .= '</div>';


	$img = wp_get_attachment_image_src($u_meta['profile_pic'][0], 'thumbnail');
	
	$html .= '<p>Profielfoto</p>';
	$html .= '<form class="upload-form" method="post" action="#" enctype="multipart/form-data">';
	$html .= '<div class="thumbnail profile_pic" style="background-image:url('.$img[0].');"></div>';
	$html .= '<input type="hidden" name="pm_id" value="'.$p_id.'"/>';
	$html .= '<input type="hidden" name="key" value="profile_pic"/>';
	$html .= '<input type="hidden" name="action" value="viad_upload_image"/>';
	$html .= '<input type="hidden" name="size" value="thumbnail"/>';
	$html .= '<div class="profile-pic-btn">';
	$html .= '<div class="fileUpload btn btn-primary">';
	$html .= '<a class="button gray">Selecteren</a>';
    $html .= '<input type="file" name="file" class="upload" />';
	$html .= '</div>';
	$html .= '<input class="upload-btn" type="submit" value="foto uploaden" />';
	$html .= '</div>';
	$html .= '</form>';


/*
	$img = wp_get_attachment_image_src($p_meta['background_pic'][0], 'thumbnail');

	$html .= '<p>Omslagfoto</p>';
	$html .= '<div class="thumbnail background_pic" style="background-image:url('.$img[0].');"></div>';
	$html .= '<form class="upload-form" method="post" action="#" enctype="multipart/form-data" >';
	$html .= '<input type="hidden" name="pm_id" value="'.$p_id.'"/>';
	$html .= '<input type="hidden" name="key" value="background_pic"/>';
	$html .= '<input type="hidden" name="action" value="viad_upload_image"/>';
	$html .= '<input type="hidden" name="size" value="full"/>';
	$html .= '<div class="profile-pic-btn">';
	$html .= '<div class="fileUpload btn btn-primary">';
	$html .= '<a class="button gray">Selecteren</a>';
    $html .= '<input type="file" name="file" class="upload" />';
	$html .= '</div>';
	$html .= '<input class="upload-btn" type="submit" value="foto uploaden" />';
	$html .= '</div>';
	$html .= '</form>';
*/



	
	$html .= '<a href="#" class="button save-profile" data-publish="false">wijzigingen opslaan</a>';
	if($p_meta['status'][0] == 'draft') {
		$html .= '<a href="#" class="button save-profile" data-publish="true">publiceren</a>';
	}



	
	return $html;
}



function viad_review_is_connected($author_id) {
	$user_id = get_current_user_id();
	if (viad_get_user_type($user_id) == 'professionals' && viad_get_user_type($author_id) == 'companies') {
		// Professional op bedrijfs profiel
		$worked_on = get_user_meta($user_id, 'worked_on');
		$match_id = $author_id;

	} else if(viad_get_user_type($user_id) == 'companies' && viad_get_user_type($author_id) == 'professionals') {
		// Bedrijf op professional profiel
		$worked_on = get_user_meta($author_id, 'worked_on');
		$match_id = $user_id;
	}		
	if($worked_on) {
		$projects = get_posts(array('post_type' => 'projects', 'post__in' => $worked_on));		
		$matches = array();
		foreach($projects as $p) {
			$matches[] = $p->post_author;
		}
		if(in_array($match_id,$matches)) {
			return true;
		} else {
			return false;
		}		
	} else {
		return false;
	}
}


function viad_save_calendar() {
	$user_id = get_current_user_id();
	
	$profile = get_posts(array('post_type' => 'professionals', 'author' => $user_id));
	
	
	$dates = json_decode($_REQUEST['dates']);
	$arr = array();
	foreach($dates as $d) {
		$arr[] = $d;
	}	
	

	update_post_meta($profile->ID, 'viad_not_available', $arr, false);
	
	echo viad_display_calendar($user_id);
	
	die();

}
add_action( 'wp_ajax_viad_save_calendar', 'viad_save_calendar' );

function viad_toggle_spotlight() {
	$user_id = get_current_user_id();
	$user_meta = get_user_meta($user_id);

	if($_REQUEST['spotlight'] == 'on') {
		update_user_meta($user_id, 'spotlight', 'on');
		update_user_meta($user_id, 'spotlight_start', strtotime('now'));
	} else {
		$points_left = viad_spotlight_points_left($user_meta['spotlight_start'][0], $user_meta['spotlight_points'][0]);
		echo $points_left;
		update_user_meta( $user_id, 'spotlight', 'off');
		update_user_meta( $user_id, 'spotlight_points', $points_left);
	}		
	exit;
}
add_action( 'wp_ajax_viad_toggle_spotlight', 'viad_toggle_spotlight' );

function viad_spotlight_points_left($start, $points) {
	$left = $points - floor((strtotime('now') - $start)/(86400));
	return $left;
}

function viad_user_in_spotlight($user_id) {
	$user_meta = get_user_meta($user_id);
	
		
	if($user_meta['spotlight'][0] == 'on') {

		$points_left = viad_spotlight_points_left($user_meta['spotlight_start'][0], $user_meta['spotlight_points'][0]);
		if($points_left > 0) {
			
			return true;
		} else {

			update_user_meta( $user_id, 'spotlight', 'off');
			update_user_meta( $user_id, 'spotlight_points', 0);		

			return false;
		}
	} else {
		return false;
	}
}

      

function viad_is_author($author) {
	$user_id = get_current_user_id();
	if($user_id == $author) {
		return true;
	} else {
		return false;
	}
}





?>