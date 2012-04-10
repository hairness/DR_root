function updateCoords(c) {
	$('#handw').show();
  $('#x').val(c.x);
  $('#y').val(c.y);
  $('#w').val(c.w);
  $('#h').val(c.h);
  $('#pich').html(c.h);
  $('#picw').html(c.w);
};

function checkCoords()
{
  if (parseInt($('#x').val())) return true;
  alert('Please select a crop region then press submit.');
  return false;
};


jQuery(document).ready(function() { 
	
	$(window).load(function(){
	var api = $.Jcrop('#cropbox',{
    onChange: updateCoords,
    onSelect: updateCoords,
    boxWidth: 500, 
    boxHeight: 500
  }); 
  var isCtrl = false;
	$(document).keyup(function (e) {
		api.setOptions({ aspectRatio: 0 });
		api.focus();
		if(e.which == 17) isCtrl=false;
	}).keydown(function (e) {
		if(e.which == 17) isCtrl=true;
		if(e.which == 81 && isCtrl == true) {
			api.setOptions({ aspectRatio: 1 });
			api.focus();
		}
	});
});
 
 
}); 
