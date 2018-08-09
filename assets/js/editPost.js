class EditPost
{
	constructor()
	{
		this.addEvents();
		this.isActivated = false;
		this.host = 'http://localhost/projet_05/';
	}

	addEvents()
	{
		$('.editPostButton').click((e) => {this.editPost(e)});
	}

	cancelEdit(e)
	{
		e.preventDefault();

		this.isActivated = false;
		this.$1.empty();
		this.$1.append(this.$3);
		this.targetButton.insertBefore(this.$1);

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

		if(!this.isActivated)
		{
			this.isActivated = true;
			this.newsId = $('#newsViewPage h1').attr('id');
			this.targetButton = $('button[value="'+e.target.value+'"]');
			this.$1 = $('#post-'+e.target.value);
			this.$2 = $('#post-'+e.target.value+' > div').html();
			this.$3 = $('#post-'+e.target.value).html();
			this.$1.empty();
			$('button[value="'+e.target.value+'"]').remove();
			this.$1.append('<div id="editPost"><form method="post" action="'+this.host+'editPost"><input type="hidden" name="id" value="'+e.target.value+'" /><input type="hidden" name="newsId" value="'+this.newsId+'" /><textarea name="content">'+this.$2+'</textarea><button type="reset" class="buttons cancelEdit" name="cancelEdit">Annuler</button> <button class="buttons editPostButton" type="submit" name="editPost">Valider</button></form></div>');
			
			tinymce.init({ selector:'textarea' });

			$('.cancelEdit').click((e) => {this.cancelEdit(e)});
		}
		else
		{
			this.closeEditWindow(e);
		}
	}
}
