# GenericDao
Biblioteca para acesso ao banco de dados MySQL baseado na classe PDO em PHP!

### 1 - Uso básico

Para usar a biblioteca você precisará apenas de um arquivo onde esteja definido os dados de acesso 
para o seu banco de dados em uma variável global exemplo:

	<?php

	global $dbConfig;
	$dbConfig = array();

	$dbConfig['dbName'] = '********';
	$dbConfig['dbHost'] = '********';
	$dbConfig['dbUser'] = '********';
	$dbConfig['dbPass'] = '********';

junto ao repositório já contem um arquivo de exemplo importado junto a classe para facilitar a integração.

Depois de definido as configurações de acesso ao banco, você pode instanciar a classe  
passando como argumento obrigatório a tabela em que irá ter acesso no momento:

	$myDb = new GenericDao('myTable');

O construtor também conta com mais dois parametros opcionais que são $pkName(primary Key da tabela) e $dbName nome da base de dados caso trabalhe com mais de um banco de dados com a mesma conexão.
**CASO SE ESSES PARÂMETROS NÃO FOREM INFORMADOS SERÁ USADO COMO PADRÃO PARA $pkName o valor 'id' E PARA O $dbName O VALOR $dbConfig['dbName'] = 'MyDbNameExemple' DEFINIDO NO ARQUIVO DE CONFIGURAÇÃO config.genericDao.php.**

Dessa forma, para se instanciar a classe, ficaria dessa forma:

	$myDb = new GenericDao('myTable', 'myPkName', 'myAnotherDb');

### 2 -  Métodos de persistencia

[Obtendo itens](docs/obtendo-itens.md)  
[Atualizando dados](docs/atualizando-itens.md)  
[Deletando dados](docs/deletando-itens.md)  


**RESTANTE DA DOCUMENTAÇÃO AINDA EM PRODUÇÃO...**