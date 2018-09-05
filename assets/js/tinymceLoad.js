class TinymceLoad
{
	constructor()
	{
		this.host = 'http://localhost/projet_05/';
        //this.host = 'http://projet05.galiacy.fr/';

		this.loadTinymceArticle(this.host);
	}

	loadTinymceArticle(host)
	{
	    tinymce.init(
		{ 
  			selector:'.textarea',
  			images_upload_url: host+'uploadImage',
  			images_upload_handler: function(blobInfo, success, failure)
  			{
  				var xhr;
  				var formData;

  				xhr = new XMLHttpRequest();
  				xhr.withCredentials = false;
  				xhr.open('POST', host+'uploadImage');

  				xhr.onload = function()
  				{
  					var json;

  					if(xhr.status != 200)
  					{
  						failure('HTTP Error: ' + xhr.status);
  						return;
  					}

  					json = JSON.parse(xhr.responseText);

  					if(!json || typeof json.location != 'string')
  					{
  						failure('Invalid JSON: ' + xhr.responseText);
  						return;
  					}

  					success(json.location);
  				};

  				formData = new FormData();
  				formData.append('file', blobInfo.blob(), blobInfo.filename());

  				xhr.send(formData);
  			},

  			images_upload_base_path: this.host+'/assets/images/articles/',
  			//images_upload_credentials: true,
  			language: 'fr_FR',
  			plugins: 'code image imagetools emoticons',
  			toolbar: 'undo redo | image imageoptions | code | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify alignnone | formatselect fontselect fontsizeselect styleselect | emoticons',
  			image_title: true,
  			relative_urls: false,
  			remove_script_host: false
  		});
	}
}