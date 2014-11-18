<?php

////////////////////////
// PROFESSIONALS
////////////////////////

function viad_filter_professionals() {
	

	$cats = array();
	$tags = array();
	$regions = array();
	$price = array();
	$hours = array();
	$post_per_page = 10;
	if($_REQUEST['filter']) {
		foreach($_REQUEST['filter'] as $f) {
			if($f['key'] == 'parent-category' || $f['key'] == 'child-category') {
				$cats[] = $f['val'];
			}
			if($f['key'] == 'tag') {
				$tags[] = $f['val'];
			}
			if($f['key'] == 'region') {
				$regions[] = $f['val'];
			}
			if($f['key'] == 's') {
				$search = $f['val'];
			}
			if($f['key'] == 'p') {
				$page = $f['val'];
			}
			if($f['key'] == 'price') {
				$price = $f['val'];
			}
			if($f['key'] == 'hours') {
				$hours = $f['val'];
			}

		}
		
		
		$args = array(
			's'					=> $search,
		    'post_type'         => 'professionals',
			'category__in' 		=> $cats, 
			'tag__in'			=> $tags, 
  			'paged'				=> $page,  
		    'posts_per_page'    => $post_per_page,
		    'meta_query'        => array(
		        'relation'  => 'AND',
		        array(
		            'key'       => 'region',
		            'value'		=> $regions,
		            'compare'   => 'IN'
		        ),
		        array(
		            'key'       => 'price',
    	            'type' => 'NUMERIC',
		            'value'		=>  $price,
		            'compare'   => 'BETWEEN'
		        ),
		        array(
		            'key'       => 'hours',
    	            'type' => 'NUMERIC',
		            'value'		=>  $hours,
		            'compare'   => 'BETWEEN'
		        )
		        
		    )
		);
		$the_query = new WP_Query( $args );
		$count = $the_query->found_posts;
		if($count == 0) {
			echo '<h2>Geen professionals gevonden</h2>';
		} else if($count == 1) {
			echo '<h2><span>1</span> professional gevonden</h2>';
		} else {
			echo '<h2><span>'.$count.'</span> professionals gevonden</h2>';
		}
		$total_pages = ceil($count/$post_per_page);	
		echo '<p class="pagination">';
		for($i = 1; $i < $total_pages+1; $i++) {
			if(($i) == $page) {
				echo ($i).' ';
			} else {
				echo '<a href="#" class="page-nav" data-page="'.($i).'">'.($i).'</a> ';
			}
		
		}
		if($page < $total_pages && $total_pages > 1) {
			echo '<a href="#" class="page-nav" data-page="'.($page+1).'">&rarr;</a> ';
		}
		echo '</p>';

		$matches = get_posts( $args );	
		foreach($matches as $match) {
			$pm = get_post_meta($match->ID);
			echo '<div class="project-result">';
			
			
			$img = viad_get_attachment_image_src($pm['profile_pic'][0], 'medium');
			
			echo '<div class="project-image" style="background-image:url('.$img[0].');"></div>';
			echo '<div class="project-content">';
			echo '<h3><a href="'.get_permalink($match->ID).'">'.$match->post_title.'</a></h3>';
			
			if($pm['profession']) {
				foreach($pm['profession'] as $prof) {	
					echo $prof.' ';
				}
			}
			$first_part = substr($match->post_content, 0, 180);
			if(strlen($match->post_content) > 180) {
				$first_part .= '...';
			}

			echo viad_content($first_part);
			echo '</div>';
			echo '<div class="project-meta">';
			if(viad_get_user_type() == 'companies') {
				$favorites = viad_get_favorites();
				if($favorites) {
					if(in_array($match->ID, $favorites)) {
						echo '<a href="#" class="toggle-favorite" title="Toevoegen aan favorieten" data-id="'.$match->ID.'">'.viad_star_svg('blue').'</a>';
					} else {
						echo '<a href="#" class="toggle-favorite" title="Toevoegen aan favorieten" data-id="'.$match->ID.'">'.viad_star_svg().'</a>';
					}
				}
			}
			echo '<div style="height:40px; display:block;"></div>';

			$euro = '';
	
			if($pm['price'][0]) {
				if(is_numeric($pm['price'][0])) {
					$euro = '&euro; ';
				}
				echo '<div><span class="icon">|</span> <span class="text">'.$euro.$pm['price'][0].'</span></div>';
			}
			if($pm['hours'][0]) {
				echo '<div><span class="icon">]</span> <span class="text">'.$pm['hours'][0].'</span></div>';
			}
			if($pm['region'][0]) {
				echo '<div><span class="icon">_</span> <span class="text">'.$pm['region'][0].'</span></div>';
			}
			echo '</div>';
			echo '</div>';
		}
		echo '<p class="pagination">';
		for($i = 1; $i < $total_pages+1; $i++) {
			if(($i) == $page) {
				echo ($i).' ';
			} else {
				echo '<a href="#" class="page-nav" data-page="'.($i).'">'.($i).'</a> ';
			}
		
		}
		if($page < $total_pages && $total_pages > 1) {
			echo '<a href="#" class="page-nav" data-page="'.($page+1).'">&rarr;</a> ';
		}
		echo '</p>';
			
	}
	exit();

	
}
add_action( 'wp_ajax_viad_filter_professionals', 'viad_filter_professionals' );


////////////////////////
// PROJECTS
////////////////////////
function viad_filter_projects() {
	$cats = array();
	$tags = array();
	$regions = array();
	$post_per_page = 10;
	if($_REQUEST['filter']) {
		foreach($_REQUEST['filter'] as $f) {
			if($f['key'] == 'parent-category' || $f['key'] == 'child-category') {
				$cats[] = $f['val'];
			}
			if($f['key'] == 'tag') {
				$tags[] = $f['val'];
			}
			if($f['key'] == 'region') {
				$regions[] = $f['val'];
			}
			if($f['key'] == 's') {
				$search = $f['val'];
			}
			if($f['key'] == 'p') {
				$page = $f['val'];
			}
		}


		
		$args = array(
			's'					=> $search,
		    'post_type'         => 'projects',
			'category__in' 		=> $cats, 
			'tag__in'			=> $tags, 
  			'paged'				=> $page,  
		    'posts_per_page'    => $post_per_page,
		    'meta_query'        => array(
		        array(
		            'key'       => 'region',
		            'value'		=> $regions,
		            'compare'   => 'IN'
		        )
		    )
		);
		$the_query = new WP_Query( $args );
		$count = $the_query->found_posts;
		$matches = get_posts( $args );	
		

		if($count == 0) {
			echo '<h2>Geen projecten gevonden</h2>';
		} else if($count == 1) {
			echo '<h2><span>1</span> project gevonden</h2>';
		} else {
			echo '<h2><span>'.$count.'</span> projecten gevonden</h2>';
		}
		$total_pages = ceil($count/$post_per_page);	
		echo '<p class="pagination">';
		for($i = 1; $i < $total_pages+1; $i++) {
			if(($i) == $page) {
				echo ($i).' ';
			} else {
				echo '<a href="#" class="page-nav" data-page="'.($i).'">'.($i).'</a> ';
			}
		
		}
		if($page < $total_pages && $total_pages > 1) {
			echo '<a href="#" class="page-nav" data-page="'.($page+1).'">&rarr;</a> ';
		}
		echo '</p>';
		foreach($matches as $match) {
			$pm = get_post_meta($match->ID);
			echo '<div class="project-result">';
			$img = wp_get_attachment_image_src($pm['background_pic'][0], 'medium');
			echo '<div class="project-image" style="background-image:url('.$img[0].');"></div>';
			echo '<div class="project-content">';
			echo '<h3><a href="'.get_permalink($match->ID).'">'.$match->post_title.'</a></h3>';
			$owner_profile = viad_get_profile_id($match->post_author);
			echo '<a href="'.get_permalink($owner_profile[0]).'">'.get_the_title($owner_profile[0]).'</a>';

			$first_part = substr($match->post_content, 0, 180);
			if(strlen($match->post_content) > 180) {
				$first_part .= '...';
			}

			echo viad_content($first_part);
			echo '</div>';
			echo '<div class="project-meta">';
			if(viad_get_user_type() == 'professionals') {
				$favorites = viad_get_favorites();
				if($favorites) {
					if(in_array($match->ID, $favorites)) {
						echo '<a href="#" class="toggle-favorite" title="Toevoegen aan favorieten" data-id="'.$match->ID.'">'.viad_star_svg('blue').'</a>';
					} else {
						echo '<a href="#" class="toggle-favorite" title="Toevoegen aan favorieten" data-id="'.$match->ID.'">'.viad_star_svg().'</a>';
					}
				}
			}
			if(is_numeric($pm['deadline'][0])) {
				echo '<div><span class="icon">8</span> <span class="text">'.date_i18n('d F Y',$pm['deadline'][0]).'</span></div>';
			}
			if(is_numeric($pm['start_date'][0])) {
				echo '<div><span class="icon">@</span> <span class="text">'.date_i18n('d F Y',$pm['start_date'][0]).'</span></div>';
			}
			$euro = '';
	
			if($pm['price'][0]) {
				if(is_numeric($pm['price'][0])) {
					$euro = '&euro; ';
				}
				echo '<div><span class="icon">|</span> <span class="text">'.$euro.$pm['price'][0].'</span></div>';
			}
			if($pm['hours'][0]) {
				echo '<div><span class="icon">]</span> <span class="text">'.$pm['hours'][0].'</span></div>';
			}
			if($pm['region'][0]) {
				echo '<div><span class="icon">_</span> <span class="text">'.$pm['region'][0].'</span></div>';
			}
			echo '</div>';
			echo '</div>';
		}	
		
		echo '<p class="pagination">';
		for($i = 1; $i < $total_pages+1; $i++) {
			if(($i) == $page) {
				echo ($i).' ';
			} else {
				echo '<a href="#" class="page-nav" data-page="'.($i).'">'.($i).'</a> ';
			}
		
		}
		if($page < $total_pages && $total_pages > 1) {
			echo '<a href="#" class="page-nav" data-page="'.($page+1).'">&rarr;</a> ';
		}
		echo '</p>';
			
	}
	exit();
}
add_action( 'wp_ajax_viad_filter_projects', 'viad_filter_projects' );




function viad_filter_profile() {
	
	$p_id = viad_get_profile_id();
	$p_id = $p_id[0];
	$profile = get_post($p_id);	
	
	$cat_ids = wp_get_post_categories($p_id);
	$tag_ids = wp_get_post_tags( $p_id, array( 'fields' => 'ids' ) );

	$json = array();
	$json['tags'] = $tag_ids;
	$json['categories'] = $cat_ids;
	
	$regions = get_post_meta($p_id, 'region');
	$json['regions'] = $regions;
	
	echo json_encode($json);
	
	exit();
}
add_action( 'wp_ajax_viad_filter_profile', 'viad_filter_profile' );



function viad_apply_project_filter() {
	

	$p_id = $_REQUEST['id'];

	$project = get_post($p_id);	
	
	$cat_ids = wp_get_post_categories($p_id);
	$tag_ids = wp_get_post_tags( $p_id, array( 'fields' => 'ids' ) );

	$json = array();
	$json['tags'] = $tag_ids;
	$json['categories'] = $cat_ids;
	
	$meta = get_post_meta($p_id);
	$json['regions'] = $meta['region'];
	if(is_numeric($meta['price'][0])) {
		$json['price'] = $meta['price'][0];
	}
	if(is_numeric($meta['hours'][0])) {
		$json['hours'] = $meta['hours'][0];
	}

	$json['regions'] = $meta['region'];

	
	echo json_encode($json);
	
		
	exit();
}
add_action( 'wp_ajax_viad_apply_project_filter', 'viad_apply_project_filter' );


















?>