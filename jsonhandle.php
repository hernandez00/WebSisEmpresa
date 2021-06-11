<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
	$hashcode = $_POST['hashcode'];
	header('Location: /websisempresa/?idreq=' . $hashcode);
?>

<?php
$n = 0;
$caminho         = $_POST['caminho'];
$situacao        = $_POST['situacao'];

$nome_vendedor   = $_POST['nome-vendedor'];
$email_vendedor  = $_POST['email-vendedor'];
$fone_vendedor   = $_POST['fone-vendedor'];

$tipo_entrega    = $_POST['tipo-entrega'];
$forma_pagamento = $_POST['forma-pagamento'];

$obs_geral       = $_POST['observacao-geral'];

//Percorre toda a variavel dentro do $_POST para salvar os dados em array
for ($n=0; $n < sizeof($_POST['valunit']); $n++) { 
	$dados[$n] = array (
		'nItem'         => $_POST['nItem'][$n],
		'precounitario' => $_POST['valunit'][$n],
		'totalitem'     => $_POST['totalitem'][$n],
		'icms'          => $_POST['icms'][$n],
		'ipi'           => $_POST['ipi'][$n],
		'prazoentrega'  => $_POST['prazoentrega'][$n],
		'observacao'    => $_POST['observacao'][$n]
	);
}

//Busca o arquivo json
$jsonString = file_get_contents($caminho);
$data = json_decode($jsonString, true); 

//Percorre o array $dados para preencher o json
for ($n=0; $n < sizeof($data['itens']); $n++) { 
	$data['itens'][$n]['precoUnitario'] = $dados[$n]['precounitario'];
	$data['itens'][$n]['valorItem']     = $dados[$n]['totalitem'];
	$data['itens'][$n]['pICMS']         = $dados[$n]['icms'];
	$data['itens'][$n]['pIPI']          = $dados[$n]['ipi'];
	$data['itens'][$n]['prazoEntrega']  = $dados[$n]['prazoentrega'];
	$data['itens'][$n]['obs']           = $dados[$n]['observacao'];
}

$data['fornecedor']['vendedor'] = $nome_vendedor;
$data['fornecedor']['emailVendedor'] = $email_vendedor;
$data['fornecedor']['foneVendedor'] = $fone_vendedor;

$data['tipoEntrega'] = $tipo_entrega;
$data['formaPagamento'] = $forma_pagamento;
$data['obsGeral'] = $obs_geral;

if ($situacao == 1) {
	$data['situacao'] = 'Concluído';	
} elseif ($situacao == 2) {
	$data['situacao'] = 'Em andamento';
}

$novojson = json_encode($data);

file_put_contents($caminho, $novojson);
?>