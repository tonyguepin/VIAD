<?php
/* Template Name:Stap 1 */
get_header();
?>
<section class="register">

			<!--
			<aside class="filter">
			aside ja/nee?
			</aside>
			-->

			<div class="register-titel">
				<div class="container">
					<h2>Aanmelden - stap 1</h2>
					<div class="stappen">
						<div class="stap-item selected">
							Stap 1
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item">
							Stap 2
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item">
							Stap 3
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item">
							Stap 4
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item last">
							Stap 5
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="register-kop">
				<div class="container">
					<h2>Ik ben ...</h2>	
					<p>Maak hieronder een keuze uit een van de drie opties.</p>
				</div>
			</div>
			
			<div class="register-form">
				<div class="container">
					<fieldset class="stap1">
						<div class="registratie-opties clearfix">
							<div class="registratie-optie">
								<div class="circle blue">&nbsp;</div>
								<div class="radio"><input id="i0" type="radio" name="type" value="professionals" checked="checked"/><label for="i0">Professional</label></div>
							</div>
							<div class="registratie-spacer">of</div>
							<div class="registratie-optie">
								<div class="circle green">&nbsp;</div>
								<div class="radio"><input id="i1" type="radio" name="type" value="companies"/><label for="i1">Ingenieursbureau</label></div>
							</div>
							<div class="registratie-spacer">of</div>
							<div class="registratie-optie">
								<div class="circle red">&nbsp;</div>
								<div class="radio"><input id="i2" type="radio" name="type" value="companies"/><label for="i2">Bedrijf / overheid</label></div>
							</div>
						</div>					
					</fieldset>								
				</div>
			</div>
			<div class="register-volgende">
				<a class="button register-button">Volgende stap</a>
			</div>
		</div>
</section>

<?php get_footer();?>

