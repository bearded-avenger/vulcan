(function($){
	
	$('.show-soren-comments').click(function(event){
		event.preventDefault();
		$('#soren-comments-wrap').fadeToggle();
		$('html, body').animate({
		        scrollTop: $( $(this).attr('href') ).offset().top
		}, 500);
		return false;
	});

})( jQuery );