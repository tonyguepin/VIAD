
<section class="profile-head">
	<?php echo viad_display_profile_head(get_current_user_id()); ?>
</section>

<section class="profile-head">
	<?php	echo viad_display_profile_head($user->ID); ?>
</section>



<section class="projects">
			

	<?php	echo viad_display_companies_db(); ?>




</section>


<section>

</section>

<section class="dashboard projects overview">
	
	<?php echo viad_archive_projects('dashboard'); ?>


</section>







