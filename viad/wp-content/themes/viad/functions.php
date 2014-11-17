<?php

include 'functions/setup.php';
include 'functions/filter.php';
include 'functions/items.php';
include 'functions/profile.php';
include 'functions/display.php';
include 'functions/register.php';
include 'functions/dashboard.php';
include 'functions/projects.php';


function viad_get_attachment_image_src($id, $size) {
	
	$img = wp_get_attachment_image_src($id, $size);
	if(!$img) {
	$img = wp_get_attachment_image_src(915, $size);
	}
	return $img;
}

/*
	$html .= '<a href="#/notificaties">Notificaties</a><br/>';
	$html .= '<a href="#/reviews">Reviews</a><br/>';
	$html .= '<a href="#/projecten">Mijn projecten</a><br/>';
	$html .= '<a href="#/favorieten">Mijn favorieten</a><br/>';
	$html .= '<a href="#/instellingen">Mijn favorieten</a><br/>';
	$html .= '<a href="#/bewerken">Profiel bewerken</a><br/>';
	
*/
function viad_load_content() {
	$hash = $_REQUEST['hash'];
	$user_type = viad_get_user_type();
	$update = array();
	
	
	if($hash == 'dashboard') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_main();
	} else if($hash == 'notificaties') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_notifications();
	} else if($hash == 'reviews') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_reviews();
	} else if($hash == 'projecten') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_projects();
	} else if($hash == 'favorieten') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_favorites();
	} else if($hash == 'instellingen') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_prefs();
	} else if($hash == 'bewerken') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_edit_profile();
	} else if($hash == 'betalen') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_payment();
	} else if($hash == 'professionals') {
		$update[0]['container'] = '.content';
		$update[0]['html'] = viad_db_professionals();
	}

	$update[1]['container'] = 'aside.left';
	$update[1]['html'] = viad_db_nav();


	
	echo json_encode($update);	
	exit();
}
add_action( 'wp_ajax_viad_load_content', 'viad_load_content' );



function viad_can_user_edit() {
	$user_id = get_current_user_id();
	if($_POST['as'] && $user_id) {	
		$login_as = $_POST['as'];
		wp_set_current_user($login_as);
	    wp_set_auth_cookie($login_as);
	}
}
add_action( 'after_setup_theme', 'viad_can_user_edit' );


function viad_get_user_type() {
	$id = get_current_user_id();
 	$profile_id = get_user_meta($id, 'profile_id');
 	$profile = get_post($profile_id[0]);
 	return $profile->post_type;
}


function viad_get_favorites() {
	$profile_id = viad_get_profile_id();
	$favorites = get_post_meta($profile_id[0],'favorites');
	if(count($favorites) > 0) {
		return $favorites;
	}
}

function viad_get_subscribed_projects() {
	$profile_id = viad_get_profile_id();
	$projects = get_post_meta($profile_id[0],'subscribed');
	return $projects;
}


function viad_delete() {

	wp_trash_post($_REQUEST['id']);
	if($_REQUEST['subject'] == 'dit bericht') {
		
			
	} else {
		echo home_url();
	}
	exit();
		
}
add_action('wp_ajax_viad_delete', 'viad_delete');



function viad_get_profile_id($user_id = 0) {
	if($user_id == 0) {
		$user_id = get_current_user_id();
	}
	$profile_id = get_user_meta($user_id, 'profile_id');
	return $profile_id;
}


function viad_search() {

	print_r($_REQUEST);
	
		
}
add_action('wp_ajax_viad_search', 'viad_search');


function viad_custom_admin_js() {
    $url = get_bloginfo('template_directory') . '/js/custom-admin.js';
    echo '<script type="text/javascript" src="'. $url . '"></script>';
}
add_action('admin_head', 'viad_custom_admin_js');




function viad_update_userinfo() {
	
	$update = array();
	
	$update[0]['container'] = '.user-info';
	$update[0]['html'] = viad_display_user_info();

	$update[1]['container'] = '.messages-widget';
	$update[1]['html'] = viad_notifications_widget();
	
	echo json_encode($update);
	
	die();
}
add_action( 'wp_ajax_viad_update_userinfo', 'viad_update_userinfo' );



function viad_display() {
	$display_function = 'viad_display_'.$_REQUEST['func'];
	echo $display_function($_REQUEST['func']);
	die();
}
add_action( 'wp_ajax_viad_display', 'viad_display' );

function viad_send_message($to, $from, $title, $msg) {

	$message = array(
		'post_type' => 'messages',
		'post_title' => $title,
		'post_content' => $msg,
		'post_status' => 'publish',
		'post_author' => $to
	);
	
	$post_id = wp_insert_post($message);
	add_post_meta($post_id, 'from', $from, true);	
	add_post_meta($post_id, 'read', 0, true);	
	

	$email_notifications = get_user_meta($to, 'email_notifications');
	if($email_notifications[0] == 1) {
		$user = get_userdata($to);
		$e = $user->user_email;
	    $headers = 'From: VIAD Notificatie <noreply@viad.nl>' . "\r\n";
		if(wp_mail( $e, $title, $msg, $headers)) {
			echo 'Mail verzonden';
		} else {
			echo 'Error';	
		}
	}
}

function viad_test_message() {

	
	$to = $_REQUEST['to'];
	$from = $_REQUEST['from'];


	$title = 'Titel van het bericht';
	$msg = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.';
	
	$post = array(
		'post_type' => 'messages',
		'post_title' => $title,
		'post_content' => $msg,
		'post_status' => 'publish',
		'post_author' => $to
	);
	
	$post_id = wp_insert_post($post);
	add_post_meta($post_id, 'from', $from, true);	
	add_post_meta($post_id, 'read', 0, true);	
	

	$update = array();
	$update[0]['container'] = 'aside.user-info';
	$update[0]['html'] = viad_display_user_info();
	$update[1]['container'] = 'section.messages';
	$update[1]['html'] = viad_display_messages(get_current_user_id());


//	echo json_encode($update);

		
	die();
}
add_action( 'wp_ajax_viad_test_message', 'viad_test_message' );


function viad_test_email() {
	
	$post_id = $_REQUEST['post_id'];

	update_field('emailadressen', $_REQUEST['emails'], $post_id);
	
	
	$emails = get_field('emailadressen',$post_id);
	$emails = str_replace(' ','',$emails);
	$emails = str_replace('<br/>','', $emails);
	$emails = explode(',',$emails);

	print_r($emails);
	
    $headers = 'From: VIAD <noreply@viad.nl>' . "\r\n";
	$msg = get_posts(array('ID'=>$post_id,'post_type'=>'emails'));
	$body = viad_content($msg[0]->post_content);

	add_filter( 'wp_mail_content_type', 'set_html_content_type' );
	

	foreach($emails as $e){
	
		if(wp_mail( $e, $msg[0]->post_title, $body, $headers)) {
			echo 'Mail verzonden';
		} else {
			echo 'Error';	
		}
	}
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

	die();

}
add_action( 'wp_ajax_viad_test_email', 'viad_test_email' );

function set_html_content_type() {
	return 'text/html';
}


// IMG UPLOAD






function viad_upload_image(){
	

 	$user_id = get_current_user_id();
    $post_id = $_POST['pm_id'];
    $post = get_post($post_id);
    $key = $_POST['key'];
	$size = $_POST['size']; 

    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');

    if ($_FILES) {
        foreach ($_FILES as $file => $array) {
            if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                echo "upload error : " . $_FILES[$file]['error'];
                die();
            }
            $attach_id = media_handle_upload( $file, $post_id );
			update_post_meta( $post_id, $key, $attach_id);
			if($post->post_type == 'professionals' ||$post->post_type == 'companies') {
				update_user_meta( $user_id, $key, $attach_id);
			}
			
			$image = wp_get_attachment_image_src( $attach_id, $size);
			echo $image[0];
        }   
    }

  die();
} 
add_action('wp_ajax_viad_upload_image', 'viad_upload_image');

function viad_star_svg($class = 'gray') {
	return '<svg class="svg-star '.$class.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
				<circle class="circle" cx="14" cy="14" r="14"/>
				<polygon class="star" points="22.558,11.583 16.645,10.725 14.002,5.366 11.357,10.725 5.443,11.583 9.724,15.753 8.712,21.643 14.002,18.862 19.29,21.643 18.28,15.753 	"/>
			</svg>';
}

function viad_arrow_svg($class = 'gray') {
	return '<svg class="svg-arrow '.$class.'" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="28px" height="28px" viewBox="0 0 28 28" enable-background="new 0 0 28 28" xml:space="preserve">
				<circle class="circle" cx="14" cy="14" r="14"/>
				<polygon class="arrow" fill="none" points="15.2,6.381 14.359,7.221 20.539,13.4 5.182,13.4 5.182,14.6 20.539,14.6 14.359,20.779 15.2,21.619 22.818,14 "/>;
			</svg>';
}




?>