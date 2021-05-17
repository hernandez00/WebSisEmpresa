$(document).ready(function() {
	$('#botao_enviar').on('click', function(){
		$('#id-situacao').val(1);
	})

	$('#botao_salvar').on('click', function(){
		$('#id-situacao').val(2);
	})
//1 - Em andamento
//2 - Concluido
});