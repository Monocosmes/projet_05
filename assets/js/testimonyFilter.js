class TestimonyFilter
{
	constructor(sections)
	{
		this.sections = sections;

		this.addEvents();
	}

	addEvents()
	{
		$('.testimonyLink').click((e) => {this.filter(e.currentTarget.id);});
	}

	filter(id)
	{
		for(var i = 0; i < this.sections.length; i++)
		{
			if(id === 'testimony-0')
			{
				this.sections[i].style.display = 'block';
			}
			else
			{
				if(!this.sections[i].classList.contains(id))
				{
					this.sections[i].style.display = 'none';
				}
				else
				{
					this.sections[i].style.display = 'block';
				}
			}
			
		}		
	}
}