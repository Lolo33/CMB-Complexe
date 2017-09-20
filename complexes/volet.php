<!-- <div id="volet" class="ligne">
	<div id="volet_menu" class="ligne">
		<div>
			<a href="planning.php">
				<p>
					<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
					<span>Accueil</span>
				</p>
			</a>
		</div>
		<div>
			<a href="planning_tarifs.php">
				<p>
					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
					<span>Gérer les tarifs</span>
				</p>
			</a>
		</div>
		<div>
			<a href="planning_commissions.php">
				<p>
					<span class="glyphicon glyphicon-euro" aria-hidden="true"></span>
					<span>Gérer les apporteurs d'affaires</span>
				</p>
			</a>
		</div>
		<div>
			<a href="parametres.php">
				<p>
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<span>Paramètres</span>
				</p>
			</a>
		</div>
		<div id="">
			<a href="../deconnexion.php">
				<p>
					<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
					<span>Déconnexion</span>
				</p>
			</a>
		</div>
	</div>
</div>
-->

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">ConnectMyBooking</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li <?php activeMenuIfContain("/planning_accueil"); ?>>
                        <a href="planning_accueil.php"><span class="glyphicon glyphicon-home"></span> Accueil</a>
                    </li>
                    <li <?php activeMenuIfContain("/planning."); ?>>
                        <a href="planning.php"><span class="glyphicon glyphicon-calendar"></span> Planning</a>
                    </li>
                    <li <?php activeMenuIfContain("/planning_horaires"); ?>>
                        <a href="planning_horaires.php"><span class="glyphicon glyphicon-time"></span> Gérez vos horaires</a>
                    </li>
                    <li <?php activeMenuIfContain("/planning_tarifs"); ?>>
                        <a href="planning_tarifs.php"><span class="glyphicon glyphicon-eur"></span> Gérez vos tarifs</a>
                    </li>
                    <li <?php activeMenuIfContain("/planning_commissions"); ?>>
                        <a href="planning_commissions.php"><span class="glyphicon glyphicon-briefcase"></span> Gérez vos apporteurs d'affaires</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="deconnexion">Deconnexion</a></li>
                </ul>
            </div>
        </div>
    </nav>
