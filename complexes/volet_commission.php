<div id="volet-tarif" class="effet1">
    <button id="aide" data-toggle="modal" data-target="#modal_aide">
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        <span>Aide</span>
    </button>
	<h3 class="center">Gestion des apporteurs d'affaires</h3>
	<hr/>
	<div id="formulaire_tarifs">
		<form method="post" action="planning_commissions_traitement.php">
			<div class="colonne">
				<p class="titre_section_form">Apporteurs d'affaires:</p>
				<div class="liste">
					<?php
						foreach ($liste_aa as $aa_key => $aa_value) {
							?>
								<span>
									<label>
										<?php echo $aa_value['user_nom_societe']; ?>
										<input type="checkbox" name="aa[]" value="<?php echo $aa_value[0]; ?>">
									</label>
								</span>
							<?php
						}
					?>
				</div>
			</div>
				<div class="colonne">
					<p class="titre_section_form">Terrains :</span>
					<div class="liste">
					<?php
						foreach ($liste_terrains as $terrain_key => $terrain_value) {
							?>
								<span>
									<label>
										<?php echo $terrain_value['terrain_nom']; ?>
										<input type="checkbox" name="terrain[]" value="<?php echo $terrain_value[0]; ?>">
									</label>
								</span>
							<?php
						}
					?>
					</div>
				</div>
				<div class="colonne">
					<p class="titre_section_form">Heures :</p>
					<div class="ligne espacer1">
							<span>
								De :
								<select name="heure_debut">
									<?php
										for ($i=10; $i < 23.5 ; $i=$i+0.5) { 
											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}
											$datetime_string = intval($i).':'.$minutes.':00';
											$heure2 = intval($i).":".$minutes.":00";
											if (intval($heure) < 10){
												$datetime_string = '0'.$datetime_string;
												$heure2 = '0'.$heure2;
											}
											?>

												<option value="<?php if ($heure2 == "24:00:00") {echo "00:00:00"; } else { echo $heure2; }?>"><?php echo intval($i).":".$minutes; ?></option>
											<?php
										}
									?>
								</select>
							</span>
							<span>
								À  :		
								<select name="heure_fin">
									<?php
										for ($i=10; $i <= 24 ; $i=$i+0.5) { 
											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}
											$datetime_string = intval($i).':'.$minutes.':00';
											$heure2 = intval($i).":".$minutes.":00";
											if (intval($heure) < 10){
												$datetime_string = '0'.$datetime_string;
												$heure2 = '0'.$heure2;
											}
											?>

												<option value="<?php if ($heure2 == "24:00:00") {echo "00:00:00"; } else { echo $heure2; }?>"><?php echo intval($i).":".$minutes; ?></option>
											<?php
										}
									?>
								</select>
							</span>
					</div>
				</div>
				<div class="colonne">
					<p class="titre_section_form">Jours :</p>
					<div class="liste">
							<?php 
								for ($i = 1; $i < 8; $i++){
									?>
										<span>
											<label>
												<?php 
													if ($i == 7 ){
														echo $joursem[0];
														?><input type="checkbox" name="jour[]" value="0"><?php
													}
													else{
														echo $joursem[$i];
														?><input type="checkbox" name="jour[]" value="<?php echo $i; ?>"><?php
													}
												?>
											</label>
										</span>
									<?php
								}
							?>
					</div>
				</div>
				<div class="colonne">
					<p class="titre_section_form">Commission :</p>
						<input type="number" style="width: 85%;" name="commission" placeholder="15">
						<span> % </span>
				</div>
				<div class="center btn-form">
					<input class="btn btn-success grand" type="submit" value="Valider">
				</div>
						
					</form>
				</div>
</div>