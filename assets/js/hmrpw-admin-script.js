(function($){

	// USE STRICT
	"use strict";

	$.each(hmrpwAdminScript.hmrpwIdsOfColorPicker, function( index, value ) {
		$(value).wpColorPicker();
	});

	//====================================================
	$('.hmrpw-closebtn').on('click', function(){
		this.parentElement.style.display='none';
	});
    
})(jQuery);