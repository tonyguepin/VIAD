
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>VI&Lambda;D</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/img/favicon.ico">
		<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_directory');?>/img/apple-touch-icon-152x152.png">
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon-196x196.png" sizes="196x196">
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon-160x160.png" sizes="160x160">
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon-96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="<?php bloginfo('template_directory');?>/img/favicon-32x32.png" sizes="32x32">
		<meta name="msapplication-TileColor" content="#00adef">
		<meta name="msapplication-TileImage" content="<?php bloginfo('template_directory');?>/img/mstile-144x144.png">
		<meta name="msapplication-config" content="<?php bloginfo('template_directory');?>/img/browserconfig.xml">

		<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6539332/798406/css/fonts.css" />

        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/normalize.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/responsive.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/jquery-ui-custom.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/main.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/custom.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/forms.css">
        <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/dashboard.css">

	    <link rel="stylesheet" href="<?php bloginfo('template_directory');?>/css/essential-regular-styles.css">
        
        <script src="<?php bloginfo('template_directory');?>/js/vendor/modernizr-2.6.2.min.js"></script>
        
        <?php wp_head(); 
        
			if($post->post_type == 'page' || is_archive()) { 
				$body_class = 'page';
			}        
        
        ?>
    </head>
    <body class="<?php echo $body_class;?>">
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<?php

 	$user = wp_get_current_user();
	$user_meta = get_user_meta($user->ID);
	
	// Pages background pic
/*
	if($post->post_type == 'professionals' && is_singular('professionals') || $post->post_type == 'companies' && is_singular('companies')) {
		$post_meta = get_post_meta($post->ID);
		$bg_pic = wp_get_attachment_image_src( $post_meta['background_pic'][0], 'full');
	}

	// Dashboard background pic
	if ( is_user_logged_in() && is_front_page()) {
		$profile_meta = get_post_meta($user_meta['profile_id'][0]);
		$bg_pic = wp_get_attachment_image_src( $profile_meta['background_pic'][0], 'full');
	}

	if($post->post_type == 'projects' && is_singular('projects')) {
		
		if($post->post_parent == 0) {
			$meta = get_post_meta($post->ID);
			$bg_pic = wp_get_attachment_image_src( $meta['background_pic'][0], 'full');
			if(!$bg_pic){
				$profile_meta = get_post_meta($user_meta['profile_id'][0]);
				$bg_pic = wp_get_attachment_image_src( $profile_meta['background_pic'][0], 'full');
			}
		} else {
			$meta = get_post_meta($post->post_parent);
			$bg_pic = wp_get_attachment_image_src( $meta['background_pic'][0], 'full');
			if(!$bg_pic){
				$profile_meta = get_post_meta($user_meta['profile_id'][0]);
				$bg_pic = wp_get_attachment_image_src( $profile_meta['background_pic'][0], 'full');
			}

		}
	
	}
	
	
	$c = $class[$post->post_type];


	if(!$c) {
		$c = 'blue';
	}
	
	if(!$bg_pic[0]) {
*/

	$bg_pic[0] = 'http://preview.viad.nl/wp-content/uploads/placeholder.jpg';
/* 	} */

?>

	<?php
	if ( is_user_logged_in() ) {
		$class = 'logged-in';			
	}
	?>
		<div class="user-info <?php echo $class ?>">
		<?php echo viad_display_user_info(); ?>
		</div>	

	<header style="background-image:url(<? echo $bg_pic[0]; ?>)" class="background_pic">

		<div class="overlay blue"></div>


 		<div class="container">
			<nav class="menu">
				<ul>
					<li><a class="logo-svg" href="<?php echo home_url();?>"><?php echo viad_display_logo_svg('white');?></a></li>
					<li><a href="<?php echo get_post_type_archive_link('professionals');?>">Professionals</a></li>
					<li><a href="<?php echo get_post_type_archive_link('projects');?>">Projecten</a></li>
					<?php
					$pages = get_pages(array('sort_column' => 'menu_order', 'exclude' => array(2,15,207,494,528)));
					foreach($pages as $p) {
						echo '<li><a href="'.get_permalink($p->ID).'">'.$p->post_title.'</a></li>';
					}
					
					?>
				</ul>
			</nav>
 		</div>

		<?php
		echo viad_display_searchbar();
		?>

		<input id="id" type="hidden" data-id="<?php echo $post->ID; ?>"/>
	</header>