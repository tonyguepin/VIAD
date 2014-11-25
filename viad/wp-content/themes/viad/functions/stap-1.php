
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
			
			<form class="reg register-form" method="post">
				<div class="container">
					<fieldset class="stap-1">
						<div class="registratie-opties clearfix">
							<div class="registratie-optie">
								<div class="circle blue">&nbsp;</div>
								<div class="radio"><input id="i0" type="radio" name="type" value="professionals" <?php if($_SESSION['type'] == 'professionals') { echo 'checked="checked"'; } ?>/><label for="i0">Professional</label></div>
							</div>
							<div class="registratie-spacer">of</div>
							<div class="registratie-optie">
								<div class="circle green">&nbsp;</div>
								<div class="radio"><input id="i1" type="radio" name="type" value="engeneer" <?php if($_SESSION['type'] == 'engeneer') { echo 'checked="checked"'; } ?> /><label for="i1">Ingenieursbureau</label></div>
							</div>
							<div class="registratie-spacer">of</div>
							<div class="registratie-optie">
								<div class="circle red">&nbsp;</div>
								<div class="radio"><input id="i2" type="radio" name="type" value="companies" <?php if($_SESSION['type'] == 'companies') { echo 'checked="checked"'; } ?> /><label for="i2">Bedrijf / overheid</label></div>
							</div>
						</div>					
					</fieldset>								
				</div>
			</form>
			<div class="register-volgende">
				<a class="button register-button" data-step="2">Volgende stap</a>
			</div>
		</div>

