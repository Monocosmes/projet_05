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

	signInAccount(e)
	{
		e.preventDefault();

		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"><h2 class="uppercase">Connexion</h2><form class="padding_rule" method="post" action="'+this.host+'signin"><div class="form-group"><label for="login">Identifiant / Email</label><input class="form-control" type="text" name="login" id="login" /></div><div class="form-group"><label for="password">Mot de passe</label><input class="form-control" type="password" name="password" id="password" /></div><div class="displayFlex center"><button type="submit" class="buttons">Confirmer</button><button class="buttons" id="cancelSignin">Annuler</button></div></form></div></div></div>');
		$('#cancelSignin').click(() => {this.closeWindow()});
		$('#popupContainer').height(this.documentHeight);
	}
}