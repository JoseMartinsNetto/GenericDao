<?php

final class GenericDao
{
    private $db;
    private $tableInUse;
    private $pkName;
    private $dsn;
    private $lastQuery;
    private $dbConfig;

    public function __construct(string $tableInUse, string $pkName = 'id', string $dbName = '')
    {
        global $dbConfig;
        self::verifyConnection($dbConfig, 'GenericDao->__construct()');
        $this->dbConfig = $dbConfig;
        $this->tableInUse = $tableInUse;
        $this->pkName = $pkName;

        if (!empty($dbName)) {
            $this->dbConfig['dbName'] = $dbName;
        }

        $this->dsn = 'mysql:host=' . $this->dbConfig['dbHost'] . ';dbname=' . $this->dbConfig['dbName'];

        try {
            $this->db = new PDO($this->dsn, $this->dbConfig['dbUser'], $this->dbConfig['dbPass']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            exit("Não foi possivel conectar a base de dados, Erro: " . $e);
        }
    }

    private static function verifyConnection(array $dbConection, string $font): void
    {
        $font = "*!* ".$font." *!*";
        if (!isset($dbConection['dbHost']) && empty($dbConection['dbHost']) || $dbConection['dbHost']=="********") {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o nome da base de dados chave = { dbHost } e valor correspondente!");
        }

        if (!isset($dbConection['dbName']) && empty($dbConection['dbName']) || $dbConection['dbName']=="********") {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o nome da base de dados chave = { dbName } e valor correspondente!");
        }

        if (!isset($dbConection['dbUser']) && empty($dbConection['dbUser']) || $dbConection['dbUser']=="********") {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente o usuário da base de dados chave = { dbUser } e valor correspondente!");
        }

        if (!isset($dbConection['dbPass']) && empty($dbConection['dbPass']) || $dbConection['dbPass']=="********") {
            exit("Erro ao verificar conexão! Fonte: ".$font." Msg:>> Você deve informar corretamente a senha da base de dados chave = { dbPass } e valor correspondente!");
        }
    }

    public function getItem(int $primaryKeyValue): array
    {
        $item = array();
        $sql = "SELECT * FROM $this->tableInUse WHERE $this->pkName = $primaryKeyValue";

        $this->lastQuery = $sql;
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $item = $sql->fetch();
        }

        return $item;
    }

    public function getItems(): array
    {
        $items = array();
        $sql = "SELECT * FROM $this->tableInUse";

        $this->lastQuery = $sql;
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $items = $sql->fetchAll();
        }

        return $items;
    }

    public function getItemsLike(string $search, array $filds): array
    {

        $sql = "SELECT * FROM $this->tableInUse WHERE ";
        $data = array();

        foreach ($filds as $fild) {
            $data[] = $fild . " LIKE '%" . $search . "%'";
        }

        $sql = $sql . implode(' OR ', $data);

        $this->lastQuery = $sql;
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $item = $sql->fetchAll();
        }

        return $item;
    }

    public function addItem(array $item): void
    {
        $sql = "INSERT INTO $this->tableInUse SET";
        $data = array();

        foreach ($item as $key => $value) {
            $data[] = " " . $key . " = '" . $value . "'";
        }

        $sql = $sql . implode(',', $data);

        $this->lastQuery = $sql;
        $this->db->query($sql);
    }

    public function updateItem(array $item): void
    {
        $primaryKeyValue = $item[$this->pkName];

        unset($item[$this->pkName]);

        $sql = "UPDATE $this->tableInUse SET";
        $data = array();

        foreach ($item as $key => $value) {

            if (is_string($value)) {
                $data[] = " " . $key . " = '" . $value . "'";
            } else {
                $data[] = " " . $key . " = " . $value . " ";
            }

        }

        $sql = $sql . implode(',', $data);

        $sql = $sql . " WHERE $this->pkName = " . $primaryKeyValue;

        $this->lastQuery = $sql;
        $this->db->query($sql);
    }

    public function removeItem(string $primaryKeyValue): void
    {
        $sql = "DELETE FROM $this->tableInUse WHERE $this->pkName = $primaryKeyValue";

        $this->lastQuery = $sql;
        $this->db->query($sql);
    }

    public function getNextId(): string
    {
        $sql = "SHOW TABLE STATUS LIKE '$this->tableInUse'";

        $this->lastQuery = $sql;
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $nextId = $sql->fetch();
            $nextId = $nextId['Auto_increment'];
            return $nextId;
        }
    }

    public function getLastQuery(): string
    {
        return $this->lastQuery;
    }

    public static function query(array $dbConection, string $query): array
    {
        self::verifyConnection($dbConection, 'Método estático GenericDao::query(array $dbConection, string $query)');

        $dsn = "mysql:host=" . $dbConection['dbHost'] . ";dbname=" . $dbConection['dbName'];

        try {
            $db = new PDO($dsn, $dbConection['dbUser'], $dbConection['dbPass']);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            exit("Erro no momento da conexão usado método estático (makeTable), Causa:>> " . $e);
        }

        $result = array();

        $query = $db->query($query);

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll();
        }

        return $result;
    }

}
