<?
/* Template Name:Match */
?>

<?php get_header(); ?>


<section>
	<div class="container"> 

		<?
		$professionals = get_posts(array('post_type'=>'professionals', 'posts_per_page' => -1, 'author' => get_current_user_id()));
		foreach($professionals as $p) {
			$prof_meta = get_post_meta($p->ID);
			$cats = wp_get_post_categories( $p->ID);
			$tags = wp_get_post_tags( $p->ID);

			$tag_ids = array();
			foreach($tags as $t) {
				$tag_ids[] = $t->term_id;
			
			}
			
			// OP META EN CATEGORIE
			$args = array(
			    'post_type'         => 'projects',
 				'category__in' 		=> $cats, 
 				'tag__in'			=> $tag_ids, 
			    'posts_per_page'    => -1,
			    'meta_query'        => array(
			        array(
			            'key'       => 'region',
			            'value'		=> $prof_meta['region'],
			            'compare'   => 'IN'
			        )
			    )
			);
			$matches = get_posts( $args );
			echo '<br/>matches:<br/>';
			foreach($matches as $match) {
				$pm = get_post_meta($match->ID);
				$cats = wp_get_post_categories( $match->ID);

				
				$blocked = false;
				$blocked_dates = get_post_meta($p->ID, 'viad_not_available', true);
				
				if($blocked_dates) {
					foreach (range($pm['start_date'][0], $pm['end_date'][0], 86400) as $day) {
						if(in_array(strtotime('0:00',$day), $blocked_dates)) {
							$blocked =  true;
						}
						
					}	
				
				}
				echo $match->ID.' '.$match->post_title.' / '.$pm['region'][0].' / '.date('d-m-y',$pm['start_date'][0]).' tot '.date('d-m-y',$pm['end_date'][0]);
			}
			
/*



			$args = array(
				'post_type'=>'projects',
				'category__in' => $cats,
				'tag__in'=> $tag_ids,
				'posts_per_page' => -1,
			);
			$matches = get_posts( $args );
			
			$blocked_dates = get_post_meta($p->ID, 'viad_not_available', true);
			
			
			echo '<br/>Op skill en meta[tijd]:<br/>';
			foreach($matches as $match) {
				$pm = get_post_meta($match->ID);
				$cats = wp_get_post_categories( $match->ID);

				echo $match->ID.' '.$match->post_title.' / '.$pm['region'][0].' / '.$pm['profession'][0].' / '.date('d-m-y',$pm['start_date'][0]).' tot '.date('d-m-y',$pm['end_date'][0]);
				
				$blocked = false;
				
				if($blocked_dates) {
					foreach (range($pm['start_date'][0], $pm['end_date'][0], 86400) as $day) {
						if(in_array(strtotime('0:00',$day), $blocked_dates)) {
							$blocked =  true;
						}
						
					}	
				
				}
				if($blocked == true) {
					echo '[blocked date]';
				}
				
				echo '<br/>';
*/
/*

					foreach($blocked_dates as $bd) {
						if($bd <= $pm['start_date'][0] && $bd <= $pm['end_date'][0]) {
						} else {
							echo $match->ID.' '.$match->post_title.' / '.$pm['region'][0].' / '.$pm['profession'][0].' / '.date('d-m-y',$pm['start_date'][0]).' tot '.date('d-m-y',$pm['end_date'][0]).'<br/>';
						}
					}
				}
*/
				
				
				
				//print_r($cats);
				//echo '<br/>';



			// OP META EN CATEGORIE
			/*
			$args = array(
				'post_type'=>'projects',
				'category__in' => $cats,
				'posts_per_page' => -1,
			);
			$matches = get_posts( $args );


			
			echo '<br/>Op skill en meta[tijd] NOT BETWEEN: <br/>';
			foreach($matches as $match) {
				$pm = get_post_meta($match->ID);
				echo $match->ID.' '.$match->post_title.' / '.$pm['region'][0].' / '.$pm['profession'][0].' / '.$pm['start_date'][0].' tot '.$pm['end_date'][0].'<br/>';
			}
*/







			echo '<br/>';
		}
		

		
		?>

	</div>
<section>


<?php get_footer(); ?>