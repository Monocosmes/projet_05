class BackToTop
{
	constructor()
	{
		this.addEvents();
		this.isActivated = false;
	}

	addEvents()
	{
		$(window).scroll(() => this.displayBackToTopButton());
	}

	backToTop(e)
	{
		e.preventDefault();
    	$('html, body').animate({scrollTop: 0}, 400);
	}

	displayBackToTopButton()
	{
		if($(window).scrollTop() > 200)
    	{
    	  	$('#backToTop').css('visibility', 'visible');
    	  	if(!this.isActivated)
    	  	{
    	  		this.isActivated = true;
    	  		$('#backToTop').click((e) => this.backToTop(e));
    	  	}
    	}
    	else
    	{
    	  this.isActivated = false;
    	  $('#backToTop').off();
    	  $('#backToTop').css('visibility', 'hidden');
    	}
	}
}