<?php
/* Template Name:Stap 2 */
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
					<h2>Aanmelden - stap 2</h2>
					<div class="stappen">
						<div class="stap-item done">
							Stap 1
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item selected">
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
					<h2>Mijn Account</h2>	
					<p>Vul hieronder je accountgegevens in</p>
				</div>
			</div>
			
			<div class="register-form">
				<div class="container">
					<fieldset class="stap-2">								
						<div class="name-wrapper">
							<p>Naam *</p>
							<input class="required" name="name" type="text" placeholder="Naam"/>
						</div>
						<div class="tussenvoegsel-wrapper">
							<p>Tussenvoegsel</p>
							<input name="insertion" type="text"  placeholder="Tussenvoegsel"/>
						</div>
						<div class="last_name-wrapper">
							<p>Achternaam *</p>
							<input class="required" name="last_name" type="text"  placeholder="Achternaam"/>
						</div>
						<div class="geslacht-wrapper">
							<p>Geslacht</p>
							<div class="radio"><input id="r1" name="pm_gender" type="radio" value="m"/><label for="r1">Man</label></div>
							<div class="radio"><input id="r2" name="pm_gender" type="radio" value="v"/><label for="r2">Vrouw</label></div>
						</div>
						<p>Telefoonnummer *</p>
						<input class="required" name="email" type="email"  placeholder="Telefoonnummer"/>
						<p>E-mailadres *</p>
						<input class="required" name="email" type="email"  placeholder="E-mailadres"/>
						<p>Gebruikersnaam *</p>
						<input class="required" name="user_name" type="text"  placeholder="Gebruikersnaam"/>
						<p>Wachtwoord *</p>
						<input class="required" name="password" type="password"  placeholder="Makkelijk voor jou, maar lastig voor anderen"/>
						<p>Wachtwoord herhalen *</p>
						<input class="required" name="password_again" type="password"  placeholder="Wachtwoord herhalen"/>
	
					</fieldset>	
				</div>
			</div>
			<div class="register-volgende">
				<a class="button register-button">Volgende stap</a>
			</div>
		</div>

</section>

<?php get_footer();?>

