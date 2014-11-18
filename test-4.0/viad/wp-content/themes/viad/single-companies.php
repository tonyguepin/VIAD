<?php get_header(); 

//$user_meta = get_user_meta($post->post_author);
//$thumb = wp_get_attachment_image_src( $user_meta['profile_pic'][0], 'thumbnail');


?>
<section class="profile-head">
	<?php echo viad_display_profile_head($post->ID);?>
</section>

<?php if(viad_is_author($post->post_author)) { ?>
<section class="profile-container">
</section>
<?php } ?>

<section class="profile content collapsed" data-height="600">
	<div class="container">

		<aside>
		<?php echo viad_display_statistics($post->ID); ?>
		</aside>

		
		<article id="company-<?php echo $post->ID;?>">
		<?
		$content = apply_filters( 'the_content', $post->post_content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		echo $content;		
		?>
		<?php
/*
		if(viad_is_author($post->post_author)) {
			echo '<div class="editor">';
			echo '<a class="button edit edit-profile-text" data-field="professional-'.$post->ID.'">Edit</a>';
			echo '</div>';
		}
*/
		?>
		</article>

	</div>
</section>

<section class="profile projects collapsed" data-height="400">
	<?php	//echo viad_display_projects($post->post_author); ?>
</section>


<section class="profile reviews collapsed"  data-height="180">
		<?php echo viad_display_reviews($post->post_author);?>	
</section>

<section class="profile blog collapsed" data-height="500">
		<?php echo viad_display_blog($post->post_author);?>	
</section>
<?php if(viad_is_author($post->post_author)) { ?>
<!--

<section class="profile prefs collapsed" data-height="500">
	<div class="container">
		<h2>Instellingen</h2>
		
		
		<div class="input">
			<h4>Profielfoto</h4>
			<label for="i1"><div class="thumbnail profile_pic" style="background-image:url(<? echo $thumb[0];?>);"></div></label>
			<form class="upload-form" method="post" action="#" enctype="multipart/form-data" >
				<input id="i1" type="file" name="file" />
				<input type="hidden" name="post_id" value="<?php echo $post->ID;?>"/>
				<input type="hidden" name="key" value="profile_pic"/>
				<input type="hidden" name="action" value="viad_upload_image"/>
				<input type="hidden" name="size" value="thumbnail"/>
	  		  	<div id="profile_pic_progress" class="progressbar">0%</div>
	  		  	<input type="submit" value="upload" />
			</form>
		</div>
		<?
		$bg_pic = wp_get_attachment_image_src( $user_meta['background_pic'][0], 'thumbnail');
		?>

		<div class="input">
			<h4>Omslagfoto</h4>
			<label for="i2"><div class="thumbnail background_pic" style="background-image:url(<? echo $bg_pic[0];?>);"></div></label>
			<form class="upload-form" method="post" action="#" enctype="multipart/form-data" >
				<input id="i2" type="file" name="file" />
				<input type="hidden" name="post_id" value="<?php echo $post->ID;?>"/>
				<input type="hidden" name="key" value="background_pic"/>
				<input type="hidden" name="action" value="viad_upload_image"/>
				<input type="hidden" name="size" value="full"/>
	  		  	<div id="background_pic_progress" class="progressbar">0%</div>
	  		  	<input type="submit" value="upload" />
			</form>
		</div>
	
		
		<form name="profile-prefs" action="<?php echo get_permalink($post->ID);?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="viad_save_prefs" value="<?php echo $post->ID;?>"/>

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
-->
<?php } ?>
<?php get_footer(); ?>