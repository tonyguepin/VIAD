<?php get_header(); ?>


<section>
	<div class="container">

		<?php echo viad_content($post->post_content);?>
		<p>
		<a class="button" href="<?php echo get_permalink(15);?>">Registeren</a>
		</p>
	</div>
<section>


<?php get_footer(); ?>