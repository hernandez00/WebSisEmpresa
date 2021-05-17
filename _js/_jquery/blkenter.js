// Impede o submit do formulario ao pressionar a tecla Enter, ativando
//ela somente para a quebra de linhas no campo de observação.
$(window).keydown(function(event){
	if(event.keyCode == 13 && !$(document.activeElement).is('textarea')) {
		event.preventDefault();
		return false;
	}
});