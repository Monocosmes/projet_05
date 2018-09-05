class EditPost
{
	constructor()
	{
		this.addEvents();
		this.isActivated = false;
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';
	}

	addEvents()
	{
		$('.editPostButton').click((e) => {this.editPost(e)});
		$('.editConversation').click((e) => {this.editConversation(e)});
	}

	cancelEdit(e)
	{
		e.preventDefault();

		this.isActivated = false;
		this.$1.empty();
		this.$1.append(this.$3);

		this.addEvents();
	}

	closeEditWindow(e)
	{
		this.cancelEdit(e);

		this.editPost(e);
	}

	editPost(e)
	{
		e.preventDefault();

		var article = ($(e.target).hasClass('newsPost')) ? 'newsId' : 'testimonyId';

		if(!this.isActivated)
		{
			this.isActivated = true;
			this.articleId = $('.sectionTitle').attr('id');
			this.targetButton = $('button[value="'+e.target.value+'"]');
			this.$1 = $('#post-'+e.target.value);
			this.$2 = $('#post-'+e.target.value+' > div:last-child').text();
			this.$3 = $('#post-'+e.target.value).html();
			this.$1.empty();

			$('button[value="'+e.target.value+'"]').remove();
			this.$1.append('<div class="marginRule paddingRule"><form method="post" action="'+this.host+'editPost"><input type="hidden" name="id" value="'+e.target.value+'" /><input type="hidden" name="'+article+'" value="'+this.articleId+'" /><textarea name="content" rows="5" class="form-control">'+this.$2+'</textarea><button type="reset" class="button cancelEdit">Annuler</button> <button class="button validEdit" type="submit">Valider</button></form></div>');

			$('.cancelEdit').click((e) => {this.cancelEdit(e)});
		}
		else
		{
			this.closeEditWindow(e);
		}
	}

	editConversation(e)
	{
		e.preventDefault();

		if(!this.isActivated)
		{
			this.isActivated = true;
			this.articleId = $('.sectionTitle').attr('id');
			this.targetButton = $('button[value="'+e.target.value+'"]');
			this.$1 = $('#messageId-'+e.target.value);
			this.$2 = $('#messageId-'+e.target.value+' div:last-child').text();
			this.$3 = $('#messageId-'+e.target.value).html();
			this.$1.empty();

			$('button[value="'+e.target.value+'"]').remove();
			this.$1.append('<div><form method="post" action="'+this.host+'editMessage"><input type="hidden" name="id" value="'+e.target.id+'" /><textarea name="content" rows="5" class="form-control">'+this.$2+'</textarea><button type="reset" class="button cancelEdit">Annuler</button> <button class="button validEdit" type="submit">Valider</button></form></div>');
			
			$('.cancelEdit').click((e) => {this.cancelEdit(e)});
		}
		else
		{
			this.closeEditWindow(e);
		}
	}
}
