<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">

	<meta name="viewport" content="width=767, minimum-scale">

	<link href="https://fonts.googleapis.com/css?family=EB+Garamond:400,700" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?= ASSETS ?>css/style.css">

	<title><?= (isset($pageTitle))?htmlspecialchars($pageTitle):'Site CFDT INTERCO77' ?></title>
</head>
<body class="container-fluid">
	<header class="row">
	   	<a class="col-md-2" href="<?= HOST.'home.html' ?>"><img class="col-md-12 logo" src="<?= ASSETS.'/images/logo_cfdt.png' ?>" alt="logo cfdt" /></a>
	   	<div class="col-md-10">
	      	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	         	<h1 class="navbar-brand"><a href="<?= HOST.'home.html' ?>" id="mainTitle">CFDT INTERCO 77</a></h1>
	         	<div class="collapse navbar-collapse  justify-content-end" id="navbarCollapse">
	            	<ul class="navbar-nav uppercase">
	               		<?= $this->displayDashboardLink() ?>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'home.html' ?>">Accueil</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'allNews.html' ?>">Articles</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'allTestimonies.html' ?>">Témoignages</a></li>
	               		<li class="nav-item"> <a class="nav-link" href="<?= HOST.'contact.html' ?>">Nous contacter</a></li>
	               		<?= $this->displaySignLinks() ?>
	            	</ul>
	         	</div>
	       	</nav>               
	   	</div>
	</header>

	<?php if(isset($_SESSION['errors'])) :?>

		<div class="messages bgRed container center">
			<?php for($i = 0; $i < count($_SESSION['errors']); $i++) :?>
				<div><?= htmlspecialchars($_SESSION['errors'][$i]).'<br />' ?></div>
			<?php endfor ?>
		</div>
	<?php endif ?>

	<?php if(isset($_SESSION['message'])) :?>
		<div class="messages bgGreen container center"><?= htmlspecialchars($_SESSION['message']) ?></div>
	<?php endif ?>

	<?= $content ?>

	<footer class="container-fluid">
	   	<div class="row">
	      	<div class="col-md-4">
	         	<p>Derniers Camarades connectés dans les 24h (0)</p>
	         	<p>Nombre d'articles : </p>
	         	<p>Nombre de Camarades : </p>
	      	</div>
	      	<div class="col-md-4">
	         	<p>Adresse</p>
	      	</div>
	      	<div class="col-md-4">
	         	
	      	</div>
	   	</div>
	   	<div id="copyright" class="uppercase">Copyright © 2018 CFDT Interco77 - Design par Monocosmes</div>
	</footer>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="<?= ASSETS ?>js/tinymce/tinymce.min.js"></script>
  	<script>tinymce.init({ selector:'textarea' });</script>
  	<script src="<?= ASSETS ?>js/main.js"></script>
  	<script src="<?= ASSETS ?>js/popup.js"></script>
  	<script src="<?= ASSETS ?>js/editPost.js"></script>
  	<script src="<?= ASSETS ?>js/testimonyFilter.js"></script>

</body>
</html>