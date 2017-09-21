<div id="volet-tarif" class="effet1">
	<h3 class="center">Modification des horaires</h3>
	<hr/>
	<div id="formulaire_tarifs">
		<form method="post" action="planning_horaires_traitement.php">
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
				<p class="titre_section_form">Action :</p>
				<div class="liste">
					<label>
						<span>Ouvrir à la réservation</span>
						<input type="radio" name="statut" value="1">
					</label>
					<label>
						<span>Fermer à la réservation</span>
						<input type="radio" name="statut" value="2">
					</label>
				</div>
			</div>
			<div class="center btn-form">
				<input class="btn btn-success" type="submit" value="Valider">					
			</div>			
		</form>
	</div>
</div>