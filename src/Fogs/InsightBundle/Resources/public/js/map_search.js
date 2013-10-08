// The form.map-search is supposed to update the markers on the #map_canvas  

(function ($) {
	$(document).ready(function () { 
		
		$( "form.map-search" ).on( "submit", function( event ) {

			event.preventDefault();

			var $form = $( this ),
			data = $form.serialize(),
			url = $form.attr( "action" );
			// Send the data using post
			var posting = $.post( url, data );

			$('#map_canvas').gmap('clear', 'markers');
			posting.done(function( results ) {
				$.each(results, function(i, marker) {
				
					$('#map_canvas').gmap('addMarker', { 
						'position': new google.maps.LatLng(marker.location.latitude, marker.location.longitude), 
						'bounds': true 
					}).click(function() {
						$('#map_canvas').gmap('openInfoWindow', { 'content': marker.title }, this);
					});
				});
			});

	        return false;
		});
		
	});
})(jQuery);


