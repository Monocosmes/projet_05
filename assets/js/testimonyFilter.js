class TestimonyFilter
{
	constructor()
	{
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';

		this.linkId = 'testimony-0';

		this.addEvents();
		this.selectLink();
	}

	addEvents()
	{
		$('.testimonyLink').click((e) => {this.filter(e);});
	}

	filter(e)
	{
		$('#'+this.linkId).css('backgroundColor', '#343a40').css('color', 'rgba(255, 255, 255, 0.5)');

		this.linkId = e.target.id;
		var query = e.target.id.replace(/testimony-/, '');

		$.ajax(
		{
			url: this.host+"getTestimonies",
			method: "POST",
			data: {query:query},
			success: function(data)
			{
				if($('#noTestimony').length != 0) {
					$('#noTestimony').remove();
				}

				if (data.search(/noTestimony/) == -1) {
					var content = $('#newsPageContent').hide().html(data);
				} else {
					$('#newsPageContent').empty();
					var content = $(data).hide().insertAfter('#newsPageContent');
				}

				content.show('slide', {direction: 'right'}, 500);
			}
		});

		this.selectLink();
	}

	selectLink()
	{
		$('#'+this.linkId).css('backgroundColor', 'rgb(225, 91, 20)').css('color', 'rgba(255, 255, 255, 1)');
	}
}