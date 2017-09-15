<div id="datepicker1">
	<form action="page_reservation.php<?php if(isset($_GET['id'])){ echo '?id='.$_GET['id']; } ?>" method="post">
		<input type="hidden" id="input_jour" name="jour" value="">
		<div class="liste"> 
	<h2 class="center">Sélectionnez un jour et une durée</h2>
			<div class="ligne espacer1">
				<span id="datepicker" value="<?php if (isset($_POST['jour'])) { echo $_POST['jour']; } ?>"></span>
			</div>
			<div class="ligne espacer1">
				<label class="center">
					<span>Durée de jeu</span>
					<select name="duree" class="center">
						<?php
							for ($i=0.5; $i <= 2 ; $i=$i+0.5) { 
								?>
									<option value="<?php echo $i*60; ?>" <?php if($i == 1.0 ){ echo "selected"; }?>><?php echo $i*60; ?></option>
								<?php
							}
						?>
					</select>
				</label>
			</div>
			<div class="center">
				<input class="btn btn-success btn2 center" id="submit_form" type="submit" value="Voir les disponibilités">
			</div>
		</div>
	</form>
</div>