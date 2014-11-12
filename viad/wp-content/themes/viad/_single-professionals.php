<?php get_header(); ?>
<section class="profile-head">
	<?php echo viad_display_profile_head($post->ID);?>
</section>

<a href="#/dashboard">Dashboard</a><br/>
<a href="#/notificaties">Notificaties</a><br/>
<a href="#/instellingen">Instellingen</a><br/>
<a href="#/bewerken">Profiel bewerken</a><br/>

<section class="profile content">
	<div class="container">
		
		<a href="<?php get_permalink($post->ID); ?>">Profiel pagina</a><br/>
		
		<aside>
			<?php echo viad_display_statistics($post->ID); ?>
		</aside>

		
		<article id="professional-<?php echo $post->ID;?>">
		
		
		<?
		$content = apply_filters( 'the_content', $post->post_content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;		
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
		<?php echo viad_display_blog($post->post_author);?>	
</section>
<?php if(viad_is_author($post->post_author)) { ?>



<?php } ?>
<?php get_footer(); ?>