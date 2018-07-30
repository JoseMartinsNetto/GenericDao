# GenericDao

Biblioteca para acesso ao banco de dados MySQL baseado na classe PDO em PHP!
Library for access to the MySQL database based on the PDO class in PHP!

[English documents!](https://github.com/jmsantosnetto/GenericDao/blob/master/docs-en/Readme.md)

### 1 - Uso básico
**Espero que esteja utilizando o padrão de autoload psr-4, pois é uma exigência para usar essa biblioteca.**
Para usar a biblioteca você precisará de um arquivo de configuração no formato JSON, seguindo a seguinte estrutura:

	{
		"type": "tipo da conexão pode ser mysql, sqlite...", // por enquanto o tipo suportado é somente mysql
		"name": "nome da base de dados",
		"host": "host de conexão ex: localhost",
		"user": "usuário da base de dados ex: root",
		"password": "senha da base de dados"
	}

Junto ao repositório existe um arquivo de exemplo chamado DBConfigExemple.json, você pode usá-lo como referência.
Agora precisamos configurar este arquivo em algum lugar!
O local em questão não importa, contando que importe a Classe **DBConfig do namespace:  Jose\GenericDao\DBConfig** usando o méetodo estático **setConfigFile()**, passando como parâmetro a localização do arquivo ex:	

	<?php
	//importando a classe de configuração
	use Jose\GenericDao\DBConfig;
	
	DBConfig::setConfigFile(__DIR__ . 'DBConfig.json');

Feito isso agora basta importar a classe principal **GenericDao** e passar no construtor uma string com o nome da tabela que será usado no momento ex:

	<?php
	//importando a classe principal
	use Jose\GenericDao\GenericDao;
	
	$tableDao = new GenericDao('myTable');

O construtor também conta com dois parâmetros adicionais: o primeiro é uma **string $primaryKeyName** que conta com o valor padrão **'id'** (aqui fica o nome do campo que você definiu como PRIMARY KEY na construção da tabela), e um **bool $primaryKeyValueIsString** com o valor padrão **false** (aqui você define se o valor da chave primária é uma string ou não) ex:

	<?php
	//importando a classe principal
	use Jose\GenericDao\GenericDao;
	
	$tableDao = new GenericDao('myTable', 'myCustomPK', true);

Dada a explicação inicial segue abaixo o restante da documentação nas seguintes seções:

[2- Obtendo dados](https://github.com/jmsantosnetto/GenericDao/blob/master/docs-pt/obtendo-dados.md)  
[3- Gravando dados](https://github.com/jmsantosnetto/GenericDao/blob/master/docs-pt/gravando-dados.md)  
[4- Excluindo dados](https://github.com/jmsantosnetto/GenericDao/blob/master/docs-pt/excluindo-dados.md)