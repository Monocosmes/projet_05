class Popup
{
	constructor()
	{
		this.addEvents();
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';
		this.documentHeight = $('html').height();
	}

	addEvents()
	{
		$('#deleteAccount').click((e) => {this.deleteAccount(e)});
		$('.loginPopup').click((e) => {this.signInAccount(e)});
		$('.leaveConversation').click((e) => {this.leaveConversation(e)});
		$('.deleteMessage').click((e) => {this.deleteMessage(e)});
		$('.deleteNews').click((e) => {this.deleteNews(e)});
		$('.deleteTestimony').click((e) => {this.deleteTestimony(e)});
		$('.deletePost').click((e) => {this.deletePost(e)});
		$('#service').click((e) => {this.displayTermOfService(e)});
	}

	closeWindow()
	{
		$('#popupContainer').remove();
	}

	createFrame(e = null)
	{
		if(e != null)
		{
			e.preventDefault();
		}

		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="'+this.class+'"></div></div></div>');
		
		setTimeout(() =>
    	{
    		$('#'+this.class).html('<h2 class="uppercase">'+this.frameTitle+'</h2>'+this.frameContent+this.endPart);
			$('#cancelButton').click(() => {this.closeWindow()});
    	}, 100);
		
		$('#popupContainer').height(this.documentHeight);
	}

	deleteAccount(e)
	{
		this.frameTitle = 'Supprimer le compte';
		this. frameContent = '<p>Vous êtes sur le point de supprimer ce compte. Vous pouvez choisir de supprimer les commentaires liés ou non. Si vous ne les supprimez pas, vous renoncez à votre droit de modifier ou supprimer les messages que vous avez publié sur ce site<br />Souhaitez-vous continuer ?</p>';
		this.endPart = '<form method="post" action="'+this.host+'deleteAccount"><input type="hidden" name="userId" value="'+e.target.value+'" /><div class="form-group"><label for="deletePost"><input type="checkbox" name="deletePost" id="deletePost" /> Supprimer les commentaires</label></div><div class="d-flex justify-content-center"><button type="submit" class="button">Confirmer</button><button class="button" id="cancelButton">Annuler</button></div></form>';
		this.class = 'frame';

		this.createFrame(e);
	}

	deleteMessage(e)
	{
		this.frameTitle = 'Supprimer un message';
		this. frameContent = '<p>Vous êtes sur le point de supprimer ce message définitivement<br />Souhaitez-vous continuer ?</p>';
		this.endPart = '<div class="d-flex center"><a class="button" href="'+this.host+'deleteMessage/messageId/'+e.target.id+'">Confirmer</a><button class="button" id="cancelButton">Annuler</button></div>';
		this.class = 'frame';

		this.createFrame(e);
	}

	deleteNews(e)
	{
		this.frameTitle = 'Supprimer un article';
		this. frameContent = '<p>Vous êtes sur le point d\'effacer cet article définitivement<br />Souhaitez-vous continuer ?</p>';
		this.endPart = '<div class="d-flex center"><a class="button" href="'+this.host+'deleteNews/newsId/'+e.target.id+'">Confirmer</a><button class="button" id="cancelButton">Annuler</button></div>';
		this.class = 'frame';

		this.createFrame();
	}

	deletePost(e)
	{
		var article = ($(e.target).hasClass('newsPost')) ? 'newsPost' : 'testimonyPost';

		this.frameTitle = 'Supprimer un commentaire';
		this. frameContent = '<p>Vous êtes sur le point d\'effacer ce commentaire définitivement<br />Souhaitez-vous continuer ?</p>';
		this.endPart = '<div class="d-flex center"><a class="button" href="'+this.host+'deletePost/'+article+'/'+e.target.id+'">Confirmer</a><button class="button" id="cancelButton">Annuler</button></div>';
		this.class = 'frame';

		this.createFrame();
	}

	deleteTestimony(e)
	{
		this.frameTitle = 'Supprimer un témoignage';
		this. frameContent = '<p>Vous êtes sur le point d\'effacer ce témoignage définitivement<br />Souhaitez-vous continuer ?</p>';
		this.endPart = '<div class="d-flex center"><a class="button" href="'+this.host+'deleteTestimony/testimonyId/'+e.target.id+'">Confirmer</a><button class="button" id="cancelButton">Annuler</button></div>';
		this.class = 'frame';

		this.createFrame();
	}

	displayTermOfService(e)
	{
		this.content = 'Vous acceptez, en participant à ce service, de ne pas utiliser l\'espace commentaire pour publier des informations que vous savez fausses ou diffamatoires, inexactes, vulgaires, haineuses, obscènes, menaçantes, tendancieuses, attentatoires à la vie privée, ou plus généralement en violation de la loi et du règlement.'
		this.content += ' Vous vous engagez à ne pas diffuser de contenu qui violerait des règles de propriété intellectuelle, hormis si vous êtes titulaire des droits afférents.<br/><br/>'
		this.content += 'Votre identité peut être fournie aux autorités judiciaires dans le cadre d\'une enquête ou une action judiciaire à votre encontre. Toutes les adresses IP utilisées pour accéder au site sont conservées.'
		this.content += '<br/><br/>La publicité, les chaînes, les mécanismes à diffusion pyramidale et toute forme de sollicitations commerciales ne sont pas acceptées sur ce site.<br/><br/>Nous nous réservons le droit de retirer tout contenu pour quelque raison que ce soit et sans justification.'
		this.content += 'Nous nous réservons également le droit de mettre fin à toute participation sans avoir à le justifier.'

		this.frameTitle = 'Conditions générales d\'utilisation';
		this.frameContent = '<div>'+this.content+'</div>';
		this.endPart = '<div class="d-flex justify-content-center"><button class="button" id="cancelButton">Fermer</button></div>';
		this.class = 'frameBis';

		this.createFrame(e);
	}

	leaveConversation(e)
	{
		this.frameTitle = 'Quitter la conversation';
		this.frameContent = '<p>Avant de quitter cette conversation, souhaitez-vous en effacer les messages que vous avez rédigé&nbsp?<br>Vous pourrez toujours les effacer ultérieurement <a href="#">ici</a></p>';
		this.endPart = '<form method="post" action="'+this.host+'leaveConversation"><input type="hidden" name="messageId" value="'+e.target.id+'" /><div class="form-group"><label for="deleteMessages"><input type="checkbox" name="deleteMessages" id="deleteMessages" /> Supprimer les messages</label></div><div class="d-flex justify-content-center"><button type="submit" class="button">Confirmer</button><button class="button" id="cancelButton">Annuler</button></div></form>';
		this.class = 'frame';

		this.createFrame();
	}

	signInAccount(e)
	{
		this.frameTitle = 'Connexion';
		this.frameContent = '';
		this.endPart = '<form class="paddingRule" method="post" action="'+this.host+'signin"><div class="form-group"><label for="login">Identifiant / Email</label><input class="form-control" type="text" name="login" id="login" /></div><div class="form-group"><label for="password">Mot de passe</label><input class="form-control" type="password" name="password" id="password" /></div><div class="d-flex justify-content-center"><button type="submit" class="button">Confirmer</button><button class="button" id="cancelButton">Annuler</button></div></form>';
		this.class = 'frame';

		this.createFrame(e);
	}
}