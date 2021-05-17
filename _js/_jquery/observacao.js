$(document).ready(function() {
	var id = "";
//Abre o campo de observação e fecha qualquer outro que estiver aberto
	$('.abre_observacao').click(function(){
		id = $(this).attr('id_registro');
		if($('#text_observacao' + id).css('display') == 'none'){
			$('.observacao').slideUp("slow", "linear");
        	$('#text_observacao' + id).slideDown("slow", "linear");
        } else {
        	$('.observacao').slideUp("slow", "linear");
        }
	})

//Campo de observação geral
	$('#idobservacao_geral').click(function() {
		if($('#text_observacao_geral').css('display') == 'none'){
			$('.observacao').slideUp("slow", "linear");
        	$('#text_observacao_geral').slideDown("slow", "linear");
        } else {
        	$('.observacao').slideUp("slow", "linear");
        }
	})

//Fecha o campo de observação ao clicar fora dele
	$('.observacao').on('focusout', function() {
		$('.observacao').slideUp("slow", "linear");
		$('.observacao').each(function(){
			defineIcon();
			defineIconGeral();
		})
	})

//Funções para alterar o ícone de observação caso esteja preenchido
	function defineIcon() {
		if ($('#text_observacao' + id).val() == "") {
			$('#idobservacao' + id).css('background-image', 'url(' + '././_img/_icones/icone-observacao.ico' + ')');
		} else {
			$('#idobservacao' + id).css('background-image', 'url(' + '././_img/_icones/icone-observacao2.ico' + ')');
		}
	}

	function defineIconGeral() {
		if ($('#text_observacao_geral').val() == "") {
			$('#idobservacao_geral').css('background-image', 'url(' + '././_img/_icones/icone-observacao.ico' + ')');
		} else {
			$('#idobservacao_geral').css('background-image', 'url(' + '././_img/_icones/icone-observacao2.ico' + ')');
		}	
	}
});