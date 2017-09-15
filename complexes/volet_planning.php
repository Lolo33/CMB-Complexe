<div id="volet2">
	<div class="has-feedback">
		<form action="planning.php" method="post">
			<input type="hidden" id="input_jour" name="jour" value="">
			<div class="div_input2"> 
				<div class="ligne">
					<span id="datepicker" value="<?php if (isset($_POST['jour'])) { echo $_POST['jour']; } ?>"></span>
				</div>
				<div class="center">
					<span>Vue: </span>
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
					<input class="btn btn-success btn2 center" id="submit_form" type="submit">
				</div>
			</div>
		</form>
	</div>
</div>