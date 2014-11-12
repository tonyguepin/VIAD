<section class="profile-head">
	<?php echo viad_display_profile_head(get_current_user_id()); ?>
</section>


<section class="dashboard main"> DASHBOARD
		
	<?php	echo viad_display_professionals_db(); ?>

</section>


<section class="dashboard calendar">
		<?php echo viad_display_calendar(get_current_user_id());?>	
</section>


<section class="dashboard projects" data-height="400">
	<h2>Interessant voor jou?</h2>
	<div class="container">
	<?php
		$p_id = viad_get_profile_id();
		$p = get_post($p_id[0]);
		$prof_meta = get_post_meta($p->ID);
		$cats = wp_get_post_categories( $p->ID);
		$tags = wp_get_post_tags( $p->ID);
		$tag_ids = array();
		foreach($tags as $t) {
			$tag_ids[] = $t->term_id;
		
		}
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
			
			echo viad_display_project_card($match->ID);
			
		}
	?>
	</div>
</section>