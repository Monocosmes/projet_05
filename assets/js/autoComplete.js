class AutoComplete
{
	constructor()
	{
		this.addEvents();
		this.host = 'http://localhost/projet_05/';
	}

	addEvents()
	{
		$('#nickname').keyup((e) => {this.complete(e)});
	}

	addText(e)
	{
		$('#nickname').val(e.target.innerText);
		$('#loginList').fadeOut();
	}

	complete(e)
	{
		var query = e.target.value;

		if(query.length > 2)
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
}