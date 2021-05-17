$(document).ready(function() {
	var limit_length = 6;
	var limit_perc = 100.00;
	var valorIpi = 0.00;
	var valorIcms = 0.00;
	
	$('.icms').on('keyup', function() {
		var id = $(this).attr('id_registro');
		if ($('#icms' + id).val().length > limit_length) {
			alert("Não deve possuir mais que 2 casas após a virgula!");
			$('#icms' + id).val(100);
			return;
		}

		if ($('#icms' + id).val().replace(',', '.') > limit_perc) {
			$('#icms' + id).val(limit_perc);
			alert("Valor não pode ser maior que 100%");
			return;
		}
	})

	$('.ipi').on('keyup', function() {
		var id = $(this).attr('id_registro');
		if ($('#ipi' + id).val().length > limit_length) {
			$('#ipi' + id).val();
			alert("Não deve possuir mais que 2 casas após a virgula!");
			return;
		}

		if ($('#ipi' + id).val().replace(',', '.') > limit_perc) {
			$('#ipi' + id).val(limit_perc);
			alert("Valor não pode ser maior que 100%");
			return;
		}
	})
//Mask para adicionar zeros a direita ----------------------------------------------------------
	$('.ipi').on('focusout', function() {
		var id = $(this).attr('id_registro');
		if ($('#ipi' + id).val().length < 3 && $('#ipi' + id).val() != '') {
			valorIpi = parseFloat($('#ipi' + id).val()).toFixed(2).replace('.', ',');
			$('#ipi' + id).val(valorIpi);
		}
	})

	$('.icms').on('focusout', function() {
		var id = $(this).attr('id_registro');
		if ($('#icms' + id).val().length < 3 && $('#icms' + id).val() != '') {
			valorIcms = parseFloat($('#icms' + id).val()).toFixed(2).replace('.', ',');
			$('#icms' + id).val(valorIcms);
		}
	})
});