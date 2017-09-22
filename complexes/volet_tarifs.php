<div id="volet-tarif" class="effet1 box fond-blanc contour-bleu">
    <button class="btn btn-grand" id="aide" style="padding:5px;" data-toggle="modal" data-target="#modal_aide">
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        <span>Aide</span>
    </button>
	<h3 class="center">Modification des tarifs</h3>
	<hr/>
	<div id="formulaire_tarifs">
		<form method="post" action="planning_tarifs_traitement.php">
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
										for ($i=8; $i < 24 ; $i=$i+0.5) { 

											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}

											if ($i == 24){
												$datetime_string = '00:00:00';
												$heure2 = '00:00:00';
											}
											elseif ($i < 10){
												$datetime_string = '0'.intval($i).':'.$minutes.':00';
												$heure2 = '0'.intval($i).":".$minutes.":00";
											}
											else{
												$datetime_string = intval($i).':'.$minutes.':00';
												$heure2 = intval($i).":".$minutes.":00";
											}
											
											?>	
												<option value="<?php echo $heure2; ?>"><?php echo intval($i).":".$minutes; ?></option>
											<?php
										}
									?>
								</select>
							</span>
							<span>
								À  :		
								<select name="heure_fin">
									<?php
										for ($i=8; $i <= 24 ; $i=$i+0.5) { 

											if (intval($i) == $i){
												$minutes = "00";
											}
											else{
												$minutes = "30";
											}

											if ($i == 24){
												$datetime_string = '00:00:00';
												$heure2 = '00:00:00';
											}
											elseif ($i < 10){
												$datetime_string = '0'.intval($i).':'.$minutes.':00';
												$heure2 = '0'.intval($i).":".$minutes.":00";
											}
											else{
												$datetime_string = intval($i).':'.$minutes.':00';
												$heure2 = intval($i).":".$minutes.":00";
											}

											?>
												<option value="<?php echo $heure2; ?>"><?php echo intval($i).":".$minutes; ?></option>
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
					<p class="titre_section_form">Prix (Heure) :</p>
						<input type="number" style="width: 85%;" name="tarif" placeholder="15">
						<span> € </span>
				</div>
				<div class="center btn-form">
					<input class="btn btn-valid grand" type="submit" value="Valider">
				</div>
						
					</form>
				</div>
</div>