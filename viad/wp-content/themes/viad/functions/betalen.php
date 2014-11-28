<?php



// Display betaal pagina op het dashboard

function viad_db_payment() {
	
	$user_id = get_current_user_id();
	$user_meta = get_user_meta($user_id);	
	
	$experatie_datum = $user_meta['pay_expired'][0];
	$geregistreerd_abbonement = $user_meta['membership'][0];

//	get user role?

	$live_abbonement = viad_get_user_role();
	
	$html .= '<h2>Betalen '.$user_id.'</h2>';
	$html .= '--'.$live_abbonement;
	return $html;
	
//	update_user_meta($user_id, 'pay_secret', $value);
}


?>