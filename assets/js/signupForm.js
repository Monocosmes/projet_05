class SignupForm
{
	constructor()
	{
		this.host = 'http://localhost/projet_05/';
		//this.host = 'http://projet05.galiacy.fr/';

		this.documentHeight = $('html').height();
		this.isPasswordMatchOk = false;
		this.isPasswordOk = false;
		this.isLoginOk = false;
		this.isEmailOk = false;
		this.isTermOk = false;

		this.addEvents();
		this.checkBox();
	}

	addEvents()
	{
		$('#employee').change((e) => this.addFields(e));
		$('#login').change((e) => this.isLoginFree(e));
		$('#email').change((e) => this.isEmailFree(e));
		$('#password').keyup((e) => this.checkPassword(e));
		$('#password').change((e) => this.checkPasswordLength(e));
		$('#password, #matchPassword').focusout((e) => this.isPasswordsMatch(e));
		$('#signupSubmit').click((e) => this.validSubmit(e));
		$('#termOfService').change((e) => this.checkTermOfService(e));
		$('#matricule').change((e) => this.isMatriculeFree(e));
	}

	addFields(e)
	{
		if(e.target.checked) {
			var titleBox = 'Message informatif';
			var contentBox = 'En cochant cette case, vous acceptez qu\'une demande à passer en \'Membre Validé\' soit envoyée à l\'administrateur du site.';
			contentBox += '<br>Vous acceptez également que l\'administrateur du site ait accès à vos nom, prénom et matricule lors de la validation de votre demande.';

			$('#userName span[title="Requis"], #userLastname span[title="Requis"], #userMatricule span[title="Requis"]').text('*');
			$('#userName input, #userLastname input, #userMatricule input').attr('required', 'true');

			this.sendMessage(e, titleBox, contentBox);
		} else {
			$('#userName span[title="Requis"], #userLastname span[title="Requis"], #userMatricule span[title="Requis"]').text('');
			$('#userName input, #userLastname input, #userMatricule input').removeAttr('required');
		}
	}

	checkBox()
	{
		if($('#employee:checkbox:checked').length > 0) {
			$('#userName span[title="Requis"], #userLastname span[title="Requis"], #userMatricule span[title="Requis"]').text('*');
		}

		this.isNameOk = (!$('#name').val()) ? false : true;
		this.isLastnameOk = (!$('#lastname').val()) ? false : true;
		this.isMatriculeOk = (!$('#matricule').val()) ? false : true;
	}

	checkPassword(e)
	{
		var strengh = $(".strengh");
		var mdp = e.target.value;
		var strLength = "0%";
	
		if(mdp.length === 6) {
			strLength = "20%";
			strengh.css('backgroundColor', '#c81818');
			$('#resultPassword').empty();
		} else if(mdp.length === 7) {
			strLength = "40%";
			strengh.css('backgroundColor', '#ffac1d');
		} else if(mdp.length >= 8 && mdp.length < 10) {
			strLength = "60%";
			strengh.css('backgroundColor', '#ffac1d');
		} else if(mdp.length >= 10 && mdp.length < 12 ) {
			strLength = "80%";
			strengh.css('backgroundColor', '#a6C060');
		} else if (mdp.length >= 12) {
			strLength = "100%";
			strengh.css('backgroundColor', '#27b30f');
		}
		
		strengh.css('width', strLength);	
	}

	checkPasswordLength(e)
	{
		var mdp = e.target.value;

		if(mdp.length < 6) {
			$('#resultPassword').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Votre mot de passe est trop court</span>');
		} else if(mdp.length > 50) {
			$('#resultPassword').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Votre mot de passe est trop long</span>');
		} else {
			this.isPasswordOk = true;
		}
	}

	checkTermOfService(e)
	{
		if(e.target.value) {
			this.isTermOk = true;
		} else {
			this.isTermOk = false;
		}
	}

	closeWindow()
	{
		$('#popupContainer').remove();
	}

	isEmailFree(e)
	{
		var query = e.target.value;

		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
    	
    	if(pattern.test(query)) {
    		this.sendRequest('checkEmail', 'resultEmail', query);
    	} else {
    		$('#resultEmail').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">L\'adresse email n\'a pas une forme valide</span>');
    	}		
	}

	isLoginFree(e)
	{
		var query = e.target.value;

		if(query.length < 4) {
			$('#resultLogin').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Votre identifiant est trop court</span>');
		} else if(query.length > 30) {
			$('#resultLogin').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Votre identifiant est trop long</span>');
		} else {
			this.sendRequest('checkLogin', 'resultLogin', query);
		}		
	}

	isMatriculeFree(e)
	{
		var query = e.target.value;

		var pattern = /^0[0-9]{3,4}$/;

		if (query) {
			if(query.match(pattern)) {
				this.sendRequest('checkMatricule', 'resultMatricule', query);			
			}  else {
				$('#resultMatricule').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Votre matricule n\'a pas une forme valide</span>');
			}
		} else {
			$('#resultMatricule').empty();
		}
	}

	isPasswordsMatch(e)
	{
		var password = $('#password').val();
		var mdpMatch = $('#matchPassword').val();

		if(password || mdpMatch) {
			if (password != mdpMatch) {		
				$('#resultMatchPassword').html('&nbsp;&nbsp;<span class="textRed font-weight-bold">Les mots de passe ne correspondent pas</span>');
			} else {
				$('#resultMatchPassword').html('&nbsp;&nbsp;<span class="fas fa-check text-success"></span>');
				if(password.length >= 6 && password.length <= 50) {
					$('#resultPassword').html('&nbsp;&nbsp;<span class="fas fa-check text-success"></span>');
				}
				this.isPasswordMatchOk = true;
			}
		}
	}

	sendMessage(e, titleBox, contentBox)
	{
		$('body').append('<div id="popupContainer"><div id="popup"><div class="mainBorder" id="frame"></div></div></div>');

    	setTimeout(() =>
    	{
    		$('#frame').html('<h2 class="uppercase">'+titleBox+'</h2><p>'+contentBox+'</p><div class="d-flex justify-content-center"><button id="cancelButton" class="button">fermer</button></div>');
			$('#cancelButton').click(() => {this.closeWindow()});
    	}, 100);
    	
		$('#popupContainer').height(this.documentHeight);
		e.preventDefault();
	}

	sendRequest(method, id, query)
	{
		$.ajax(
		{
			url: this.host + method,
			method: "POST",
			data: {query:query},
			success: (data) =>
			{
				$('#'+id).html(data);

				var wrongLogin = $('#wrongLogin').length;
				var wrongEmail = $('#wrongEmail').length;
				var wrongMatricule = $('#wrongMatricule').length;
				
				if(wrongEmail == 0) {
					this.isEmailOk = true;
				}
				if(wrongLogin == 0) {
					this.isLoginOk = true;
				}
				if(wrongMatricule == 0) {
					this.isMatriculeOk = true;
				}
			}
		});
	}

	validSubmit(e)
	{
		var titleBox = 'Erreur';
		var contentBox = 'Certaines informations sont erronées ou manquantes.<br> Merci de les corriger avant de soumettre à nouveau ce formulaire';

		if(this.isPasswordOk && this.isLoginOk && this.isEmailOk && this.isPasswordMatchOk && this.isTermOk) {
			if($('#employee:checkbox:checked').length > 0) {
				this.isNameOk = (!$('#name').val()) ? false : true;
				this.isLastnameOk = (!$('#lastname').val()) ? false : true;

				if(this.isNameOk && this.isLastnameOk && this.isMatriculeOk) {
					$('#validSubmit').click();
				} else {
					this.sendMessage(e, titleBox, contentBox);
				}
			} else {
				$('#validSubmit').click();
			}			
		}
		else {
			this.sendMessage(e, titleBox, contentBox);
		}
	}
}