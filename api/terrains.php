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
    <title>Terrains - <?php echo $nomSite; ?> - Documentation</title>
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
                    <li><a href="complexes">Complexes</a></li>
                    <li><a href="coordonnees">Coordonnees</a></li>
                    <li><a href="plages-horaires">PlagesHoraires</a></li>
                    <li><a href="plages-horaires-statut">PlagesHorairesStatuts</a></li>
                    <li><a href="planning-tarifs">PlanningTarifs</a></li>
                    <li><a href="planning-comissions">PlanningComissions</a></li>
                    <li><a href="reservations">Reservations</a></li>
                    <li class="active">
                        <a href="terrains.php">Terrains <span class="caret"></span></a>
                        <ul class="sous-menu">
                            <li id="structure-item" class="sous-menu-item sous-menu-item-active"><a href="#structure">Structure de l'objet</a></li>
                            <li id="recup-item" class="sous-menu-item"><a href="#recup-liste">Récupérer la liste des terrains d'un complexe</a></li>
                            <li id="recup-one-item" class="sous-menu-item"><a href="#recup-one">Récupérer un terrain</a></li>
                        </ul>
                    </li>
                    <li><a href="terrains-type">TerrainTypes</a></li>
                </ul>
            </div>

            <!-- Contenu de la page -->
            <div class="col-lg-9 cont-tool">


                <div id="contenu-doc">
                    <section id="structure">
                    <h3 class="titre-section">Structure d'un objet Terrain</h3>
                        Un objet Terrain correspond à un des terrains d'un complexe donné.<br />
                        Voici comment est constitué un terrain :
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
                                    <td>Identifiant du terrain</td>
                                </tr>
                                <tr class="active">
                                    <td>Nom</td>
                                    <td>String</td>
                                    <td>Nom complet du terrain</td>
                                </tr>
                                <tr class="active">
                                    <td>Type</td>
                                    <td><a href="#">TerrainType</a></td>
                                    <td>Le type du terrain (5x5, 4x4, Interieur, Exterieur..)</td>
                                </tr>
                                <tr class="active">
                                    <td>Complexe</td>
                                    <td>
                                        <a data-descr="Objet Complexe: cliquez pour voir les propriétés de l'objet"
                                           href="complexes" target="_blank">Complexe</a>
                                    </td>
                                    <td>Le complexe dans lequel se situe le terrain</td>
                                </tr>
                                <tr class="active">
                                    <td>ListeHoraires</td>
                                    <td><a href="#">PlageHoraires[]</a></td>
                                    <td>Liste des plages horaires d'un terrain</td>
                                </tr>
                                <tr class="active">
                                    <td>ListeTarifs</td>
                                    <td><a href="#">PlanningTarifs[]</a></td>
                                    <td>Liste des prix par tranches horaires d'un terrain</td>
                                </tr>
                                <tr class="active">
                                    <td>ListeComissions</td>
                                    <td><a href="#">PlanningComission[]</a></td>
                                    <td>Liste des comissions que vous touchez par tranches horaires d'un terrain</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>

                    <section id="recup-liste">
                        <h3 class="titre-section">Récupèrer la liste des terrains d'un complexe</h3>
                        <div class="requete-description">
                            Pour récupérer la liste de tous les terrains d'un complexe donné,
                            vous devez envoyer une requete HTTP de type GET sur l'url %api_url%/complexes/{id}/terrains, ou {id} représente l'identifiant du complexe
                            dont on souhaite récupérer les terrains. Le format de données renvoyée est le JSON.
                        </div>
                        <div class="col-md-2 method">
                            <h4 class="methode-http methode-get">GET</h4>
                        </div>
                        <div class="col-md-10 method">
                            <h4 class="url">... /complexes/{id}/terrains</h4>
                        </div>
                        <div class="example">Voici un exemple de réponse renvoyée par cette url :</div>
                        <div class="code">
                        [
                            {
                                "id": 1,
                                "nom": "Terrain Intérieur 1",
                                "type": {
                                    "id": 1,
                                    "typeNom": "5c5 Intérieur"
                                },
                                "complexe": {
                                    "id": 1,
                                    "nom": "Offside",
                                    "coordonnees": {
                                        "id": 2,
                                        "adresseLigne1": "14 rue de la Canave",
                                        ...
                                    }
                                },
                                "listeHoraires": [
                                    {
                                        "id": 1,
                                        "heureDebut": "2017-08-23T11:00:00+00:00",
                                        ...
                                    }
                                    ...
                                ],
                                "listeTarifs": [
                                    {
                                        "id": 1,
                                        "montant": 60,
                                        ...
                                    }
                                    ...
                                ],
                                "listeComissions": [
                                    {
                                        "id": 1,
                                        "montant": 10,
                                        ...
                                    }
                                    ...
                                ]
                            }
                        ]
                        </div>
                    </section>

                    <section id="recup-one">
                        <h3 class="titre-section">Récupèrer un terrain</h3>

                        <div class="requete-description">
                            Pour récupérer un terrain, il vous faut connaitre son identifiant (récupérable lorsque vous cherchez un complexe).
                            Avec cet id, vous pouvez interroger l'URI %api_url%/terrains/{id} - où {id} représente l'identifiant du terrain.
                        </div>

                        <div class="col-md-2 method">
                            <h4 class="methode-http methode-get">GET</h4>
                        </div>
                        <div class="col-md-10 method">
                            <h4 class="url">... /terrains/{id}</h4>
                        </div>

                        <div class="example">Voici un exemple de réponse renvoyée par cette url :</div>
                        <div class="code">
                        {
                            "id": 1,
                            "nom": "Terrain Intérieur 1",
                            "type": {
                                "id": 1,
                                "typeNom": "5c5 Intérieur"
                            },
                            "complexe": {
                                "id": 1,
                                "nom": "Offside",
                                "coordonnees": {
                                    "id": 2,
                                    "adresseLigne1": "14 rue de la Canave",
                                    ...
                                }
                            },
                            "listeHoraires": [
                                {
                                    "id": 1,
                                    "heureDebut": "2017-08-23T11:00:00+00:00",
                                    ...
                                }
                                ...
                            ],
                            "listeTarifs": [
                                {
                                    "id": 1,
                                    "montant": 60,
                                    ...
                                }
                                ...
                            ],
                            "listeComissions": [
                                {
                                    "id": 1,
                                    "montant": 10,
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
