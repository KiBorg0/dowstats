jQuery( document ).ready(function() {
	jQuery('#scrollup').mouseover( function(){
		jQuery( this ).animate({opacity: 0.85},100);
	}).mouseout( function(){
		jQuery( this ).animate({opacity: 0.65},100);
	}).click( function(){

		$( 'html:not(:animated),body:not(:animated)' ).animate({ scrollTop: 0}, 500 );
		return false;
	});

	jQuery(window).scroll(function(){
		if ( jQuery(document).scrollTop() > 0 ) {
			jQuery('#scrollup').fadeIn('fast');
		} else {
			jQuery('#scrollup').fadeOut('fast');
		}
	});
});
