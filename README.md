# WebSisEmpresa
Repositório do sistema web  - EMPRESA

Mini sistema web para cotações. 

O que foi utilizado em seu desenvolvimento?
- PHP;
- HTML e CSS para criação da página e estilização;
- JavaScript(jQuery).

Como funciona?
 - Através do sistema desktop da empresa, é gerado um arquivo jSon estruturado com informações da empresa e os produtos à serem cotados com suas medidas e quantidade, que é enviado via FPT para o servidor onde o sistema web está hospedado;
 - Ao gerar, o funcionário verá um link semelhante a este: empresa.ind.br/websisempresa/?idreq=67863738000153_2980. Link do site + MD5 gerado à partir do cnpj da empresa + número da cotação;
 - O link poderá ser enviado automaticamente para o fornecedor ou o funcionario responsável poderá copiá-lo e enviar manualmente.
