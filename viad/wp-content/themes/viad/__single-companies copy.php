<?php get_header(); 

$user_meta = get_user_meta($post->post_author);
$thumb = wp_get_attachment_image_src( $user_meta['profile_pic'][0], 'thumbnail');


?>
<section class="profile-head">
	<div class="container">
		<div class="thumbnail profile_pic" style="background-image:url(<? echo $thumb[0];?>);"></div>
		<div class="title">
			<h2><?php the_title(); ?></h2>
			<h3><?php echo $user_meta['profession'][0];?></h3>
		</div>
	</div>
</section>



<section class="profile content collapsed">
	<div class="container">
		
		<aside>
			<a href="#" class="button send-email">Test html mail</a>
			<a href="#" class="button send-message" data-from="5" data-to="2">Test message</a>

		</aside>
		
		<article id="company-<?php echo $post->ID;?>">
		<?
		$content = apply_filters( 'the_content', $post->post_content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;		
		?>
		</article>
		<?php
		if(viad_is_author($post->post_author)) {
			echo '<div class="editor">';
			echo '<a class="button edit edit-profile-text" data-field="professional-'.$post->ID.'">Edit</a>';
			echo '</div>';
		}
		?>
		
	</div>
</section>

<?php if(viad_is_author($post->post_author)) { ?>
<section class="profile-container">
</section>
<?php } ?>

<section class="company projects collapsed">
	
	<?php echo viad_display_projects($post->post_author); ?>

</section>

<section class="profile blog collapsed">
		
		<?php echo viad_display_blog($post->post_author);?>	
	
		
</section>
<?php if(viad_is_author($post->post_author)) { ?>

<section class="profile prefs collapsed">
	<div class="container">
		<h2>Instellingen</h2>
		
		<form name="profile-prefs" action="<?php echo get_permalink($post->ID);?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="viad_save_prefs" value="<?php echo $post->ID;?>"/>
			<div class="input">
				<label for="i1">Profielfoto:</label>
				<input id="i1" type="file" name="profile_pic"/>
			</div>
			<div class="input">
				<label for="i2">Omslagfoto:</label>
				<input id="i2"  type="file" name="background_pic"/>
			</div>
			<div class="input">
				<input id="i3"  type="text" name="profession" placeholder="Vakgebied" value="<?php echo $user_meta['profession'][0];?>"/>
			</div>
			<div class="input">
				<input id="i4"  type="text" name="price" placeholder="Uurtarief" value="<?php echo $user_meta['price'][0];?>"/>
			</div>

			<div class="input">
				<select id="i4"  type="text" name="region">
					<?php
						$regions = array('Noord','Midden','Zuid');
						foreach($regions as $r) {
							$selected = '';
							if($user_meta['region'][0] == $r) {
								$selected = 'selected="selected"';
							}
							echo '<option value="'.$r.'" '.$selected.'>'.$r.'</option>';
						}
					?>
				</select>
			</div>

			<div class="input">
			<?php
			
				if(viad_user_in_spotlight($post->post_author)) {
					$checked = 'checked="checked"';
					$points_left = viad_spotlight_points_left($user_meta['spotlight_start'][0], $user_meta['spotlight_points'][0]);					
				} else {
					$points_left = $user_meta['spotlight_points'][0];
				}
				echo '<input id="i5" type="checkbox" name="spotlight" '.$checked.' />';
				echo '<label for="i5"> Spotlight dagen over: '.$points_left.'</label>';
			?>
			
			
			</div>

			<input type="submit" value="Save"/>
		</form>
	</div>
</section>
<?php } ?>
<?php get_footer(); ?>