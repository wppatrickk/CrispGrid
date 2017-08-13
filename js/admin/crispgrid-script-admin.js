jQuery(document).ready(function($) {
	if ($('#crispgrid-excerpt').is(":checked")) {
		$('#crispgrid-excerpt-length').hide();
	}

	if ($('#crispgrid-link').is(":checked")) {
		$('#crispgrid-read-more').hide();
	}

	$('#crispgrid-excerpt').click(function() {
	    if(!$(this).is(':checked')) {
	        $('#crispgrid-excerpt-length').show();
	    } else {
	    	$('#crispgrid-excerpt-length').hide();
	    }
	});

	$('#crispgrid-link').click(function() {
	    if(!$(this).is(':checked')) {
	        $('#crispgrid-read-more').show();
	    } else {
	    	$('#crispgrid-read-more').hide();
	    }
	});

	$('.crispgrid-color-input').iris();
});