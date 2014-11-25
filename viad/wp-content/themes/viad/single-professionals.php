<?php get_header(); ?>
<section class="profile-head">
	<?php echo viad_display_profile_head($post->ID);?>
</section>



<section class="profile professionals">
<?			
			$umeta = get_user_meta(get_current_user_id());
			//print_r($umeta);
?>
	<div class="container">

		<aside class="left">
		<?php 
			
			if(viad_is_author($post->post_author)) { 
				echo '<a href="#/dashboard" class="button gray">Dashboard</a>';
			}
			
			echo '<h3 class="functies">Functies</h3>';
			$functies = wp_get_post_tags($post->ID);
			echo '<ul>';			
			foreach($functies as $f) {
				echo '<li>'.$f->name.'</li>';
			}			
			echo '</ul>';			
			
			$post_meta = get_post_meta($post->ID);
			
			echo '<h3 class="beschikbaar">Beschikbaar</h3>';
			echo '<ul>';			
			echo '<li>'.$post_meta['hours'][0].' uur per week</li>';
			echo '</ul>';			

			echo '<h3 class="regio">Regio</h3>';
			echo '<ul>';			
			echo '<li>'.$post_meta['hours'][0].' uur per week</li>';
			echo '</ul>';			

			echo '<h3 class="tarief">Tarief</h3>';
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

<section class="profile review-plaatsen">
			<div class="register-kop">
				<div class="container">
					<h2>Schrijf iets over <?php printf("%s %s", $umeta['first_name'][0], $umeta['last_name'][0]) ?></h2>	
				</div>
			</div>
			
			<div class="register-form">
				<div class="container">
					<fieldset class="fieldset-review-plaatsen">								
						<div class="name-wrapper">
							<p>Naam *</p>
							<input class="required" name="name" type="text" placeholder="Naam"/>
						</div>
						<p>E-mailadres *</p>
						<input class="required" name="email" type="email"  placeholder="E-mailadres"/>
						<p>Uw review *</p>
						<textarea class="required" name="review"  placeholder="Review plaatsen"></textarea>
						<div class="review-plaatsen-label">Geef uw waardering op voor <?php printf("%s %s", $umeta['first_name'][0], $umeta['last_name'][0]) ?>:</div> 
						<div class="review-plaatsen-rating">
							<?
							echo viad_star_svg('rate rate_1');
							echo viad_star_svg('rate rate_2');
							echo viad_star_svg('rate rate_3');
							echo viad_star_svg('rate rate_4');
							echo viad_star_svg('rate rate_5');
							?>
						</div>
						<a href="#" class="button new-review" data-id="'.$user_id.'">Review plaatsen</a>
					</fieldset>	
				</div>
			</div>

</section>


<section class="profile blog">
		<?php echo viad_display_blog($post->post_author);?>	
</section>

<?php if(viad_is_author($post->post_author)) { ?>



<?php } ?>
<?php get_footer(); ?>