jQuery( document ).ready(function() {

	// Toggle all checkboxes
	jQuery( "input.toggleAll").click(function() {
		if ( jQuery( this ).is( ":checked" ) ) {
			jQuery( ".selectEntry" ).prop( "checked", true );
		} else {
			jQuery( ".selectEntry" ).prop( "checked", false );
		}
	});

});