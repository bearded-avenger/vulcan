jQuery(document).ready(function(){
	jQuery('.show-soren-comments').click(function(event){
		event.preventDefault();
		jQuery('#soren-comments-wrap').fadeToggle();
	});
});