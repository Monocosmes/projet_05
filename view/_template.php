<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=767, minimum-scale">

	<link href="https://fonts.googleapis.com/css?family=EB+Garamond:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>css/bootstrap/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>css/style.css">

	<title><?= (isset($pageTitle))?htmlspecialchars($pageTitle):'Site CFDT INTERCO77' ?></title>
</head>
<body>
	<header class="row">
	   	<a class="col-lg-2 col-sm-6 center" href="<?= HOST.'home.html' ?>"><img class="col-12 logo" src="<?= ASSETS.'/images/logo_cfdt.png' ?>" alt="logo cfdt" /></a>
	   	<div class="col-lg-10 col-sm-12">
	      	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	      		<h1 class="navbar-brand"><a href="<?= HOST.'home.html' ?>" id="mainTitle">CFDT INTERCO77</a></h1>
	      		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    				<span class="navbar-toggler-icon"></span>
  				</button>

	         	<div class="collapse navbar-collapse" id="navbarSupportedContent">
	         		<ul class="navbar-nav uppercase <?= ($_SESSION['isLogged'] === session_id()) ? 'col-md-10 offset-md-2 justify-content-between' : 'col-md-12 justify-content-end' ?>">
	            		<?= $this->displayDashboardLink() ?>
	            		<?= $this->displaySignLinks($templateData) ?>
	            	</ul>	            		            	
	         	</div>
	       	</nav>

	       	<nav class="navbar navbar-expand navbar-dark bg-dark">	         	
	         	<div class="collapse navbar-collapse">	         		
	            	<ul class="navbar-nav uppercase col-sm-12 justify-content-between">	               		
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'home.html' ?>">Accueil</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'allNews.html' ?>">Les Articles</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'allTestimonies.html' ?>">Les Témoignages</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'contact.html' ?>">Nous contacter</a></li>
	            	</ul>	            	
	         	</div>
	       	</nav>
	   	</div>
	   	<div class="col-12 borders">			
			<form class="navbar-form" method="get" action="<?= HOST.'search' ?>">
				<div class="input-group add-on">
					<input class="form-control" type="text" name="search" placeholder="RECHERCHER" value="<?= $result = (isset($_GET['search']) AND !empty($_GET['search']))?htmlspecialchars($_GET['search']):''; ?>" >
					<div class="input-group-btn searchButton">
						<button class="button" type="submit" value="OK" ><span class="glyphicon glyphicon-search">Ok</span></button>
					</div>
				</div>
			</form>
		</div>
	</header>
	
	<div <?= $wrapper ?>>
		<?php if(isset($_SESSION['errors'])) :?>
	
			<div class="messages bgRed">
				<?php for($i = 0; $i < count($_SESSION['errors']); $i++) :?>
					<div><?= htmlspecialchars($_SESSION['errors'][$i]).'<br />' ?></div>
				<?php endfor ?>
			</div>
		<?php endif ?>
	
		<?php if(isset($_SESSION['message'])) :?>
			<div class="messages bgGreen"><?= htmlspecialchars($_SESSION['message']) ?></div>
		<?php endif ?>
	</div>

	<?= $content ?>

	<footer>
	   	<div class="d-flex mb-3 pt-3">
	      	<div class="col-md-4 paddingRule">
	         	<p>Derniers Camarades connectés dans les 24h&nbsp;:&nbsp;<span><?= $templateData->last24hConnected() ?></span></p>
	         	<p>Dernier membre inscrit&nbsp;:&nbsp;<a href="<?= HOST.'profile/userId/'.$templateData->lastSignupMember()->id() ?>"><?= $templateData->lastSignupMember()->login() ?></a></p>
	         	<p><a href="<?= HOST.'roles.html' ?>">Rôles : Droits et obligations</a></p>
	      	</div>
	      	<div id="mail" class="col-md-4 paddingRule">
	         	<p>Adresse : </p>
	         	<p>
	         		Bureau syndical CFDT
	         		<br>
	         		6 Place du Souvenir
	         		<br>
	         		77550 Moissy-Crayamel
	         	</p>
	      	</div>
	      	<div class="col-md-4 paddingRule">
	      		<p>Nombre d'articles&nbsp;:&nbsp;<a href="<?= HOST.'allNews.html' ?>"><?=$templateData->newsNumber() ?></a></p>
	         	<p>Nombre de témoignage&nbsp;:&nbsp;<a href="<?= HOST.'allTestimonies.html' ?>"><?=$templateData->testimonyNumber() ?></a></p>
	         	<p>Nombre de Camarades&nbsp;:&nbsp;<?=$templateData->userNumber() ?></p>	         	
	      	</div>
	   	</div>
	   	<div id="copyright" class="uppercase">Copyright © 2018 CFDT Interco77 - Design par <a href="https://www.linkedin.com/in/pascal-galiacy-98b50316a/">Monocosmes</a></div>
	</footer>

	<a id="backToTop" href="#" title="retour haut de page.">↑</a>

	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="<?= ASSETS ?>js/tinymce/tinymce.min.js"></script>
  	<script src="<?= ASSETS ?>js/bootstrap/bootstrap.min.js"></script>
  	<script src="<?= ASSETS ?>js/main.js"></script>
  	<script src="<?= ASSETS ?>js/avatarUpload.js"></script>
  	<script src="<?= ASSETS ?>js/tinymceLoad.js"></script>
  	<script src="<?= ASSETS ?>js/autoComplete.js"></script>
  	<script src="<?= ASSETS ?>js/backToTop.js"></script>
  	<script src="<?= ASSETS ?>js/popup.js"></script>
  	<script src="<?= ASSETS ?>js/editPost.js"></script>
  	<script src="<?= ASSETS ?>js/testimonyFilter.js"></script>
  	<script src="<?= ASSETS ?>js/signupForm.js"></script>
  	<script src="<?= ASSETS ?>js/profileSettings.js"></script>

</body>
</html>