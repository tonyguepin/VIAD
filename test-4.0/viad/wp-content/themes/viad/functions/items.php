<?php

function viad_new_item() {
	if($_REQUEST['action'] == 'viad_new_item') {
		$author_id = $_REQUEST['user'];
		$new = array(
			'post_type' => $_REQUEST['type'], 
			'post_author' => $author_id,
			'post_status' => 'publish'
		);
		if($_REQUEST['type'] != 'projects') {
			$new_id = wp_insert_post($new);
		}
		if($_REQUEST['type'] == 'blog') {
			echo '<div id="'.$_REQUEST['type'].'-'.$new_id.'" class="new_item">';
			echo '<h2 class="new-title" contenteditable="true">Titel</h2>';
			echo '<p class="new-text" contenteditable="true">Text</p>';
			echo '</div>';
		} else if($_REQUEST['type'] == 'reviews') {
			echo '<div id="'.$_REQUEST['type'].'-'.$new_id.'" class="new_item">';
			echo '<p class="new-text" contenteditable="true">Text</p>';
			echo '</div>';
		} else if($_REQUEST['type'] == 'projects') {
			//////////////////////////
			// NEW PROJECT
			//////////////////////////
			$user_id = get_current_user_id();
			$project = array(
				'post_type' => 'projects',
				'post_status' => 'publish',
				'post_title' => 'Nieuw project',
				'post_author' => $user_id
			);
			$project_id = wp_insert_post($project);	
			update_post_meta($project_id, 'status', 'draft');
			$location = get_permalink($project_id);
			echo $location;
			exit;					
		}
	}
	die();
}
add_action( 'wp_ajax_viad_new_item', 'viad_new_item' );


function viad_save_item() {
	if($_REQUEST['action'] == 'viad_save_item') {
		$update = array(
			'ID' => $_REQUEST['id'],
			'post_type' => $_REQUEST['type'], 
			'post_title' => $_REQUEST['title'],
			'post_content' => $_REQUEST['text'],
			'post_status' => 'publish'
		);
		$update_id = wp_insert_post($update);
		$display_function = 'viad_display_'.$_REQUEST['type'];
		echo $display_function($_REQUEST['user']);
	}
	die();
}
add_action( 'wp_ajax_viad_save_item', 'viad_save_item' );



?>