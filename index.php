<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php include "menu.php"; ?>

<link rel="stylesheet" type="text/css" href="_css/inicio.css">
<link rel="stylesheet" type="text/css" href="_css/modal.css">
<link rel="stylesheet" type="text/css" href="_css/_fontawesome/css/all.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Websis</title>

<script src="_js/_jquery/_plugins/jquery-3.5.1.min.js"></script>
<script src="_js/_jquery/_plugins/mask-plugin-master/src/jquery.mask.js"></script>
<script src="_js/_jquery/loadscreen.js"></script>
<script src="_js/_jquery/calculo.js"></script>
<script src="_js/_jquery/percentual.js"></script>
<script src="_js/_jquery/observacao.js"></script>
<script src="_js/_jquery/txtareadinamico.js"></script>
<script src="_js/_jquery/format.js"></script>
<script src="_js/_jquery/blkenter.js"></script>
<script src="_js/_jquery/modal.js"></script>
<script src="_js/_jquery/basic.js"></script>
<script src="_js/_jquery/form.js"></script>

<!-- CORPO DA PAGINA -->
<body>
<div id="loader" class="loader"></div>
<div id="container">

<?php
$n = 0;
$encontrou = false;
$situacao = "";
$mensagem = 0;
$img = 0;
$arquivo = "";

//Verifica se existe um id de requisição e se ele está correto
if (isset($_GET["idreq"])) {
	$hashcode = $_GET["idreq"];
//	$path = "../../empresa.ind.br/sisitb/";
	$path = "_js/_json/_cotacoes/";
	$diretorio = dir($path);

//Busca o arquivo json através do link inserido na barra
	while ($arquivo = $diretorio -> read())	{
	    if ($hashcode . ".json" == $arquivo) {
	        $arquivo = file_get_contents($path . $hashcode . '.json');
	        $json = json_decode($arquivo);
			$situacao = (property_exists($json, "situacao")) ? (!$json->situacao) ? "" : $json->situacao : "";
	        $encontrou = true;
	    } else {
			$mensagem = 2;
	    }
	}
}

//Verifica se o id está vazio
if(!isset($_GET["idreq"]) || isset($_GET["idreq"]) == '' || $_GET["idreq"] == ''){
	$mensagem = 3;
}

//Verifica se a cotação já foi concluida
if ($encontrou == true && $situacao != "Em andamento") {
	$mensagem = 1;
	$encontrou = false;
}

//Verifica se o prazo de validade expirou
if ($encontrou == true && property_exists($json, "disponivelAte")) {
	$disponivelAte = implode('-', array_reverse(explode('/', $json->disponivelAte)));
	if ($disponivelAte > date("Y-m-d")) {
		$disponivelAte = $json->disponivelAte;
		$encontrou = true;
	} else {
		$mensagem = 4;
		$encontrou = false;
	}
}

//Verifica se a variavel $encontrou é verdadeira e mostra o conteúdo
if ($encontrou == false) {
	switch ($mensagem) {
		case 1:
			$img = "img-concluido";
			$mensagem = "Cotação concluída!";
			break;
		
		case 2:
			$img = "img-naoencontrado";
			$mensagem = "O item não foi localizado!";
			break;

		case 3:
			$img = "img-naoencontrado";
			$mensagem = "Nenhum item inserido!";
			break;

		case 4:
			$img = "img-expirado";
			$mensagem = "O prazo limite expirou!";
			break;			
	}
	echo "
		<div id='div-mensagem-erro' class='alinhamento-div-erro'>
			<img id='img-erro' src='_img/" .$img. ".png' tabindex='-1'>
			<h1 id='msg-erro' align='center'>$mensagem</h1>
		</div>
	";
} else {
	$cotacao  		  = (property_exists($json, "idCotacao")) 					? (!$json->idCotacao) 					? "" : $json->idCotacao : "";
	//Dados EMPRESA
	$cnpj             = (property_exists($json->empresa, "cnpj"))                   ? (!$json->empresa->cnpj)                   ? "" : $json->empresa->cnpj : "";
	$razaoSocial      = (property_exists($json->empresa, "razaoSocial"))            ? (!$json->empresa->razaoSocial)            ? "" : $json->empresa->razaoSocial : "";
	$inscrEstadual    = (property_exists($json->empresa, "inscrEstadual"))          ? (!$json->empresa->inscrEstadual)          ? "" : $json->empresa->inscrEstadual : "";
	//Endereço EMPRESA
	$endereco         = (property_exists($json->empresa->endereco, "endereco"))     ? (!$json->empresa->endereco->endereco)     ? "" : $json->empresa->endereco->endereco : "";
	$numero           = (property_exists($json->empresa->endereco, "numero"))       ? (!$json->empresa->endereco->numero)       ? "" : $json->empresa->endereco->numero : "";
	$bairro           = (property_exists($json->empresa->endereco, "bairro"))       ? (!$json->empresa->endereco->bairro)       ? "" : $json->empresa->endereco->bairro : "";
	$cidadeEstado     = (property_exists($json->empresa->endereco, "cidadeEstado")) ? (!$json->empresa->endereco->cidadeEstado) ? "" : $json->empresa->endereco->cidadeEstado : "";
	$cep              = (property_exists($json->empresa->endereco, "cep"))          ? (!$json->empresa->endereco->cep)          ? "" : $json->empresa->endereco->cep : "";	
	
	//Credenciais comprador
	$comprador        = (property_exists($json->empresa, "comprador"))             ? (!$json->empresa->comprador)              ? "" : $json->empresa->comprador : "";
	$emailItb        = (property_exists($json->empresa, "email"))                  ? (!$json->empresa->email)                  ? "" : $json->empresa->email : "";
	$telefoneItb     = (property_exists($json->empresa, "telefone"))               ? (!$json->empresa->telefone)               ? "" : $json->empresa->telefone : "";
	//Fornecedor
	$cnpjCpf_forn     = (property_exists($json->fornecedor, "cnpjCpf"))        ? (!$json->fornecedor->cnpjCpf)         ? "" : $json->fornecedor->cnpjCpf : "";
	$razaoSocial_forn = (property_exists($json->fornecedor, "razaoSocial"))    ? (!$json->fornecedor->razaoSocial)     ? "" : $json->fornecedor->razaoSocial : "";
	//Credenciais vendedor
	$nomeVendedor    = (property_exists($json->fornecedor, "vendedor"))        ? (!$json->fornecedor->vendedor)        ? "" : $json->fornecedor->vendedor : "";
	$emailVendedor   = (property_exists($json->fornecedor, "emailVendedor"))   ? (!$json->fornecedor->emailVendedor)   ? "" : $json->fornecedor->emailVendedor : "";
	$foneVendedor    = (property_exists($json->fornecedor, "foneVendedor"))    ? (!$json->fornecedor->foneVendedor)    ? "" : $json->fornecedor->foneVendedor : "";
	//Tipo de entrega e forma de pagamento
	$tipoEntrega     = (property_exists($json, "tipoEntrega"))                 ? (!$json->tipoEntrega)            ? "" : $json->tipoEntrega : "";
	$formaPagamento  = (property_exists($json, "formaPagamento"))              ? (!$json->formaPagamento)         ? "" : $json->formaPagamento : "";


//Cabeçalho do container - Dados do funcionário-empresa responsável empresa de destino
	echo "
		<div class='sub-container'>

			<div id='div-cotacao' class='alinhamento-div-info'>
				<p>Nº da cotação: $cotacao</p>
			</div>

			<div id='div-comprador' class='alinhamento-div-info'>
				<table id='comprador' class='alinhamento-texto-info'>
					<tr>
						<th>Comprador:</th>
						<td>$comprador</td>
					</tr>
					<tr>
						<th>E-mail:</th>
						<td>$emailItb</td>
					</tr>
					<tr>
						<th>Telefone:</th>
						<td>$telefoneItb</td>
					</tr>
				</table>
			</div>

			<div id='div-fornecedor' class='alinhamento-div-info'>
				<table id='fornecedor' class='alinhamento-texto-info'>
					<tr>
						<th>Razão social:</th>
						<td>$razaoSocial_forn</td>
					</tr>
					<tr>
						<th>CNPJ/CPF:</th>
						<td>$cnpjCpf_forn</td>
					</tr>
				</table>
			</div>

			<div id='div-situacao' class='alinhamento-div-info'>
				<table id='situacao' class='alinhamento-texto-info'>
					<tr>
						<th>Disponível até:</th>
						<td>$disponivelAte</td>
					</tr>
					<tr>
						<th>Situação:</th>
						<td>$situacao</td>
					</tr>
				</table>
			</div> 
		</div>

		<form method='POST' id='envia_dados' action='jsonhandle.php'>
			<input type='hidden' name='caminho'  id='caminho' value='" . $path . $hashcode .".json'>
			<input type='hidden' name='hashcode' value=" . $hashcode . ">
			<input type='hidden' name='situacao' id='id-situacao'>

		<div class='sub-container'>
			<div id='div-dados-fornecedor' class='alinhamento-div-info'>
				<table id='dados-fornecedor' class='alinhamento-texto-info'>
					<tr>
						<th>Nome:</th>
						<td><input type='text' name='nome-vendedor' tabindex='1' id='nome-vendedor' value='$nomeVendedor'></td>
					</tr>
					<tr>
						<th>E-mail:</th>
						<td><input type='text' name='email-vendedor' tabindex='1' id='email-vendedor' value='$emailVendedor'></td>
					</tr>
					<tr>
						<th>Telefone:</th>
						<td><input type='text' name='fone-vendedor' tabindex='1' id='fone-vendedor' value='$foneVendedor'></td>
					</tr>
				</table>
			</div>

			<div id='div-situacao' class='alinhamento-div-info'>
				<table id='situacao' class='alinhamento-texto-info'>

					<tr>
						<th>Tipo de entrega:</th>
						<td>
							<select name='tipo-entrega' id='tipo-entrega' tabindex='1'>
							  <option value='CIF' selected>CIF</option>
							  <option value='FOB'>FOB</option>
							</select>
						</td>
					</tr>

					<tr>
						<th>Forma de pagamento:</th>
						<td>
							<input type='text' name='forma-pagamento' id='forma-pagamento' tabindex='1' value='$formaPagamento'>
						</td>
					</tr>

					<!-- Apagar
					<tr>
						<th>Prazo de pagamento:</th>
						<td>
							<input type='number' step='1' placeholder='0' name='prazopagamento' id='prazo-pagamento' tabindex='1'>

							<select name='periodo-pagamento' id='periodo-pagamento'>
							  <option value='Dias' selected>Dias</option>
							  <option value='Mêses'>Meses</option>
							</select>
						</td>
					</tr>
					-->

				</table>
			</div>
		</div>

<!-- Cabeçalho de titulos da tabela de itens -->

		<table id='tabela'>
			<tr>
				<th>Item</th>
				<th>Cod. Material</th>
				<th>Descrição</th>
				<th class='numeros'>Quantidade</th>
				<th>Unidade</th>
				<th class='numeros'>Valor unitário</th>
				<th class='numeros'>Total item</th>
				<th class='numeros'>ICMS(%)</th>
				<th class='numeros'>IPI(%)</th>
				<th>Entrega(Dias<span class='obrigatorio'>*</span>)</th>
				<th>Especificação técnica</th>
				<th>Observação</th>
			</tr>
	";

foreach ($json->itens as $key => $value) {
//Verifica se os campos existem no arquivo
	$nItem          = (property_exists($json->itens[$n], "nItem"))          ? (!$value->nItem)          ? "" : $value->nItem : "";
	$codigoMaterial = (property_exists($json->itens[$n], "codigoMaterial")) ? (!$value->codigoMaterial) ? "" : $value->codigoMaterial : "";
	$nomeDescricao  = (property_exists($json->itens[$n], "nomeDescricao"))  ? (!$value->nomeDescricao)  ? "" : $value->nomeDescricao : "";
	$unidade        = (property_exists($json->itens[$n], "unidade"))        ? (!$value->unidade)        ? "" : $value->unidade : "";
	$especTecnica   = (property_exists($json->itens[$n], "especTecnica"))   ? (!$value->especTecnica)   ? "Não há especificação." : $value->especTecnica : "";	
	$qtde           = (property_exists($json->itens[$n], "qtde"))           ? (!$value->qtde)           ? "" : $value->qtde : "";
	$precoUnitario  = (property_exists($json->itens[$n], "precoUnitario"))  ? (!$value->precoUnitario)  ? "" : $value->precoUnitario : "";
	$icms           = (property_exists($json->itens[$n], "pICMS"))          ? (!$value->pICMS)          ? "" : $value->pICMS : "";
	$ipi            = (property_exists($json->itens[$n], "pIPI"))           ? (!$value->pIPI)           ? "" : $value->pIPI : "";	
	$valorItem      = (property_exists($json->itens[$n], "valorItem"))      ? (!$value->valorItem)      ? "" : $value->valorItem : "";
	$prazoEntrega   = (property_exists($json->itens[$n], "prazoEntrega"))   ? (!$value->prazoEntrega)   ? "" : $value->prazoEntrega : "";
	$obs            = (property_exists($json->itens[$n], "obs"))            ? (!$value->obs)            ? "" : $value->obs : "";
//Formatação do campo quantidade
	$qtde = number_format($qtde, 3, ',', '');

	echo "
		<input type='hidden' name=nItem[] id='nitem$n' value='$nItem'>

			           <input type=   'hidden' 
						name=         'totalitem[]'
						class=        'totalitem-input'
						id=    		  'totalitem-input$n'
						id_registro=  '$n'
						value=        ''>
	
		<tr class='linha' id_registro='$n'>

			<td><p 		class=        'nItem'
					    tabindex=     '-1'
					    align=        'center'
					    >$nItem</p>
			</td>

			<td><p      name=         'codmaterial[]'
			            class=        'codmaterial'
					    tabindex=     '-1'
					    >$codigoMaterial</p>
			</td>

			<td><p      name=         'descmaterial[]'
			            class=        'descmaterial'
			            tabindex=     '-1'
			         	>$nomeDescricao</p>
			</td>

			<td><p      name=         'quantidade[]'
			            class=        'quantidade'
			            id=           'quantidade-$n'
			            readonly=     'readonly'
			            tabindex=     '-1'
			            >$qtde</p>
			</td>

			<td><p      name=         'unidade[]'
						class=        'unidade'
						tabindex=     '-1'
						>$unidade</p>
			</td>

			<td class='preencher'><input type='text'
						placeholder=  '0,0000'
						name=         'valunit[]'
						class=        'valores'
						id=           'valunit$n'
			            id_registro=  '$n'
			            tabindex=     '1'
			            value=        '$precoUnitario'>
			</td>

			<td><p		placeholder=  '0,0000'
						class=        'totalitem'
						id=           'totalitem$n'
			            id_registro=  '$n'      
			            >$valorItem</p>
			</td>

			<td class='preencher'><input type='text'
						placeholder=  '0,00'
						name=         'icms[]'
						class=        'icms'
						id=           'icms$n'
						id_registro=  '$n'
						tabindex=     '1'
						value=        '$icms'>
			</td>

			<td class='preencher'><input type='text'
						placeholder=  '0,00'
						name=         'ipi[]'
						class=        'ipi'
						id=           'ipi$n'
			            id_registro=  '$n'
			            tabindex=     '1'
			            value=        '$ipi'>
			</td>

			<td class='preencher'><input type='number'
						step=         '1'
						placeholder=  '0'
				 		name=		  'prazoentrega[]'
				 		class=		  'prazoentrega'
				 		id=			  'prazoentrega$n'
				 		tabindex=	  '1'
				 		value=        '$prazoEntrega'>
			</td>

			<td><p      name=         'espectecnica[]'
			            class=        'espectecnica'
			            tabindex=     '-1'
			         	>$especTecnica</p>
			</td>

			<td>
				<p class=            'abre_observacao'
						id=           'idobservacao$n'
						id_registro=  '$n'
						tabindex=     '-1'>
				</p>
			</td>

		</tr>

			<td colspan='9'>
				<textarea
					name=             'observacao[]'
					class=            'observacao'
					id=               'text_observacao$n'
					id_registro=      '$n'
					tabindex=         '-1'
					placeholder=      'Digite aqui a sua observação...'
					>$obs</textarea>
			</td>
	";
	$n += 1;
}
	echo "
		<tr id='tr-soma-total'>
			<td colspan='6'>
				<p id='titulo-total'>Total</p>
			</td>
			<td id='td-total'>
				<p id='soma-total'>0,00</p>
			</td>
			<td colspan='5'></td>
		</tr>

		<tr id='tr-obs-geral' class='linha'>
			<td colspan='11'>
				<p>Observação geral</p>

				<textarea
				name=             'observacao-geral'
				class=            'observacao'
				id=               'text_observacao_geral'
				tabindex=         '-1'
				placeholder=      'Digite aqui a sua observação...'
				></textarea>
			</td>

			<td>
				<p class=         'abre_observacao'
					id=           'idobservacao_geral'
					tabindex=     '-1'>
				</p>
			</td>
		</tr>
	";
	echo "</table>";

	echo "
		<div id='painel-botoes'>
			<input type='button' id='botao_enviar' tabindex='-1' class='botoes' value='Enviar' tabindex='2'>
			<input type='submit' id='botao_salvar' tabindex='-1' class='botoes' value='Salvar' tabindex='2'>
		</div>
	";
}
?>

</div>
</form>

<?php
	include "footer.php";
?>

<!-- Abrir modal -->
<div class="md-popup" role="alert">
	<div class="md-popup-container">
		<p>Ao enviar não será possivel realizar futuras alterações. Deseja realmente finalizar o formulário?</p>
		<ul class="cd-buttons">
			<li><a id="envia"   href="#0">Enviar</a></li>
			<li><a id="cancela" href="#0">cancelar</a></li>
		</ul>
		<a href="#0" class="md-popup-close img-replace"></a>
	</div>
</div>
</body>