class ProfileSettings
{
	constructor()
	{
		this.addEvents();
		this.addSentences();
	}

	addEvents()
	{
		$('#seeEmail, #seePhoneNumber, #seeName, #seeLastName').change((e) => this.changeSentence(e));
	}

	addSentences()
	{
		$('#seeEmailText').text(this.sentences($('#seeEmailValue').attr('value')));
		$('#seePhoneNumberText').text(this.sentences($('#seePhoneNumberValue').attr('value')));
		$('#seeNameText').text(this.sentences($('#seeNameValue').attr('value')));
		$('#seeLastNameText').text(this.sentences($('#seeLastNameValue').attr('value')));
	}

	changeSentence(e)
	{
		$('#'+e.target.name+'Value').removeAttr('id');
		$(e.target).attr('id', e.target.name+'Value');
		this.addSentences();
	}

	sentences(number)
	{
		switch (number)
		{
			case '0':
				return 'Non visible';
				break;

			case '1':
				return 'Visible par tous';
				break;

			case '2':
				return 'Visible par tous les membres inscrits';
				break;

			case '3':
				return 'Visible par les membres validés, les membres du bureau et les administrateurs';
				break;

			case '4':
				return 'Visible par les membres du bureau et les administrateurs';
				break;

			case '5':
				return 'Visible uniquement par les administrateurs';
				break;
		}
	}
}