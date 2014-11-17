<?php if($post->post_type == 'page') { ?>
	<section class="match">
		<div class="overlay blue"></div>
    	<div class="container">
		<h1>Vind jouw zakelijke match.</h1>
		</div>
	</section>
<?php } ?>
	<section class="partners">
    	<div class="container">
		<?php
		$logos = get_field('logos', 207);
		foreach($logos as $l) {
			if($l['caption']) {
				echo '<a href="'.$l['caption'].'" target="_blank">';
				echo '<img src="'.$l['sizes']['large'].'" />';
				echo '</a>';
			} else {
				echo '<img src="'.$l['sizes']['large'].'" />';
			}
		}
		?>
		</div>
	</section>

	<section class="footer">Footer info</section>

    <section class="logo">
    	<div class="container">
			<a class="logo-svg" href="<?php echo home_url();?>"><?php echo viad_display_logo_svg('blue');?></a>
		</div>
    </section>



        <script src="<?php bloginfo('template_directory');?>/js/vendor/modernizr-2.6.2.min.js"></script>
      	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <script src="<?php bloginfo('template_directory');?>/js/nav.js"></script>
        <script src="<?php bloginfo('template_directory');?>/js/plugins.js"></script>
	    <script src="http://malsup.github.com/jquery.form.js"></script> 
        <script src="<?php bloginfo('template_directory');?>/js/main.js"></script> 
          <script src="<?php bloginfo('template_directory');?>/js/filter.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X');ga('send','pageview');
        </script>
    </body>
</html>


