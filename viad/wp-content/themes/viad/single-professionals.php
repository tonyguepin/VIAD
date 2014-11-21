<?php get_header(); ?>
<section class="profile-head">
	<?php echo viad_display_profile_head($post->ID);?>
</section>



<section class="profile professionals">
<?			
			$umeta = get_user_meta(get_current_user_id());
			print_r($umeta);
?>
	<div class="container">

		<aside class="left">
		<?php 
			
			if(viad_is_author($post->post_author)) { 
				echo '<a href="#/dashboard" class="button gray">Dashboard</a>';
			}
			
			echo '<h3>Functies</h3>';
			$functies = wp_get_post_tags($post->ID);
			echo '<ul>';			
			foreach($functies as $f) {
				echo '<li>'.$f->name.'</li>';
			}			
			echo '</ul>';			
			
			$post_meta = get_post_meta($post->ID);
			
			echo '<h3>Beschikbaar</h3>';
			echo '<ul>';			
			echo '<li>'.$post_meta['hours'][0].' uur per week</li>';
			echo '</ul>';			

			echo '<h3>Tarief</h3>';
			echo '<ul>';			
			echo '<li>&euro; '.$post_meta['price'][0].' per uur</li>';
			echo '</ul>';			

			
		?>
		</aside>

		<article class="content">
			<h2>Over mij</h2>
			<?php
				echo viad_content($post->post_content);
			?>

		</article>

	</div>
</section>

<section class="profile calendar">
		<?php echo viad_display_calendar($post->post_author);?>	
</section>

<section class="profile reviews">
		<?php echo viad_display_reviews($post->post_author);?>	
</section>



<section class="profile blog">
		<?php //echo viad_display_blog($post->post_author);?>	
</section>
<?php if(viad_is_author($post->post_author)) { ?>



<?php } ?>
<?php get_footer(); ?>