
<?php
	include 'conf/conf.php';
	if(isset($_GET['erreur'])){
		$erreur = sanitize($_GET['erreur']);
	}
	else{
		$erreur = NULL;
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ConnectMyBooking - Plateforme de réservation connectée</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Le premier planning qui permet à toutes applications de vous apporter des clients" />
	<meta name="keywords" content="planning applications foot en salle réservation" />

  <!-- 
  Facebook and Twitter integration
	<meta property="og:title" content=""/>
	<meta property="og:image" content=""/>
	<meta property="og:url" content=""/>
	<meta property="og:site_name" content=""/>
	<meta property="og:description" content=""/>
	<meta name="twitter:title" content="" />
	<meta name="twitter:image" content="" />
	<meta name="twitter:url" content="" />
	<meta name="twitter:card" content="" />
	-->
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link rel="shortcut icon" href="images/imageedit_3_3588628750.png">

	<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	
	<!-- Animate.css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- Icomoon Icon Fonts-->
	<link rel="stylesheet" href="css/icomoon.css">
	<!-- Simple Line Icons -->
	<link rel="stylesheet" href="css/simple-line-icons.css">
	<!-- Owl Carousel -->
	<link rel="stylesheet" href="css/owl.carousel.min.css">
	<link rel="stylesheet" href="css/owl.theme.default.min.css">
	<!-- Bootstrap  -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<!-- Modernizr JS -->
	<script src="js/modernizr-2.6.2.min.js"></script>
	<!-- FOR IE9 below -->
	<!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

	</head>
	<body>
	<header role="banner" id="fh5co-header" class="navbar-fixed-top fh5co-animated slideInDown">
			<div class="container-fluid">
				<!-- <div class="row"> -->
			    <nav class="navbar navbar-default">
			        <div class="navbar-header">
			        	<!-- Mobile Toggle Menu Button -->

						<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"><i></i></a>
			          	<a class="navbar-brand" href="index.html"><img id="logo" src="images/imageedit_3_3588628750.png" alt="CmB" style="height: 50px;">  ConnectMyBooking.com</a>
			        </div>
			        <div id="navbar" class="navbar-collapse collapse">
			          <ul class="nav navbar-nav navbar-right">
			            <li class="active"><a href="#" data-nav-section="home"><span>Accueil</span></a></li>
			            <li><a href="#" data-nav-section="about"><span>Notre mission / Notre équipe</span></a></li>
			            <!-- <li><a href="#" data-nav-section="services"><span>Nos Services</span></a></li>
			            <li><a href="#" data-nav-section="features"><span>Partenaires</span></a></li>
			            <li><a href="#" data-nav-section="testimonials"><span>Avis</span></a></li> -->
			            <li><a href="#" data-nav-section="features"><span>Fonctionnalités produit</span></a></li>
			            <!-- <li><a href="#" data-nav-section="press"><span>Newsletter</span></a></li> -->
			            <li><a id="" href="api/index.php"><span>API / Documentation</span></a></li>
			            <li><a id="a-co" href="#" data-toggle="modal" data-target="#modal-co"><span id="span-co" >Connexion</span></a></li>
			          </ul>
			        </div>
			    </nav>
			  <!-- </div> -->
		  </div>
	</header>
	<div id="slider" data-section="home" style="background: #2BA14B; height: 1000px; padding-top: 150px;">
		<div class="ligne" style="height: 500px;">
			<div id="slogan" class="center liste espacer1" style="flex: 1;">
				<h1 class=""><p id="p_slogan" class="center">Un planning <span class="rayer">connecté</span> collectif</p></h1>
			</div>
			<div id="img_home" class="center" style="flex: 1;">
				<img class="img img-responsive center" src="images/imac2013_right.png" alt="image" style="width: 80%;">				
			</div>
		</div>
	</div>
	
	<div id="fh5co-about-us" data-section="about">
		<div class="container">
			<div class="row row-bottom-padded-lg" id="about-us">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Notre Mission</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 to-animate">
							<h3>Un planning universel qui vous connecte à toutes les opportunités</h3>
						</div>
					</div>
				</div>
				<div class="col-md-8 to-animate">
					<img src="images/image_foot1.jpg" class="img-responsive img-rounded" alt="Free HTML5 Template">
				</div>
				<div class="col-md-4 to-animate">
					<h2>Notre histoire</h2>
					<p>
	<?php var_dump($_SESSION); ?>
						Connect My Booking, c'est l'histoire d'une startup qui voulait proposer une solutions à destination des joueurs de foot en salle, afin de leur faciliter la vie (et surtout l'organisation des matchs). Or nous avons rapidement compris que si nous voulions proposer une solution efficace, il nous faudrait l'accès au planning de réservation des complexes. En France, ce sont plus de 200 complexes donc il à fallu se faire une raison: le challenge est quasi impossible. De là est né Connect My Booking.
						Un planning universel sur lequel les applications peuvent se "brancher" afin de travailler de manière synchroniser avec les complexes.

					</p>
					<!-- <p><a href="#" class="btn btn-primary">Meet the team</a></p> -->
				</div>
			</div>
			<div class="row" id="team">
				<div class="col-md-12 section-heading text-center to-animate">
					<h2>Notre Equipe</h2>
				</div>
				<div class="col-md-12">
					<div class="row row-bottom-padded-lg">
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="images/person2.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">Huctin Damien</h3>
								<div class="position">Président, Développeur Web</div>
								<p>"Ajoutez quelquefois, et souvent effacez"</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-github"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="images/person3.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">Menard Anthony</h3>
								<div class="position">Directeur Général</div>
								<p>"Ce qui se conçoit bien s'énonce clairement, et les mots pour le dire arrivent aisément"</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-dribbble"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="col-md-4 text-center to-animate">
							<div class="person">
								<img src="images/person4.jpg" class="img-responsive img-rounded" alt="Person">
								<h3 class="name">Sicaire Loïc</h3>
								<div class="position">Developpeur Web / Mobile</div>
								<p>"Avant donc que d'écrire, apprenez à penser."</p>
								<ul class="social social-circle">
									<li><a href="#"><i class="icon-twitter"></i></a></li>
									<li><a href="#"><i class="icon-linkedin"></i></a></li>
									<li><a href="#"><i class="icon-instagram"></i></a></li>
									<li><a href="#"><i class="icon-github"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--
	<div id="fh5co-our-services" data-section="services">
		<div class="container">
			<div class="row row-bottom-padded-sm">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Nos Services</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 to-animate">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-1"><span><i class="icon-mustache"></i></span></div>
						<h3>100% free</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-4"><span><i class="icon-heart"></i></span></div>
						<h3>Made with love</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-2"><span><i class="icon-screen-desktop"></i></span></div>
						<h3>Fully responsive</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-5"><span><i class="icon-rocket"></i></span></div>
						<h3>Fast &amp; light</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
					</div>
				</div>
				<div class="col-md-4">
					<div class="box to-animate">
						<div class="icon colored-3"><span><i class="icon-eye"></i></span></div>
						<h3>Retina-ready</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
					</div>
					<div class="box to-animate">
						<div class="icon colored-6"><span><i class="icon-user"></i></span></div>
						<h3>For creative like you!</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	-->
	
	<div id="fh5co-features" data-section="features">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-features-1">Fonctionnalités</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 single-animate animate-features-2">
							<!-- <h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3> -->
						</div>
					</div>
				</div>
			</div>
			<div class="row row-bottom-padded-sm">
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-present"></i></div>
					<div class="fh5co-desc">
						<h3>Un outil de réservation 100% gratuit</h3>
						<p>
							Un planning pour gérer vos résevations
							<br/>
							Option "réservation en ligne" à mettre sur votre site web
							<br/>
							Pas d'options payantes
							<br/>
							Une configuration en 3 étapes de 45sec (horaires, tarrains, tarifs) et votre planning est opérationnel.
						</p>
					</div>	
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-speedometer"></i></div>
					<div class="fh5co-desc">
						<h3>Chiffre d'Affaires +++</h3>
						<p>
							Vous avez des terrains qui ne sont pas réservés?
							<br/>
							Nous avons le plus grand réseau d'application connecté à notre solution. 
							<br/>
							Sélectionnez le terrain, l'heure et la commission que vous proposez (2min) Et c'est fini l'offre est diffusée!
							<br/>
							Il ne vous reste qu'à attendre qu'un apporteur d'affaires vous trouve 10 joueurs, la réservation se fera automatiquement.
						</p>
					</div>
				</div>
				<div class="clearfix visible-sm-block visible-xs-block"></div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-crop"></i></div>
					<div class="fh5co-desc">
						<h3>100% Libre</h3>
						<p>
							Pas de contrat d'exclusivité
							<br/>
							Aucune contrainte
							<br/>
							Pas de durée d'engagement.
							<br/>
							C'est incroyable mais à l'image un compte Google, Facebook ou autre... Le compte Connect My Booking est tout aussi libre, gratuit et accessible. Alors Jetez-y un coup d'oeil. 
						</p>
					</div>
				</div>
				<!--
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-speedometer"></i></div>
					<div class="fh5co-desc">
						<h3>Lightweight</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
					</div>	
				</div>
				<div class="clearfix visible-sm-block visible-xs-block"></div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-heart"></i></div>
					<div class="fh5co-desc">
						<h3>Made with Love</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 fh5co-service to-animate">
					<div class="fh5co-icon"><i class="icon-umbrella"></i></div>
					<div class="fh5co-desc">
						<h3>Eco Friendly</h3>
						<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. </p>
					</div>
				</div>
				-->

				<div class="clearfix visible-sm-block visible-xs-block"></div>
			</div>
			<!-- 
			<div class="row">
				<div class="col-md-4 col-md-offset-4 single-animate animate-features-3">
					<a href="#" class="btn btn-primary btn-block">Learn More</a>
				</div>
			</div>
			-->
		</div>
	</div>

	<!-- <div id="fh5co-testimonials" data-section="testimonials">		
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="to-animate">Qu'en pensent les joueurs... ?</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext to-animate">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, CEO <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
				</div>
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, CEO <a href="http://freehtml5.co/" target="_blank">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
					
				</div>
				<div class="col-md-4">
					<div class="box-testimony to-animate">
						<blockquote>
							<span class="quote"><span><i class="icon-quote-left"></i></span></span>
							<p>&ldquo;Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.&rdquo;</p>
						</blockquote>
						<p class="author">John Doe, Founder <a href="#">FREEHTML5.co</a> <span class="subtext">Creative Director</span></p>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	-->

	<!--
	<div id="fh5co-pricing" data-section="pricing">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-pricing-1">Quelques chiffres sur le Foot en Salle</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext single-animate animate-pricing-2">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Starter</h2>
						<div class="price"><sup class="currency">$</sup>7<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>10 projects</li>
							<li>20 Pages</li>
							<li>20 Emails</li>
							<li>100 Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Regular</h2>
						<div class="price"><sup class="currency">$</sup>19<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>15 projects</li>
							<li>40 Pages</li>
							<li>40 Emails</li>
							<li>200 Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				<div class="clearfix visible-sm-block"></div>
				<div class="col-md-3 col-sm-6 to-animate">
					<div class="price-box popular">
						<div class="popular-text">Best value</div>
						<h2 class="pricing-plan">Plus</h2>
						<div class="price"><sup class="currency">$</sup>79<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>Unlimitted projects</li>
							<li>100 Pages</li>
							<li>100 Emails</li>
							<li>700 Images</li>
						</ul>
						<a href="#" class="btn btn-primary btn-sm">Get started</a>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="price-box to-animate">
						<h2 class="pricing-plan">Enterprise</h2>
						<div class="price"><sup class="currency">$</sup>125<small>/mo</small></div>
						<p>Basic customer support for small business</p>
						<hr>
						<ul class="pricing-info">
							<li>Unlimitted projects</li>
							<li>Unlimitted Pages</li>
							<li>Unlimitted Emails</li>
							<li>Unlimitted Images</li>
						</ul>
						<a href="#" class="btn btn-default btn-sm">Get started</a>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	-->

	<!--
	<div id="fh5co-press" data-section="press">
		<div class="container">
			<div class="row">
				<div class="col-md-12 section-heading text-center">
					<h2 class="single-animate animate-press-1">La Newsletter</h2>
					<div class="row">
						<div class="col-md-8 col-md-offset-2 subtext single-animate animate-press-2">
							<h3>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</h3>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					-->
					<!-- Press Item -->
					<!--
					<div class="fh5co-press-item to-animate">
						<div class="fh5co-press-img" style="background-image: url(images/img_7.jpg)">
						</div>
						<div class="fh5co-press-text">
							<h3 class="h2 fh5co-press-title">Simplicity <span class="fh5co-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>
					-->
					<!-- Press Item -->
					<!--
				</div>

				<div class="col-md-6">
					-->
					<!-- Press Item -->
					<!--
					<div class="fh5co-press-item to-animate">
						<div class="fh5co-press-img" style="background-image: url(images/img_8.jpg)">
						</div>
						<div class="fh5co-press-text">
							<h3 class="h2 fh5co-press-title">Versatile <span class="fh5co-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
					<!--
				</div>
				
				<div class="col-md-6">
					-->
					<!-- Press Item -->
					<!--
					<div class="fh5co-press-item to-animate">
						<div class="fh5co-press-img" style="background-image: url(images/img_9.jpg);">
						</div>
						<div class="fh5co-press-text">
							<h3 class="h2 fh5co-press-title">Aesthetic <span class="fh5co-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>-->
					<!-- Press Item -->
					<!--
				</div>

				<div class="col-md-6">
					-->
					<!-- Press Item -->
					<!--
					<div class="fh5co-press-item to-animate">
						<div class="fh5co-press-img" style="background-image: url(images/img_10.jpg);">
						</div>
						<div class="fh5co-press-text">
							<h3 class="h2 fh5co-press-title">Creative <span class="fh5co-border"></span></h3>
							<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Veritatis eius quos similique suscipit dolorem cumque vitae qui molestias illo accusantium...</p>
							<p><a href="#" class="btn btn-primary btn-sm">Learn more</a></p>
						</div>
					</div>
					-->
					<!-- Press Item -->
					<!--
				</div>

			</div>
		</div>
	</div>
	-->
	

	<footer id="footer" role="contentinfo">
		<div class="container">
			<div class="row row-bottom-padded-sm">
				<div class="col-md-12">
					<p class="copyright text-center">
						&copy; ConnectMyBooking.com - 2017
					</p>
				</div>
			</div>
			<!--
			<div class="row">
				<div class="col-md-12 text-center">
					<ul class="social social-circle">
						<li><a href="#"><i class="icon-twitter"></i></a></li>
						<li><a href="#"><i class="icon-facebook"></i></a></li>
						<li><a href="#"><i class="icon-youtube"></i></a></Fconli>
						<li><a href="#"><i class="icon-pinterest"></i></a></li>
						<li><a href="#"><i class="icon-linkedin"></i></a></li>
						<li><a href="#"><i class="icon-instagram"></i></a></li>
						<li><a href="#"><i class="icon-dribbble"></i></a></li>
					</ul>
				</div>
			</div>
			-->
		</div>
	</footer>
	
	

		<div class="modal fade" id="modal-co" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h1 class="center">Connexion</h1>
					</div>

					<div class="modal-body">
						<?php
							if ($erreur == 'idmdp'){
								?>
									<p class="center">Erreur identifiant/mot de passe</p>
								<?php
							}
							elseif($erreur == 'vide'){
								?>
									<p class="center">erreur champ vide</p>
								<?php
							}
						?>
						<form id="form_co" class="center" method="post" action="connexion_traitement.php">
							<label class="center  ligne2">
								<span class="center span_mod-co">Identifiant:</span>
								<input class="input1 " type="text" name="identifiant" placeholder="Complexe_121"/>
							</label>
							<br/>
							<label class="center ligne2">
								<span class="center span_mod-co">Mot de passe:</span>
								<input class="input1 " type="password" name="mdp" placeholder="******">
							</label>
							<br/>
							<input type="submit" class="btn btn-success center  btn-valid" value="Valider"/>
						</form>
					</div>

					<div class="modal-footer">
						<p class="center">Pas encore de compte? contactez-nous </p>
						<p class="center">contact@connectmybooking.com</p>
					</div> 
				</div>
			</div>
		</div>
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Owl Carousel -->
	<script src="js/owl.carousel.min.js"></script>

	<!-- For demo purposes only styleswitcher ( You may delete this anytime ) -->
	<script src="js/jquery.style.switcher.js"></script>
	<script>
	$(function(){
		$('#colour-variations ul').styleSwitcher({
			defaultThemeId: 'theme-switch',
			hasPreview: false,
			cookie: {
	          	expires: 30,
	          	isManagingLoad: true
	      	}
		});	
		$('.option-toggle').click(function() {
			$('#colour-variations').toggleClass('sleep');
		});
	});
	</script>
	<!-- End demo purposes only -->

	<!-- Main JS (Do not remove) -->
	<script src="js/main.js"></script>
	<?php 
		if(isset($erreur) AND $erreur != NULL){
			?>
				<script>
					$( document ).ready(function() { 
						$( "#a-co" ).get(0).click();
					});
				</script>
			<?php
		}
	?>

	</body>
</html>
