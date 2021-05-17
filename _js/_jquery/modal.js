jQuery(document).ready(function($){
//open popup
	$('#botao_enviar').on('click', function(event){
		event.preventDefault();
		$('.md-popup').addClass('is-visible');
	});
	
//close popup
	$('.md-popup').on('click', function(event){
		if($(event.target).is('.md-popup-close') || $(event.target).is('.md-popup') || $(event.target).is('#cancela')) {
			event.preventDefault();
			$(this).removeClass('is-visible');
		} else if ($(event.target).is('#envia')) {
			$('#envia_dados').submit();
		}
	});

//close popup when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$('.md-popup').removeClass('is-visible');
	    }
    });
});