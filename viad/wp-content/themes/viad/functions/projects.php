<?php

function viad_edit_project() {
	
	
	$post = get_post($_REQUEST['id']);
	if($post->post_parent == 0) {
		echo viad_display_edit_project($post->ID);
	} else {
		echo viad_display_edit_job($post->ID);
	}
	exit();
}
add_action( 'wp_ajax_viad_edit_project', 'viad_edit_project' );


function viad_subscribe_project() {
	
	$project_id = $_REQUEST['project_id'];
	$project = get_post($project_id);
	$profile_id = viad_get_profile_id();
	$user_id = get_current_user_id();
	$user_subscribed = get_post_meta($profile_id,'subscribed');
	$name = get_user_meta($user_id, 'full_name');	
	
	if(!in_array($project_id, $user_subscribed)) {
		add_post_meta($profile_id[0], 'subscribed', $project_id);
		add_post_meta($project_id, 'subscribed', $profile_id[0]);
		viad_send_message($project->post_author, $user_id,'Reactie op '.$project->post_title, 'Ik heb gereageerd');	
	}
	
	exit();
}
add_action( 'wp_ajax_viad_subscribe_project', 'viad_subscribe_project' );


function viad_toggle_favorite() {
	$project_id = $_REQUEST['project_id'];
	$favorites = viad_get_favorites();
	$profile_id = viad_get_profile_id();
	
	if(in_array($project_id, $favorites)) {
		delete_post_meta($profile_id[0], 'favorites', $project_id);
	} else {
		add_post_meta($profile_id[0], 'favorites', $project_id);
	}
	$update = array();
	$update[0]['container'] = '.projects.overview';
	$update[0]['html'] = viad_archive_projects();

	echo json_encode($update);
	
	exit();
}
add_action( 'wp_ajax_viad_toggle_favorite', 'viad_toggle_favorite' );


function viad_save_project() {
	
	$p_id = $_REQUEST['project_id'];
	
	$project = get_post($p_id);

	$search_str = '[';

		
	foreach($_REQUEST['save'] as $i => $save) {
		
		
		if(substr($save['key'],0,2) == 'pm') {
			$key = str_replace('pm_','',$save['key']);
			if($key == 'deadline' || $key == 'start_date' || $key == 'end_date') {
				$save['val'] = strtotime($save['val']);
			}
			update_post_meta($p_id, $key, $save['val'], false);
		}
		
		
		if($save['key'] == 'project_title') {
			$title = $save['val'];
		}
		if($save['key'] == 'project_text') {
			$content = $save['val'];
		}
		if($save['key'] == 'status') {
			$status = $save['val'];
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
		if($save['key'] == 'pm_region') {
			$search_str .= $save['val'].' '; 
		}
	}
	$owner_meta = get_user_meta($project->post_author);
	
	$search_str .= $owner_meta['full_name'][0];
	
	$search_str .= ']';
	
	$content .= $search_str;
	
	
	$new_url = sanitize_title($title);

	wp_update_post(array('ID' => $p_id,'post_content' => $content, 'post_title' => $title, 'post_name' => $new_url,'tags_input' => $tags, 'post_category' => $cats));
	update_post_meta($p_id, 'status', $status);	
	$subscribed_users = get_post_meta($p_id, 'subscribed');
	
	

	if($status == 'publish') {
		if($subscribed_users) {
			foreach($subscribed_users as $su) {
				$user = get_post($su);
				viad_send_message($user->post_author,$project->post_author, 'Project '.$title.' is gewijzigd', 'De tekst');
			}
		}
	}	


	$update = array();
	$update[0]['container'] = 'aside.user-info';
	$update[0]['html'] = viad_display_user_info();
	$update[1]['container'] = 'section.project.content';
	$update[1]['html'] = viad_display_edit_project($p_id);
	$update[2]['container'] = 'section.profile-head';
	$update[2]['html'] = viad_display_profile_head($p_id);
	$update[3]['container'] = 'aside.user-info';
	$update[3]['html'] = viad_display_user_info();
	//$update[4]['container'] = 'section.job.content';
	//$update[4]['html'] = viad_display_edit_job($p_id);

	
	echo json_encode($update);
		
	exit();
}
add_action( 'wp_ajax_viad_save_project', 'viad_save_project' );




function viad_display_edit_project ($p_id) {

	$u_meta = get_user_meta(get_current_user_id());	

	$p_meta = get_post_meta($p_id);
	
	$project = get_post($p_id);

	
	$html .= '<div class="container profile-editor">';

	$html .= '<h2>Opdracht bewerken</h2>';

	$html .= '<div class="third">';
	$html .= '<h3 class="widget-title">Opdracht omschrijving</h3>';

	$html .= '<p>Opdracht naam</p>';
	$html .= '<input class="save" type="text" name="project_title" value="'.$project->post_title.'"/>';
	
	$html .= '<p>Opdracht omschrijving</p>';
	$html .= '<div id="project-text" class="editor" contenteditable="true">';	
	$html .= viad_content($project->post_content);
	$html .= '</div>';


	$html .= '<p>Status opdracht</p>';
	$html .= '<select class="save" name="status">';
	if($p_meta['status'][0] == 'draft') {
		$html .= '<option selected value="draft" >Concept</option>';
	} else {
		$html .= '<option value="draft" >Concept</option>';
	}
	if($p_meta['status'][0] == 'publish') {
		$html .= '<option selected value="publish">Publiek</option>';
	} else {
		$html .= '<option value="publish">Publiek</option>';
	}	
	$html .= '</select>';

	$html .= '<a href="#" class="button save-project" data-project-id="'.$p_id.'">wijzigingen opslaan</a>';


	$html .= '</div>';

	//col2


	$html .= '<div class="third">';
	$html .= '<h3 class="widget-title">Opdracht meta</h3>';
	

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
	
	$html .= '<p>Deadline inschrijvingen</p>';
	$html .= '<input class="save" type="text" placeholder="dd-mm-yyyy" name="pm_deadline" value="'.date('d-m-Y', viad_check_date($p_meta['deadline'][0])).'" />';

	$html .= '<p>Startdatum</p>';
	$html .= '<input class="save" type="text" placeholder="dd-mm-yyyy" name="pm_start_date" value="'.date('d-m-Y', viad_check_date($p_meta['start_date'][0])).'" />';

	$html .= '<p>Einddatum</p>';
	$html .= '<input class="save" type="text" placeholder="dd-mm-yyyy" name="pm_end_date" value="'.date('d-m-Y', viad_check_date($p_meta['end_date'][0])).'" />';


	$html .= '<p>Uurtarief</p>';
	$html .= '<input class="save" type="text" name="pm_price" value="'.$p_meta['price'][0].'" />';

	$html .= '<p>Uren per week</p>';
	$html .= '<input class="save" type="text" name="pm_hours" value="'.$p_meta['hours'][0].'"  />';
	
	$html .= '<br class="clear"/>';



	$html .= '<a href="#" class="button save-project" data-project-id="'.$p_id.'">wijzigingen opslaan</a>';

	$html .= '</div>';


	

	//col3

	$html .= '<div class="third">';

	$html .= '<h3 class="widget-title">Functie omschrijving</h3>';
	
	$html .= '<p>Functie / Ervaring</p>';
	
	$all_tags = get_tags(array('hide_empty' => 0));
	
	
	$tagged_with = wp_get_post_tags($p_id);
	$levels = array('Junior','Medior','Senior','N.v.t.');
	
	if($tagged_with) {
		// heeft tags
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
		// geen tags
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
	$html .= '<p>Uw vakgebied ontbreekt?<br/>Mail een suggestie naar <a href="mailto:hallo@viad.nl">hallo@viad.nl</a></p>';

	$img = wp_get_attachment_image_src($p_meta['background_pic'][0], 'medium');

	$html .= '<p>Omslagfoto</p>';
	$html .= '<div class="thumbnail background_pic" style="background-image:url('.$img[0].');"></div>';
	$html .= '<form class="upload-form" method="post" action="#" enctype="multipart/form-data" >';
	$html .= '<input type="hidden" name="pm_id" value="'.$p_id.'"/>';
	$html .= '<input type="hidden" name="key" value="background_pic"/>';
	$html .= '<input type="hidden" name="action" value="viad_upload_image"/>';
	$html .= '<input type="hidden" name="size" value="full"/>';

	$html .= '<div class="profile-pic-btn">';
	$html .= '<div class="fileUpload btn btn-primary">';
	$html .= '	<a class="button gray">Selecteren</a>';
    $html .= '	<input type="file" name="file" class="upload" />';
	$html .= '</div>';
	$html .= '<input class="upload-btn" type="submit" value="foto uploaden" />';
	$html .= '</div>';
	$html .= '</form>';

	$html .= '<br class="clear"/>';
	$html .= '<a href="#" class="button save-project" data-project-id="'.$p_id.'">wijzigingen opslaan</a>';


		
	$html .= '</div>';



	$html .= '</div>'; // container

	
	return $html;








}

function viad_check_date($date) {
	if(!$date || $date == 0) {
		$date = strtotime('now');
	} 
	return $date;
}


?>