<?php

function viad_start_session() {
    if(!session_id()) {
        session_start();
    }
}
add_action('init', 'viad_start_session', 1);

function viad_register_step($step = 1) {
	
	
	foreach($_POST as $key => $val){
		if($key != 'step' && $key != 'action') {
			$_SESSION[$key] = $val;
		}
	}
	print_r($_SESSION);
		
	
	if($_POST['step']) {
		$step = $_POST['step']; 
	}
	
	include 'stap-'.$step.'.php';

	if($_POST['action']) {
		exit();
	}
}
add_action('wp_ajax_nopriv_viad_register_step','viad_register_step');



function viad_register() {

	$html .= 'Voltooien aanmaken etc';
	
/*
	$user_name = $_POST['name'].'.'.$_POST['last_name'];	
	$user_name = str_replace(' ','.',$user_name);
	
	$user_id = username_exists($user_name);

	

	if (!$user_id and email_exists($_POST['email']) == false ) {


		$user_id = wp_create_user($user_name, $_POST['password'], $_POST['email']);
		wp_update_user( array ('ID' => $user_id, 'role' => 'member_'.$_POST['membership'], 'display_name' => $_POST['name'].' '.$_POST['last_name']));
		update_user_meta($user_id,'first_name', $_POST['name']);
		update_user_meta($user_id,'last_name', $_POST['last_name']);
		

		$post = array(
			'post_type' => $_POST['type'], 
			'post_title' => $_POST['name'].' '.$_POST['last_name'],
			'post_content' => 'Hoi, '.$_POST['name'].' '.$_POST['last_name']. ' dit is je profielpagina. Vul hem in!',
			'post_author' => $user_id,
			'post_status' => 'publish'
		);
		$post_id = wp_insert_post($post);
		update_user_meta($user_id, 'profile_id', $post_id);
		update_user_meta($user_id, 'full_name', $_POST['name'].' '.$_POST['last_name']);
		update_user_meta($user_id, 'spotlight', 'off');
		update_user_meta($user_id, 'spotlight_points', 30);

		update_post_meta($post_id, 'status', 'draft');


		foreach ($_POST as $key => $value) {
		    if ($value && substr($key,0,2) == 'um') {
			    $key = str_replace('um_', '', $key);
				update_user_meta($user_id, $key, $value);
		    }
		    else if ($value && substr($key,0,2) == 'pm') {
			    $key = str_replace('pm_', '', $key);
				update_post_meta($post_id, $key, $value);
			}
		}
		

		
		
		// SEND EMAIL
	    $headers = 'From: VIAD <noreply@viad.nl>' . "\r\n";
		$msg = get_posts(array('p' => 498,'post_type'=>'emails'));
		$body = viad_content($msg[0]->post_content);
		
		$body = str_replace('[naam]', $_POST['name'].' '.$_POST['last_name'], $body);
		$body = str_replace('[site_url]', home_url(), $body);
		$body = str_replace('[user_name]', $user_name, $body);
		$body = str_replace('[password]', $_POST['password'], $body);
		
		
		add_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		

		if(wp_mail( $_POST['email'], $msg[0]->post_title, $body, $headers)) {

		} else {

		}

		remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		
		// SHOW MESSAGE!
		$post = get_post(494);
		echo '<div class="container">';
		echo '<h2>'.$post->post_title.'</h2>';
		echo viad_content($post->post_content);
		echo '</div>';

	}
*/
	
	exit();
}
add_action('wp_ajax_nopriv_viad_register', 'viad_register');





?>