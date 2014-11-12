<?php get_header(); 




?>


<section class="profile-head">
	<?php echo viad_display_profile_head($post->ID);?>
</section>



<section class="content">

	<div class="container">

		<aside>
			<?php echo viad_display_statistics($post->ID); ?>
		</aside>

		
		<article>
		<?

		$subscribed = viad_get_subscribed_projects();

		$post_meta = get_post_meta($post->ID); 
			
		echo '<article class="job">';
		echo '<h2>'.$post->post_title.'</h2>';
		
		$tags = wp_get_post_tags($post->ID);
		foreach($tags as $tag) {
			$level = $post_meta['level_'.$tag->term_id][0];
		}
		echo '<h3>'.$tag->name.' '.$level.'</h3>';
		
		echo viad_content($post->post_content);		
		
		
		echo '<p>Deadline inschrijvingen';
		echo '<br/>'.date_i18n('j M y', $post_meta['deadline'][0]).'</p>';

		echo '<p>Start datum';
		echo '<br/>'.date_i18n('j M y', $post_meta['start_date'][0]).'</p>';

		echo '<p>Eind datum';
		echo '<br/>'.date_i18n('j M y', $post_meta['end_date'][0]).'</p>';
	
		echo '<p>Professionals ingeschreven';
		echo '<br/>'.count($post_meta['subscribed']).'</p>';
	
		$euro = '';
		if(is_numeric($post_meta['price'][0])) {
			$euro = '&euro; ';
		} 


		echo '<p>Uurtarief';
		echo '<br/>'.$euro.$post_meta['price'][0].'</p>';

		echo '<p>Regio';
		echo '<br/>'.$post_meta['region'][0].'</p>';


		
		
		echo '</article>';		
		
		
		
		if(!viad_is_author($post->post_author)) {
			if(!in_array($post->ID, $subscribed)) {
				echo '<br class="clear"/>';
				echo '<a href="#" class="button project-subscribe" data-project-id="'.$post->ID.'">Inschrijven</a>';
			}
		}

		?>
		</article>


	</div>
</section>

<section class="profile reviews collapsed"  data-height="180">
		<?php echo viad_display_reviews($post->post_author);?>	
</section>
<?php get_footer(); ?>