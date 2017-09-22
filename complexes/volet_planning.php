<div id="volet-tarif" style="min-width: 250px;" class="effet1 box fond-blanc contour-bleu">
    <button class="btn" id="aide" data-toggle="modal" data-target="#modal_aide">
        <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        <span>Aide</span>
    </button>
	<h3 class="center">Choisir votre date</h3>
		<hr/>
	<div class="has-feedback">
		<form action="planning.php" method="post">
			<input type="hidden" id="input_jour" name="jour" value="">
			<div class="div_input2"> 
				<div class="ligne">
					<span id="datepicker" value="<?php if (isset($_POST['jour'])) { echo $_POST['jour']; } ?>"></span>
				</div>
				<div class="center">
					<span>Afficher par :</span>
				</div>
				<div class="ligne espacer1">
					<label>
						<span>Jour</span>
						<input type="radio" name="vue_semaine" value="0" >
					</label>
					<label>
						<span>Semaine</span>
						<input type="radio" name="vue_semaine" value="1" checked="checked">
					</label>
				</div>
				<div class="center">
					<input class="btn btn-valid center" style="width: 100%;" id="submit_form" type="submit">
				</div>
			</div>
		</form>
	</div>
</div>