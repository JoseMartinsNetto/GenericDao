<?php
class GenericDao
{
    private $db;
    private $tableInUse;
    private $dbName;
    private $dsn;
    private $dbUser;
    private $dbPass;
    private $dbDefaltName;
    private $dbHasError;
    private $msgsDB;
    private $lastQuery;
    private $dbConfig;

    public function __construct(string $tableInUse, string $dbName = '')
    {
        global $dbConfig;
        $this->dbConfig = $dbConfig;
        $this->tableInUse = $tableInUse;
        $this->dbDefaltName = $this->dbConfig['dbName'];
        $this->dbHasError = 'no';
        $this->msgsDB = array();

        if (!empty($dbName)) {
            $this->dbName = $dbName;
        } else {
            $this->dbName = $this->dbDefaltName;
        }

        $this->dsn = 'mysql:host=' . $this->dbConfig['dbHost'] . ';dbname=' . $this->dbName;
        $this->dbUser = $this->dbConfig['dbUser'];
        $this->dbPass = $this->dbConfig['dbPass'];

        $this->addMsgDB("O nome da base de dados é: " . $this->dbName);

        try {
            $this->db = new PDO($this->dsn, $this->dbUser, $this->dbPass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->addMsgDB('Base de dados funcionando');
        } catch (PDOException $e) {
            $this->dbHasError = 'yes';

            $this->addMsgDB("Não foi possivel conectar a base de dados, Erro: " . $e);
            exit;
            die();
        }
    }

    private function addMsgDB(string $msg) : void
    {
        array_push($this->msgsDB, $msg);
    }

    public function showMsgDb(string $isShowMsgDb = 'no') : void
    {
        $prefix = "Msg de DAOSuperClass :>> ";

        if ($isShowMsgDb === 'yes' && $this->dbHasError = 'no') {
            foreach ($this->msgsDB as $msg) {
                echo "<pre>" . $prefix . $msg . "!</pre>";
            }
        }

        if ($this->dbHasError === 'yes') {
            echo "<pre>" . $prefix . $msg . "!</pre>";
        }
    }

    public function getItem(int $id) : array
    {
        $item = array();
        $sql = "SELECT * FROM $this->tableInUse WHERE id = $id";

        $this->lastQuery = $sql;
        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $item = $sql->fetch();
            $this->addMsgDB("DADOS OBTIDOS de item da tabela: " . $this->tableInUse);
        } else {
            $this->addMsgDB("NENHUM DADO OBTIDO de item da tabela: " . $this->tableInUse);
        }

        return $item;
    }

    public function getItems() : array
    {
        $items = array();
        $sql = "SELECT * FROM $this->tableInUse";

        $sql = $this->db->query($sql);

        if ($sql->rowCount() > 0) {
            $items = $sql->fetchAll();
            $this->addMsgDB('FORAM encontrados no total de ' . $sql->rowCount() . ' registro(s) na tabela ' . $this->tableInUse);
        } else {
            $this->addMsgDB('NÃO FORAM encontrados registros na tabela ' . $this->tableInUse);
        }

        return $items;
    }

    public function getItemsLike(string $search, array $filds) : array
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

    public function addItem(array $item) : void
    {
        $sql = "INSERT INTO $this->tableInUse SET";
        $data = array();

        foreach ($item as $key => $value) {
            $data[] = " " . $key . " = '" . $value . "'";
        }

        $sql = $sql . implode(',', $data);

        $this->lastQuery = $sql;
        $this->db->query($sql);
        $this->addMsgDB("DADOS de item ADICIONADOS na tabela: " . $this->tableInUse);
    }

    public function updateItem(array $item) : void
    {
        $id = $item['id'];

        unset($item['id']);

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

        $sql = $sql . " WHERE id = " . $id;

        $this->lastQuery = $sql;
        $this->db->query($sql);
        $this->addMsgDB("DADOS de item ALTERADOS na tabela: " . $this->tableInUse);
    }

    public function removeItem(string $id) : void
    {
        $sql = "DELETE FROM $this->tableInUse WHERE id = $id";

        $this->lastQuery = $sql;
        $this->db->query($sql);
        $this->addMsgDB("DADOS de item REMOVIDOS DAS tabela: " . $this->tableInUse);
    }

    public function getNextId() : string
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

    public function getLastQuery() : string
    {
        return $this->lastQuery;
    }

    public static function query(array $dbConection, string $query) : array
    {
        if (isset($dbConection['dbHost']) && !empty($dbConection['dbHost'])) {
            $dbHost = $dbConection['dbHost'];
        }else{
            echo "Você deve informar corretamente o nome da base de dados chave = { dbHost } e valor correspondente!";
            exit;
            die();
        }

        if (isset($dbConection['dbName']) && !empty($dbConection['dbName'])) {
            $dbName = $dbConection['dbName'];
        } else {
            echo "Você deve informar corretamente o nome da base de dados chave = { dbName } e valor correspondente!";
            exit;
            die();
        }

        if (isset($dbConection['dbUser']) && !empty($dbConection['dbUser'])) {
            $dbUser = $dbConection['dbUser'];
        } else {
            echo "Você deve informar corretamente o usuário da base de dados chave = { dbUser } e valor correspondente!";
            exit;
            die();
        }

        if (isset($dbConection['dbPass'])) {
            $dbPass = $dbConection['dbPass'];
        } else {
            echo "Você deve informar corretamente a senha da base de dados chave = { dbPass } e valor correspondente!";
            exit;
            die();
        }

        if (empty($query)) {
            echo "Você deve informar corretamente a sua query, no 2º parâmetro! deste método foda!";
            exit;
            die();
        }

        $dsn = "mysql:host=".$dbConection['dbHost'].";dbname=" . $dbName;

        try {
            $db = new PDO($dsn, $dbUser, $dbPass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erro no momento da conexão usado método estático (makeTable), Causa:>> " . $e;
            exit;
            die();
        }

        $result = array();

        $query = $query;

        $query = $db->query($query);

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll();
        }

        return $result;
    }

}
