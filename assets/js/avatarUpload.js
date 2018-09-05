class AvatarUpload
{
	constructor(id)
	{
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';
		this.userid = $('.avatar').attr('id');
		this.addEvents();
		this.documentHeight = $('html').height();
	}

	addEvents()
	{
		$('#avatarUpload').on('drop', (e) => {this.getDropFile(e, this)});
		$('#avatarUpload').on('dragover', (e) => {this.dragOver(e)});
		$('#avatarUpload').on('dragleave', (e) => {this.dragLeave()});
		$('html').on('drop', function(e) { e.preventDefault(); e.stopPropagation();});
		$('#file').change(() => {this.getClickFile()});
	}

	closeWindow()
	{
		$('#popupContainer').remove();
	}

	dragLeave()
	{
		$('#avatarUpload').removeClass('active');
	}

	dragOver(e)
	{
		e.preventDefault();
		//e.stopPropagation();
		$('#avatarUpload').addClass('active');
	}

	getClickFile()
	{
		var fd = new FormData();

        var files = $('#file')[0].files[0];

        fd.append('file',files);

        this.uploadAvatar(fd);
	}

	getDropFile(e)
	{
		var file = e.originalEvent.dataTransfer.files;

		var fd = new FormData();

        fd.append('file', file[0]);

        this.uploadAvatar(fd);

        this.dragLeave();
	}

	sendErrorMessage(response)
	{
		this.errorMessage = 'Le fichier proposé n\'est pas une image';

		if(response.statusText === 'Invalid file size')	{this.errorMessage = 'La taille de l\'image ne doit pas dépasser 500ko';}

    	if(response.statusText === 'Invalid file width') {this.errorMessage = 'Les dimensions de votre image ne doivent pas dépasser 500 x 750 pixels';}

    	if(response.statusText === 'Invalid extension.') {this.errorMessage = 'Votre image n\'a pas une extension valide';}

    	$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"></div></div></div>');

    	setTimeout(() =>
    	{
    		$('#frame').html('<h2 class="uppercase">Erreur 400</h2><p>'+this.errorMessage+'</p><div class="d-flex justify-content-center"><button id="cancelButton" class="button">fermer</button></div>');
			$('#cancelButton').click(() => {this.closeWindow()});
    	}, 100);
    	
		$('#popupContainer').height(this.documentHeight);

	}

	updateAvatar(response)
	{
		$('.avatar').fadeOut(500);		

		setTimeout(() =>
		{
			$('.avatar').fadeIn(500).html('<img id="avatar" src="'+this.host+'/assets/images/avatars/'+response['name']+'" alt="avatar" >');
		}, 500);
	}

	uploadAvatar(formdata)
	{
        $.ajax(
		{
    	    url: this.host+"uploadAvatar",
    	    type: 'post',
    	    data: formdata,
    	    contentType: false,
    	    processData: false,
    	    dataType: 'json',
    	    success: (response) => {this.updateAvatar(response);},
    	    error: (response) => {this.sendErrorMessage(response);}
    	});
	}
}