<?php
/**
 * Created by PhpStorm.
 * User: Niquelesstup
 * Date: 16/08/2017
 * Time: 15:10
 */
include "includes/init.php";
?>

<html>

<head>
    <?php include 'includes/head.php'; ?>
    <title>Complexes - <?php echo $nomSite; ?> - Documentation</title>
</head>


<body>

    <?php include 'includes/navbar.php'; ?>

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-3 nav-tool">
                <h2 class="titre-menu">Navigation</h2>
                <?php include 'includes/head_navigation.php'; ?>
                <h4 class="nav-titre">Documentation</h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="active">
                        <a href="#">Complexes <span class="caret"></span></a>
                        <ul class="sous-menu">
                            <li id="structure-item" class="sous-menu-item sous-menu-item-active"><a href="#structure">Structure de l'objet</a></li>
                            <li id="recup-item" class="sous-menu-item"><a href="#recup-liste">Récupérer la liste des complexes</a></li>
                            <li id="recup-one-item" class="sous-menu-item"><a href="#recup-one">Récupérer un complexe</a></li>
                        </ul>
                    </li>
                    <li><a href="coordonnees">Coordonnees</a></li>
                    <li><a href="plages-horaires">PlagesHoraires</a></li>
                    <li><a href="plages-horaires-statut">PlagesHorairesStatuts</a></li>
                    <li><a href="planning-tarifs">PlanningTarifs</a></li>
                    <li><a href="planning-comissions">PlanningComissions</a></li>
                    <li><a href="reservations">Reservations</a></li>
                    <li><a href="terrains">Terrains</a></li>
                    <li><a href="terrains-type">TerrainTypes</a></li>
                </ul>
            </div>

            <!-- Contenu de la page -->
            <div class="col-lg-9 cont-tool">
                <div id="contenu-doc">


                    <section id="structure">
                    <h3 class="titre-section">Structure d'un objet Complexe</h3>
                        Un objet complexe correspond à un des 200+ complexes sportifs proposant du soccer/futsal en France.<br />
                        Voici comment est constitué un complexe :
                        <br /><br>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Nom de la propriété</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="active">
                                    <td>Id</td>
                                    <td>Integer</td>
                                    <td>Identifiant du complexe</td>
                                </tr>
                                <tr class="active">
                                    <td>Nom</td>
                                    <td>String</td>
                                    <td>Nom complet du complexe</td>
                                </tr>
                                <tr class="active">
                                    <td>Coordonnees</td>
                                    <td>
                                        <a data-descr="Objet coordonnées: cliquez pour voir les propriétés de l'objet"
                                           href="coordonnees" target="_blank">Coordonnee</a>
                                    </td>
                                    <td>Coordonnées pour joindre le complexe</td>
                                </tr>
                                <tr class="active">
                                    <td>ListeTerrains</td>
                                    <td>
                                        <a data-descr="Liste d'objets Terrains (ArrayCollection):
                                    cliquez pour voir les propriétés de l'objet" href="terrains" target="_blank">Terrains[]</a>
                                    </td>
                                    <td>Liste des terrains que comporte le complexe</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>


                    <section id="recup-liste">
                        <h3 class="titre-section">Récupèrer la liste des complexes</h3>

                        <div class="requete-description">
                            Pour récupérer la liste de tous les complexes partenaires, et leurs terrains, horaires, tarifs, comissions...
                            il suffit d'envoyer une requete HTTP de type GET sur l'url %api_url%/complexes. Le format de données renvoyée est le JSON.
                        </div>

                        <div class="col-md-2 method">
                            <h4 class="methode-http methode-get">GET</h4>
                        </div>
                        <div class="col-md-10 method">
                            <h4 class="url">... /complexes</h4>
                        </div>

                        <div class="example">Voici un exemple de réponse renvoyée par cette url :</div>
                        <div class="code">
                        [
                            {
                                "id": 1,
                                "nom": "Offside",
                                "coordonnees": {
                                    "id": 2,
                                    "adresseLigne1": "14 rue de la Canave",
                                    "adresseLigne2": null,
                                    "ville": "Martillac",
                                    "codePostal": "33640"
                                    "mail": "contact@offside33.fr",
                                    "telephone": "0556728992"
                                },
                                "listeTerrains": [
                                    {
                                        "id": 1,
                                        "nom": "Terrain Intérieur 1",
                                        ...
                                    }
                                    ...
                                ]
                            },
                            {
                                "id": 2,
                                "nom": "Foot Factory",
                                ...
                            },
                            ...
                        ]
                        </div>
                    </section>



                    <section id="recup-one">
                        <h3 class="titre-section">Récupèrer un complexe</h3>

                        <div class="requete-description">
                            Pour récupérer un complexe partenaire, et ses terrains, horaires, tarifs, comissions...
                            il suffit d'envoyer une requete HTTP de type GET sur l'url %api_url%/complexes/{id} ou {id} est l'identifiant du complexe que vous souhaitez récuperer.
                            Le format de données renvoyée est le JSON.
                        </div>

                        <div class="col-md-2 method">
                            <h4 class="methode-http methode-get">GET</h4>
                        </div>
                        <div class="col-md-10 method">
                            <h4 class="url">... /complexes/{id}</h4>
                        </div>

                        <div class="example">Voici un exemple de réponse renvoyée par cette url :</div>
                        <div class="code">
                        {
                            "id": 1,
                            "nom": "Offside",
                            "coordonnees": {
                                "id": 2,
                                "adresseLigne1": "14 rue de la Canave",
                                "adresseLigne2": null,
                                "ville": "Martillac",
                                "codePostal": "33640"
                                "mail": "contact@offside33.fr",
                                "telephone": "0556728992"
                            },
                            "listeTerrains": [
                                {
                                    "id": 1,
                                    "nom": "Terrain Intérieur 1",
                                    ...
                                }
                                ...
                            ]
                        }
                        </div>
                    </section>

                </div>


            </div>

        </div>
    </div>

    <script src="js/script.js"></script>

</body>
</html>
