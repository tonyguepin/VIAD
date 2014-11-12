<?php
/* Template Name:Frontpage */
?>
<section class="projects overview collapsed">
	<?php echo viad_archive_projects('frontpage'); ?>
</section>

<section class="frontpage">
<?php	
	
	$fp_blocks = get_posts(array('post_type' => 'fp_blocks', 'orderby' => 'menu_order', 'order' => 'ASC', 'posts_per_page' => -1));
	
	
	foreach($fp_blocks as $fpb) {
		
		$title = $fpb->post_title;
		preg_match_all('!\d+!', $title, $matches);
		if($matches) {
			$title = str_replace($matches[0][0],'<span class="circle">'.$matches[0][0].'</span>', $title);
		}		
		
		$class = get_field('background', $fpb->ID);
		echo '<article class="frontpage-block '.$class.'">';
		echo '<div class="container">';	
		
		$img = get_field('image', $fpb->ID);
		if($img) {
			echo '<img class="two" src="'.$img['sizes']['large'].'" />';
		}		

		echo '<div class="text three">';
		echo '<h2>'.$title.'</h2>';
		echo viad_content($fpb->post_content);
		echo '</div>';

		
		echo '</div>';
		echo '</article>';	
	}
?>
</section>



