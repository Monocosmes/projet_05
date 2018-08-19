class SignupForm
{
	constructor()
	{
		this.addEvents();
	}

	addEvents()
	{
		$('#employee').change((e) => this.addFields(e));
	}

	addFields(e)
	{
		if(e.target.checked)
		{
			$('#name, #lastname, #matricule').removeClass('hidden');
		}
		else
		{
			$('#name, #lastname, #matricule').addClass('hidden');
		}
	}
}