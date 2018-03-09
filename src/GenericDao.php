<?php
<<<<<<< HEAD
namespace GenericDaoLib;

require 'IGenericDao.php';
require 'DBConnect.php';
=======
namespace MVC\Models\GenericDaoLib;
>>>>>>> 4ac6867c48e89085b7f4a7480c2e77d2ae47bfc4

final class GenericDao implements IGenericDao
{
    private $tableInUse;
    private $primaryKeyName;
    private $lastQuery;

    public function __construct(string $tableInUse, string $primaryKeyName = 'id')
    {
        $this->tableInUse = $tableInUse;
        $this->primaryKeyName = $primaryKeyName;
    }

    public function getItem($primaryKeyValue): array
    {
        $item = array();
        $sql = "SELECT * FROM $this->tableInUse WHERE $this->primaryKeyName = $primaryKeyValue";

        $this->lastQuery = $sql;

        $sql = DBConnect::getConnection()->query($sql);

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

        $sql = DBConnect::getConnection()->query($sql);

        if ($sql->rowCount() > 0) {
            $items = $sql->fetchAll();
        }

        return $items;
    }

    public function getItemsLike($search, array $filds): array
    {

        $sql = "SELECT * FROM $this->tableInUse WHERE ";
        $data = array();

        foreach ($filds as $fild) {
            $data[] = $fild . " LIKE '%" . $search . "%'";
        }

        $sql = $sql . implode(' OR ', $data);

        $this->lastQuery = $sql;
        $sql = DBConnect::getConnection()->query($sql);

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

            if (is_string($value)) {
                $data[] = " " . $key . " = '" . $value . "'";
            } else {
                $data[] = " " . $key . " = " . $value . " ";
            }

        }

        $sql = $sql . implode(',', $data);

        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }

    public function updateItem(array $item): void
    {
        $primaryKeyValue = $item[$this->primaryKeyName];

        unset($item[$this->primaryKeyName]);

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

        $sql = $sql . " WHERE $this->primaryKeyName = " . $primaryKeyValue;

        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }

    public function removeItem($primaryKeyValue): void
    {
        $sql = "DELETE FROM $this->tableInUse WHERE $this->primaryKeyName = $primaryKeyValue";

        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }

    public function getNextId(): string
    {
        $sql = "SHOW TABLE STATUS LIKE '$this->tableInUse'";

        $this->lastQuery = $sql;
        $sql = DBConnect::getConnection()->query($sql);

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

    public function query(string $query): array
    {
        $result = array();

        $this->lastQuery = $query;
        $query = DBConnect::getConnection()->query($query);

        if ($query->rowCount() > 0) {
            $result = $query->fetchAll();
        }

        return $result;
    }

}
