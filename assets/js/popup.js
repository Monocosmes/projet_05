class Popup
{
	constructor()
	{
		this.addEvents();
		this.host = 'http://localhost/projet_05/';
		this.documentHeight = $('html').height();
	}

	addEvents()
	{
		$('#deleteAccount').click((e) => {this.deleteAccount(e)});
		$('#loginPopup').click((e) => {this.signInAccount(e)});
		$('.deleteNews').click((e) => {this.deleteNews(e)});
		$('.deleteTestimony').click((e) => {this.deleteTestimony(e)});
		$('.deletePost').click((e) => {this.deletePost(e)});
		$('#service').click((e) => {this.displayTermOfService(e)});
	}

	closeWindow()
	{
		$('#popupContainer').remove();
	}

	deleteAccount(e)
	{
		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Supprimer mon compte</h2><p>En effaçant votre compte, vous renoncez à votre droit de modifier ou effacer les messages que vous avez publié sur ce site<br />Souhaitez-vous continuer ?</p><div class="displayFlex center"><a class="button" href="'+this.host+'deleteAccount/userId/'+e.target.value+'">Confirmer</a><button class="button" id="cancelDelete">Annuler</button></div></div></div></div>');
		$('#cancelDelete').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}

	deleteNews(e)
	{
		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Supprimer un article</h2><p>Vous êtes sur le point d\'effacer cet article définitivement<br />Souhaitez-vous continuer ?</p><div class="displayFlex center"><a class="button" href="'+this.host+'deleteNews/newsId/'+e.target.id+'">Confirmer</a><button class="button" id="cancelDelete">Annuler</button></div></div></div></div>');
		$('#cancelDelete').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}

	deletePost(e)
	{
		var article = ($(e.target).hasClass('newsPost')) ? 'newsPost' : 'testimonyPost';

		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Supprimer un commentaire</h2><p>Vous êtes sur le point d\'effacer ce commentaire définitivement<br />Souhaitez-vous continuer ?</p><div class="displayFlex center"><a class="button" href="'+this.host+'deletePost/'+article+'/'+e.target.id+'">Confirmer</a><button class="button" id="cancelDelete">Annuler</button></div></div></div></div>');
		$('#cancelDelete').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}

	deleteTestimony(e)
	{
		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Supprimer un témoignage</h2><p>Vous êtes sur le point d\'effacer ce témoignage définitivement<br />Souhaitez-vous continuer ?</p><div class="displayFlex center"><a class="button" href="'+this.host+'deleteTestimony/testimonyId/'+e.target.id+'">Confirmer</a><button class="button" id="cancelDelete">Annuler</button></div></div></div></div>');
		$('#cancelDelete').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}

	displayTermOfService(e)
	{
		e.preventDefault();

		var content = 'Vous acceptez, en participant à ce service, de ne pas utiliser l\'espace commentaire pour publier des informations que vous savez fausses ou diffamatoires, inexactes, vulgaires, haineuses, obscènes, menaçantes, tendancieuses, attentatoires à la vie privée, ou plus généralement en violation de la loi et du règlement.'
		content += ' Vous vous engagez à ne pas diffuser de contenu qui violerait des règles de propriété intellectuelle, hormis si vous êtes titulaire des droits afférents.<br/><br/>'
		content += 'Votre identité peut être fournie aux autorités judiciaires dans le cadre d\'une enquête ou une action judiciaire à votre encontre. Toutes les adresses IP utilisées pour accéder au site sont conservées.'
		content += '<br/><br/>La publicité, les chaînes, les mécanismes à diffusion pyramidale et toute forme de sollicitations commerciales ne sont pas acceptées sur ce site.<br/><br/>Nous nous réservons le droit de retirer tout contenu pour quelque raison que ce soit et sans justification.'
		content += 'Nous nous réservons également le droit de mettre fin à toute participation sans avoir à le justifier.'

		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frameBis"><h2 class="uppercase">Conditions générales d\'utilisation</h2><div>'+content+'</div><button class="button" id="cancelSignin">Fermer</button></div></div></div>');
		$('#cancelSignin').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}

	signInAccount(e)
	{
		e.preventDefault();

		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Connexion</h2><form class="paddingRule" method="post" action="'+this.host+'signin"><div class="form-group"><label for="login">Identifiant / Email</label><input class="form-control" type="text" name="login" id="login" /></div><div class="form-group"><label for="password">Mot de passe</label><input class="form-control" type="password" name="password" id="password" /></div><div class="displayFlex center"><button type="submit" class="button">Confirmer</button><button class="button" id="cancelSignin">Annuler</button></div></form></div></div></div>');
		$('#cancelSignin').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}
}