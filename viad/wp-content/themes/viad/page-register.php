<?php
/* Template Name:Register */
get_header();
?>
<section class="register">





		<div class="container">
			<form class="register-form" method="post" enctype="multipart/form-data">
				
				<div class="register step-1">
					<fieldset class="visible">								
						<h2>Registreren stap 1</h2>	
	
						<h3>Ik ben</h3>
						<div class="radio"><input id="i0" type="radio" name="type" value="professionals" checked="checked"/><label for="i0">Professional</label></div>
						<div class="radio"><input id="i1" type="radio" name="type" value="companies"/><label for="i1">Ingenieursbureau</label></div>
						<div class="radio"><input id="i2" type="radio" name="type" value="companies"/><label for="i2">Bedrijf/overheid</label></div>
					</fieldset>								
	
					
					<fieldset>								
						<h3>Account</h3>
						<p>Naam *</p>
						<input class="required" name="name" type="text" placeholder="Naam"/>
						<p>Tussenvoegsel</p>
						<input name="insertion" type="text"  placeholder="Tussenvoegsel"/>
						<p>Achternaam *</p>
						<input class="required" name="last_name" type="text"  placeholder="Achternaam"/>
						<p>Gebruikersnaam *</p>
						<input class="required" name="user_name" type="text"  placeholder="Gebruikersnaam"/>
						<p>Mailadres *</p>
						<input class="required" name="email" type="email"  placeholder="Mailadres"/>
						<p>Wachtwoord *</p>
						<input class="required" name="password" type="password"  placeholder="Wachtwoord"/>
						<p>Wachtwoord herhalen *</p>
						<input class="required" name="password_again" type="password"  placeholder="Herhaal wachtwoord"/>
						<p>Geslacht</p>
						<div class="radio"><input id="r8" name="pm_gender" type="radio" value="m"/><label for="r8">Man</label></div>
						<div class="radio"><input id="r9" name="pm_gender" type="radio" value="v"/><label for="r9">Vrouw</label></div>
	
					</fieldset>	

					<fieldset>								
						<h3>Abonnement</h3>
						<div class="radio"><input id="r1" name="membership" type="radio" value="basic" checked="checked"/><label for="r1">Basic</label></div>
						<div class="radio"><input id="r2" name="membership" type="radio" value="plus"/><label for="r2">Plus</label></div>
						<div class="radio"><input id="r3" name="membership" type="radio" value="premium"/><label for="r3">Premium</label></div>
					</fieldset>								


					<fieldset class="payment hidden">								
						<h3>Betaalwijze</h3>
						<div class="radio"><input id="r10" name="payment" type="radio" value="1" checked="checked"/><label for="r10">iDeal</label></div>
						<div class="radio"><input id="r20" name="payment" type="radio" value="2"/><label for="r20">Automatische Incasso</label></div>
					</fieldset>								

					<a class="button register-button">Verder</a>
				</div>
				
											
				<div class="register step-2">
					<h2>Registreren stap 2</h2>	
					<fieldset>
						<h3>Personalia</h3>
						<input class="required" name="pm_address" type="text" placeholder="Adres"/>
						<input class="required" name="pm_postal_code" type="text" placeholder="Postcode"/>
						<input class="required" name="pm_place" type="text" placeholder="Plaats"/>
						<input name="pm_phone" type="text"  placeholder="Telefoon"/>
						<input name="pm_website" type="text"  placeholder="Website"/>
						<input name="pm_vat" type="text"  placeholder="BTW"/>
						<input name="pm_coc" type="text"  placeholder="KVK"/>
						<input name="pm_bank" type="text"  placeholder="Bankrekeningnummer"/>
					</fieldset>
	
					<fieldset class="hidden contact">
						<h3>Contactpersoon</h3>
						<input name="um_contact_name" type="text" placeholder="Naam"/>
						<input name="um_contact_last_name" type="text" placeholder="Achternaam"/>
						<input name="um_contact_email" type="email" placeholder="Mailadres"/>
						<input name="um_contact_phone" type="text"  placeholder="Telefoon"/>
					</fieldset>
				</div>
	




			</form>
		</div>






</section>

<?php get_footer();?>

