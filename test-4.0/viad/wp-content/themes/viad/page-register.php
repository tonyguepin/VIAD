<?php
/* Template Name:Register */
get_header();
?>
<section class="register">


		<div class="container">
		<aside class="filter">
			<?php			

			if(viad_get_user_type() == 'companies') {
				
				
				$projects = get_posts(array('post_type' => 'projects', 'author' => get_current_user_id()));
				if($projects) {
					echo '<select class="filter-project">';
					echo '<option disabled selected>Project toepassen</option>';
					foreach($projects as $p) {
						echo '<option value="'.$p->ID.'">'.$p->post_title.'</option>';
					}
					echo '</select>';
				}
				
			}
				echo '<a href="#" class="button gray show-all">Toon alles</a>';
			
				
				$categories = get_categories(array('hide_empty' => 0, 'parent' => 0, 'exclude' => 1));
				
				echo '<h3>Categorie&euml;n</h3>';
				echo '<ul class="categories">';
				foreach($categories as $cat) {
					$sub_categories = get_categories(array('hide_empty' => 0, 'child_of' => $cat->term_id, 'exclude' => 1));

					echo '<li class="parent-category" data-id="'.$cat->term_id.'" data-value="'.$cat->term_id.'">';
					
					if($sub_categories) {
						echo '<div class="more-categories icon-essential-regular-16-plus-cricle" data-id="'.$cat->term_id.'"></div>';
					}

					echo '<input id="c'.$cat->term_id.'" type="checkbox"/>';
					echo '<label for="c'.$cat->term_id.'">';
					echo $cat->name;
					echo '</label>';
					echo '</li>';

					foreach($sub_categories as $sub_cat) {
						echo '<li class="child-category" data-id="'.$cat->term_id.'" data-value="'.$sub_cat->term_id.'">';
						echo '<input id="c'.$sub_cat->term_id.'" type="checkbox"/>';
						echo '<label for="c'.$sub_cat->term_id.'">';
						echo $sub_cat->name;
						echo '</label>';
						echo '</li>';
					}
				}
				echo '</ul>';


				$tags = get_tags(array('hide_empty' => 0));
				echo '<h3>Functies</h3>';
				echo '<ul>';
				foreach($tags as $i => $tag) {
					if($tag->count >= 2) {
						echo '<li class="tag open" data-value="'.$tag->term_id.'" data-count="'.$tag->count.'">';
						echo '<input id="t'.$tag->term_id.'" type="checkbox" />';
						echo '<label for="t'.$tag->term_id.'">';
						echo $tag->name;
						echo '</label>';
						echo '</li>';
					} else {
						echo '<li class="tag" data-value="'.$tag->term_id.'">';
						echo '<input id="t'.$tag->term_id.'" type="checkbox" />';
						echo '<label for="t'.$tag->term_id.'">';
						echo $tag->name;
						echo '</label>';
						echo '</li>';
					}
				}
				echo '<li class="function more"><a class="more-tags" href="#">Bekijk meer</a></li>';
				echo '</ul>';

				echo '<h3>Tarief</h3>';
				echo '<ul>';
				echo '<li class="slider"><div id="slider-price"></div></li>';
				echo '</ul>';

				echo '<h3>Uren per week</h3>';
				echo '<ul>';
				echo '<li class="slider"><div id="slider-hours"></div></li>';
				echo '</ul>';



				$regions = array('Noord','Oost','Midden','Zuid','West');
				echo '<h3>Regio</h3>';
				echo '<ul>';
				foreach($regions as $i => $r) {
						echo '<li class="region" data-value="'.$r.'">';
						echo '<input id="r'.$i.'" type="checkbox" />';
						echo '<label for="r'.$i.'">';
						echo $r;
						echo '</label>';
						echo '</li>';
				}
				echo '</ul>';

		
			?>
	

		</aside>
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
	

					<a class="button register-button">Verder</a>



			</form>
		</div>






</section>

<?php get_footer();?>

