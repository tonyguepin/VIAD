<?php
/* Template Name:Stap 3 */
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
					<h2>Aanmelden - stap 3</h2>
					<div class="stappen">
						<div class="stap-item done">
							Stap 1
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item done">
							Stap 2
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item selected">
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
					<div class="keur-merk-wrapper">
						<img class="keurmerk" src="<?php bloginfo('template_directory');?>/img/keurmerk-registratie.png" />
						<h2>VIAD Keurmerk </h2>
						<p>Vul hieronder je gegevens in</p>
					</div>
				</div>
			</div>
			
			<div class="register-form">
				<div class="container">
					<fieldset class="stap-3">								
						<div class="kvk-wrapper clearfix">
							<p>KvK nummer *</p>
							<input class="required" name="name" type="text" placeholder="KvK nummer	"/>
						</div>
						<div class="radio-stap-3">
							<p>VAR *</p>
							<div class="radio"><input id="r1" name="pm_var" type="radio" value="ja"/><label for="r1">Ja</label></div>
							<div class="radio"><input id="r2" name="pm_var" type="radio" value="nee"/><label for="r2">Nee</label></div>
						</div>
						<div class="radio-stap-3">
							<p>VOG (Verklaring Omtrent Gedrag) <a href="#">Hoe vraag ik een VOG aan?</a></p>
							<div class="radio"><input id="r3" name="pm_vog" type="radio" value="ja"/><label for="r3">Ja</label></div>
							<div class="radio"><input id="r4" name="pm_vog" type="radio" value="nee"/><label for="r4">Nee</label></div>
						</div>
						<div class="radio-stap-3">
							<p>Gedragscode NLingenieurs 2010 <a href="#">Download PDF bestand</a></p>
							<div class="radio"><input id="r5" name="pm_gedrag" type="radio" value="ja"/><label for="r5">Ja, ik ga akkoord met de Gedragscode NLingenieurs 2010. </label></div>
							<div class="radio"><input id="r6" name="pm_gedrag" type="radio" value="nee"/><label for="r6">Nee, ik ga niet akkoord met de Gedragscode NLingenieurs 2010. </label></div>
						</div>
	
					</fieldset>	
				</div>
			</div>
			<div class="register-akkoord">
				<div class="container">
					<fieldset class="stap-2">								
							<h3 class="white no-bold">En dan nog iets</h3>
							<p class="white no-bold">Bij VIAD vinden we eerlijkheid en transparantie belangrijk. Dit is dan ook een voorwaarde om toegelaten te kunnen worden bij VIAD. Door akkoord te gaan met het VIAD-keurmerk beloof je je profiel en competenties naar waarheid te hebben ingevuld. Je hanteert het principe van afspraak = afspraak. Dit mogen we van jou verwachten maar dit mag jij natuurlijk ook van ons en onze klanten verwachten.</p>
						<div class="radio-stap-3">
							<div class="radio white"><input id="r7" name="pm_akkoord" type="radio" value="ja"/><label for="r7">Ja, dat snap ik en ik ga hiermee akkoord.</label></div>
							<div class="radio white"><input id="r8" name="pm_akkoord" type="radio" value="nee"/><label for="r8">Nee </label></div>
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

