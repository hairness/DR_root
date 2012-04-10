jQuery(document).ready(function($) { 

	$('#mainftp').uploadify({
  	'uploader'	: 'http://localhost:8888/designradar.net/wp-content/themes/designradar/js/uploadify/uploadify.swf',
  	'script'    : 'http://localhost:8888/designradar.net/wp-content/themes/designradar/js/uploadify/uploadify.php',
  	'multi'			: true,
  	'auto'			: true,
  	'height'		:	'32', //height of your browse button file
  	'width'			:	'250', //width of your browse button file
  	'sizeLimit'	:	'51200',  //remove this to set no limit on upload size
  	'simUploadLimit' : '3', //remove this to set no limit on simultaneous uploads
  	'buttonImg' : 'http://localhost:8888/designradar.net/wp-content/themes/designradar/images/browse.png',
  	'cancelImg' : 'http://localhost:8888/designradar.net/wp-content/themes/designradar/images/cancel.png',
		'folder'    : '../../uploads/objects/', //folder to save uploads to
		onProgress: function() {
		  $('#loader').show();
		},
		onComplete: function(event, queueID, fileObj, response, data) {
			var output = '<img src="http://localhost:8888/designradar.net/wp-content/uploads/objects/' + fileObj.name +'"/>';
			$('#loader').hide();
            $('#allfiles').html(output);
        }	
	}); 
 
}); 
