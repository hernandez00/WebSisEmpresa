$(document).ready(function() {
	var id = "";
    calcular();
    
    $('.valores').on('focusout', function() {
        calcular();
        //somaTotal();
    })

//Função que faz o calculo de valor do total ao sair de cada item ------------------------------
    function calcular() {
        $('.valores').each(function(){
            id = $(this).attr('id_registro');
            var vunit = 0.00;
            var qtd   = 0.00;
            var valor = 0.00;

            vunit = $(this).val() != '' ? $(this).val().replace(/\./g, '').replace(',', '.') : 0;
            qtd   = parseFloat($('#quantidade-' + id).text() != '' ? $('#quantidade-' + id).text().replace('.', ',') : 0);
            valor = vunit*qtd;
            var valorFormatado = valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2});

    //Mask para adicionar zeros a direita ----------------------------------------------------------
            if (vunit.length < 5) {
                $('#valunit' + id).val(parseFloat(vunit).toFixed(4).replace('.', ','));
            }

            $('#totalitem' + id).text(valorFormatado);
            $('#totalitem-input' + id).val(valorFormatado);
            somaTotal();      
        })
    }

    function somaTotal() {
    	var id = '';
		var tot = 0.00;
    	$('.totalitem').each(function() {
    		id = $(this).attr('id_registro');
    		tot = parseFloat(tot) + ($('#totalitem' + id).text() != '' ? parseFloat($('#totalitem' + id).text().replace(/\./g,'').replace(',','.')) : 0.00);
    		$('#soma-total').text(tot.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2}));
            $('#somatotal-input').val(tot.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2}));
    	})
    }
});