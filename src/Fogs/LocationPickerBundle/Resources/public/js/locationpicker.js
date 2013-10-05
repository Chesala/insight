

(function ($) {
	$(document).ready(function () { 
		
		// find all geocomplete input elements 
		$("input.geocomplete").each(function() {

			// initialize geocomplete
			$(this).geocomplete(geocompleteOptions[this.id]);

			// if marker is draggable, bind callback
			if (typeof geocompleteOptions['fogs_insightbundle_searchtype_location'].markerOptions !='undefined' && geocompleteOptions[this.id].markerOptions.draggable) {
				$(this).bind("geocode:dragged", function(event, latLng){
		        	$("#" + this.id + "_latitude").val(latLng.lat());
		        	$("#" + this.id + "_longitude").val(latLng.lng());
		       	}); 
			}
		
		});
		
	});
})(jQuery);
