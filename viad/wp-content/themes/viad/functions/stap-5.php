			<div class="register-titel">
				<div class="container">
					<h2>Aanmelden - stap 5</h2>
					<div class="stappen">
						<div class="stap-item done">
							Stap 1
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item done">
							Stap 2
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item done">
							Stap 3
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item done">
							Stap 4
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
						<div class="stap-item selected last">
							Stap 5
							<a href="#"><div class="stap-rectangle">&nbsp;</div></a>
						</div>
					</div>
				</div>
			</div>
			<div class="register-kop">
				<div class="container">
					<div class="keur-merk-wrapper">
						<h2>Voltooien</h2>
						<p>De laatste stap!</p>
					</div>
				</div>
			</div>
			
			<form class="register-form" method="post">
				<div class="container">
					<fieldset class="stap-5">
						<p>Betaalwijze</p>
						<p>Selecteer hieronder één van de drie betaalwijzes voor jouw VIAD abonnement. Kies je voor ‘Automatische Incasso’ dan zal VIAD maandelijks het abonnementstarief van €24,99 incasseren.</p>
						<div class="betaalwijze">
							<div class="betaal-cirkel"><img class="keurmerk" src="<?php bloginfo('template_directory');?>/img/icon-betaalwijze-creditcard.png" alt="" /></div>
							<p><strong>credit-card</strong></p>
						</div>
						<div class="betaal-spacer">of</div>
						<div class="betaalwijze">
							<div class="betaal-cirkel"><img class="keurmerk" src="<?php bloginfo('template_directory');?>/img/icon-betaalwijze-incasso.png" alt="" /></div>
							<p><strong>incasso</strong></p>
						</div>
						<div class="betaal-spacer">of</div>
						<div class="betaalwijze">
							<div class="betaal-cirkel"><img class="keurmerk" src="<?php bloginfo('template_directory');?>/img/icon-betaalwijze-ideal.png" alt="" /></div>
							<p><strong>ideal</strong></p>
						</div>
						<div class="betaal-spacer">of</div>
						<div class="betaalwijze">
							<div class="betaal-cirkel"><img class="keurmerk" src="<?php bloginfo('template_directory');?>/img/icon-betaalwijze-factuur.png" alt="" /></div>
							<p><strong>jaarlijkse factuur</strong></p>
						</div>
					</fieldset>	
				</div>
			</form>
			<form class="register-afrekening" method="post">
				<div class="container">
					<fieldset class="stap-5">
						<p>Kies uw kaart</p>
						<div class="afrekening-opties">
							<div class="afrekening-optie">
								<div class="circle mastercard">&nbsp;</div>
								<div class="radio"><input id="i0" type="radio" name="type" value="mastercard" checked="checked"/><label for="i0">MasterCard</label></div>
							</div>
							<div class="afrekening-spacer">of</div>
							<div class="afrekening-optie">
								<div class="circle visa">&nbsp;</div>
								<div class="radio"><input id="i1" type="radio" name="type" value="visa"/><label for="i1">VISA</label></div>
							</div>
							<div class="afrekening-spacer">of</div>
							<div class="afrekening-optie">
								<div class="circle ae">&nbsp;</div>
								<div class="radio"><input id="i2" type="radio" name="type" value="ae"/><label for="i2">American Express</label></div>
							</div>
						</div>
						<p>Naam kaarthouder*</p>
						<input class="naam required" name="name" type="text" placeholder="Naam"/>
						<div class="creditcard-number-wrapper">
							<p>Creditcard number *</p>
							<div><input name="cc_number1" type="text" class="number" /><label for="cc_number1">—</label></div>
							<div><input name="cc_number2" type="text" class="number" /><label for="cc_number2">—</label></div>
							<div><input name="cc_number3" type="text" class="number" /><label for="cc_number3">—</label></div>
							<div><input name="cc_number4" type="text" class="number" /></div>
						</div>
						<div class="datum-wrapper">
							<p>Vervaldatum *</p>
							<div><input name="month" type="text" class="number" /><label for="month">/</label></div>
							<div><input name="year" type="text" class="number" /></div>
						</div>
						<p>Beveiligingscode (CVC) *</p>
						<input class="cvc required" name="cvc" type="text" placeholder="CVC"/>	
					</fieldset>	
				</div>
			</form>
			<form class="register-afrekening-akkoord" method="post">
				<div class="container">
					<fieldset class="stap-5">								
							<p class="no-bold"><strong>Algemene Voorwaarden </strong><a href="#">Download PDF bestand</a></p>
						<div class="radio-stap-3">
							<div class="radio white"><input id="r7" name="pm_akkoord" type="radio" value="ja"/><label for="r7">Ja, ik ga akkoord met de Algemene Voorwaarden van VIAD.nl</label></div>
							<div class="radio white"><input id="r8" name="pm_akkoord" type="radio" value="nee"/><label for="r8">Nee, ik ga niet akkoord met de Algemene Voorwaarden van VIAD.nl</label></div>
						</div>
	
					</fieldset>	
				</div>
			</form>
			<div class="register-volgende">
				<a class="button register-button" data-step="4">Vorige stap</a>
				<a class="button register-button" data-step="6">Volgende stap</a>
			</div>
		</div>

