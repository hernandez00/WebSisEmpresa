$(document).ready(function() {
	//Máscara em forma de função para possibilitar o 9 digito de celular ou telefone fixo.
	var SPMaskMod = function (val) {
	  return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
	},	spOptions = {
	  		onKeyPress: function(val, e, field, options) {
	     	field.mask(SPMaskMod.apply({}, arguments), options);
	    }
	};

	$('.valores').mask("000.000.000.000.000,0000", {reverse: true});
	$('.quantidade').mask("000.000.000.000.000,000", {reverse: true});
	$('.totalitem').mask("000.000.000.000.000,00", {reverse: true});
	$('.icms').mask("000,00", {reverse: true});
	$('.ipi').mask("000,00", {reverse: true});
	$('#soma-total').mask("000.000.000.000.000,00", {reverse: true});
	$('#fone-vendedor').mask(SPMaskMod, spOptions);
});