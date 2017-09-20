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
<nav class="navbar navbar-default" >
    <div class="container-fluid ligne espacer2" >
            <ul class="nav navbar-nav">
            	<li>
            		<a class="navbar-brand" href="#">ConnectMyBooking</a>
            	</li>
            </ul>
            <ul class="nav navbar-nav center ligne espacer1" style="flex: 1;"">
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
            <ul class="nav navbar-nav">
                <li>
                	<a href="deconnexion"><span class="glyphicon glyphicon-off"><span> Deconnexion</span></a>
                </li>
            </ul>

                <!--<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                        <li class="divider"></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>-->
    </div>
</nav>