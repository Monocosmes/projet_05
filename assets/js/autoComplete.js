class AutoComplete
{
	constructor()
	{
		this.addEvents();
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';
	}

	addEvents()
	{
		$('#nickname').keyup((e) => this.complete(e));
		$('.isAccepted').change((e) => this.checkBox(e));
		$('#existingMessages').change((e) => this.editModerationSentence(e));
	}

	addText(e)
	{
		$('#nickname').val(e.target.innerText);
		$('#loginList').fadeOut();
	}

	checkBox(e)
	{
		var noBox = e.target.id.replace('yes', 'no');
		var yesBox = e.target.id.replace('no', 'yes');
		
		if(e.target.id.match(/yes/) && e.target.checked === true && $('#'+noBox+':checkbox:checked').length > 0)
		{			
			$('#'+noBox).prop('checked', false);
		}
		else if(e.target.id.match(/no/) && e.target.checked === true && $('#'+yesBox+':checkbox:checked').length > 0)
		{
			$('#'+yesBox).prop('checked', false);			
		}
	}

	complete(e)
	{
		var query = e.target.value;

		if(query.length > 1)
		{
			$.ajax(
			{
				url: this.host+"getUsers",
				method: "POST",
				data: {query:query},
				success: function(data)
				{
					$('#loginList').fadeIn().html(data);
				}
			});

			$(document).on('click', '.userName', (e) => {this.addText(e)});
		}
		else if(query.length === 0)
		{
			$('#loginList').fadeOut();
		}		
	}

	editModerationSentence(e)
	{
		if (e.target.value != 0) {
			$('#moderationMessage').val($('#existingMessages > option[value="'+e.target.value+'"]').text());
		} else {
			$('#moderationMessage').val('');
		}
	}
}