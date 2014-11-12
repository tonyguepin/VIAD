<?php get_header(); ?>

<section class="professionals">
	<div class="container">

		<aside class="filter">
			<?php			

			if(viad_get_user_type() == 'companies') {
				
				
				$projects = get_posts(array('post_type' => 'projects', 'author' => get_current_user_id()));
				if($projects) {
					echo '<select class="filter-project">';
					echo '<option disabled selected>Project toepassen</option>';
					foreach($projects as $p) {
						echo '<option value="'.$p->ID.'">'.$p->post_title.'</option>';
					}
					echo '</select>';
				}
				
			}
				echo '<a href="#" class="button gray show-all">Toon alles</a>';
			
				
				$categories = get_categories(array('hide_empty' => 0, 'parent' => 0, 'exclude' => 1));
				
				echo '<h3>Categorie&euml;n</h3>';
				echo '<ul class="categories">';
				foreach($categories as $cat) {
					$sub_categories = get_categories(array('hide_empty' => 0, 'child_of' => $cat->term_id, 'exclude' => 1));

					echo '<li class="parent-category" data-id="'.$cat->term_id.'" data-value="'.$cat->term_id.'">';
					
					if($sub_categories) {
						echo '<div class="more-categories icon-essential-regular-16-plus-cricle" data-id="'.$cat->term_id.'"></div>';
					}

					echo '<input id="c'.$cat->term_id.'" type="checkbox"/>';
					echo '<label for="c'.$cat->term_id.'">';
					echo $cat->name;
					echo '</label>';
					echo '</li>';

					foreach($sub_categories as $sub_cat) {
						echo '<li class="child-category" data-id="'.$cat->term_id.'" data-value="'.$sub_cat->term_id.'">';
						echo '<input id="c'.$sub_cat->term_id.'" type="checkbox"/>';
						echo '<label for="c'.$sub_cat->term_id.'">';
						echo $sub_cat->name;
						echo '</label>';
						echo '</li>';
					}
				}
				echo '</ul>';


				$tags = get_tags(array('hide_empty' => 0));
				echo '<h3>Functies</h3>';
				echo '<ul>';
				foreach($tags as $i => $tag) {
					if($tag->count >= 2) {
						echo '<li class="tag open" data-value="'.$tag->term_id.'" data-count="'.$tag->count.'">';
						echo '<input id="t'.$tag->term_id.'" type="checkbox" />';
						echo '<label for="t'.$tag->term_id.'">';
						echo $tag->name;
						echo '</label>';
						echo '</li>';
					} else {
						echo '<li class="tag" data-value="'.$tag->term_id.'">';
						echo '<input id="t'.$tag->term_id.'" type="checkbox" />';
						echo '<label for="t'.$tag->term_id.'">';
						echo $tag->name;
						echo '</label>';
						echo '</li>';
					}
				}
				echo '<li class="function more"><a class="more-tags" href="#">Bekijk meer</a></li>';
				echo '</ul>';

				echo '<h3>Tarief</h3>';
				echo '<ul>';
				echo '<li class="slider"><div id="slider-price"></div></li>';
				echo '</ul>';

				echo '<h3>Uren per week</h3>';
				echo '<ul>';
				echo '<li class="slider"><div id="slider-hours"></div></li>';
				echo '</ul>';



				$regions = array('Noord','Oost','Midden','Zuid','West');
				echo '<h3>Regio</h3>';
				echo '<ul>';
				foreach($regions as $i => $r) {
						echo '<li class="region" data-value="'.$r.'">';
						echo '<input id="r'.$i.'" type="checkbox" />';
						echo '<label for="r'.$i.'">';
						echo $r;
						echo '</label>';
						echo '</li>';
				}
				echo '</ul>';

		
			?>
	

		</aside>		
		<div class="results"></div>
	</div>	
</section>

<?php get_footer(); ?>


