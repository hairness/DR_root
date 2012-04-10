jQuery(document).ready( function() {
	
	//update 13.03. .live() for ajax called query nice function .fadeToggle()!!!!
	jQuery('div.card').live("hover", function(){
		jQuery(this).find('div.overlay').fadeToggle(100);
	});

});