<?php
namespace Jose\GenericDao;

/**
 * It's library! Abstract and standardize the use of the PDO class in the context of MySql DBMS
 * 
 * @author José Martins <j.msantos.netto@gmail.com>
 *
 */
final class GenericDao implements IGenericDao
{
    
    /**
     * Variable defines the table used in queries.
     * 
     * @var string
     */
    private $tableInUse;
    
    /**
     * Variable defines which name will be used to primary key column.
     * 
     * @var string
     */
    private $primaryKeyName;
    
    /**
     * Stores the last query used.
     * 
     * @var string
     */
    private $lastQuery;
    
    /**
     * Defines if primary key is string or not
     * Used in some methods.
     * 
     * @var bool
     */
    private $primaryKeyValueIsString;
    
    public function __construct(string $tableInUse, string $primaryKeyName = 'id', $primaryKeyValueIsString = false)
    {
        $this->tableInUse = $tableInUse;
        $this->primaryKeyName = $primaryKeyName;
        $this->primaryKeyValueIsString = $primaryKeyValueIsString;
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::getItem()
     */
    public function getItem(string $primaryKeyValue): array
    {
        $item = array();
        
        if ($this->primaryKeyValueIsString) {
            $sql = "SELECT * FROM $this->tableInUse WHERE $this->primaryKeyName = '$primaryKeyValue'";
        } else {
            $sql = "SELECT * FROM $this->tableInUse WHERE $this->primaryKeyName = $primaryKeyValue";
        }
        
        $this->lastQuery = $sql;
        
        $sql = DBConnect::getConnection()->query($sql);
        
        if ($sql->rowCount() > 0) {
            $item = $sql->fetch();
        }
        
        return $item;
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::getItems()
     */
    public function getItems($limit = '', $orderBy = '', $order = ''): array
    {
        if(!empty($limit))
        {
            $limit = 'LIMIT ' . $limit;
        }
        
        if(!empty($orderBy))
        {
            $orderBy = 'ORDER BY ' . $orderBy;
        }
        
        $items = array();
        $sql = "SELECT * FROM $this->tableInUse $orderBy $order $limit";
        
        $this->lastQuery = $sql;
        
        $sql = DBConnect::getConnection()->query($sql);
        
        if ($sql->rowCount() > 0) {
            $items = $sql->fetchAll();
        }
        
        return $items;
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::getItemsLike()
     */
    public function getItemsLike(string $search, array $filds): array
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
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::addItem()
     */
    public function addItem(array $item): void
    {
        $sql = "INSERT INTO $this->tableInUse SET";
        $data = array();
        
        foreach ($item as $key => $value) {
            $data[] = " " . $key . " = '" . $value . "'";
        }
        
        $sql = $sql . implode(',', $data);
        
        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::updateItem()
     */
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
        
        if ($this->primaryKeyValueIsString) {
            $sql = $sql . " WHERE $this->primaryKeyName = '" . $primaryKeyValue . "'";
        } else {
            $sql = $sql . " WHERE $this->primaryKeyName = " . $primaryKeyValue;
        }
        
        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::removeItem()
     */
    public function removeItem(string $primaryKeyValue): void
    {
        $sql = "DELETE FROM $this->tableInUse WHERE $this->primaryKeyName = $primaryKeyValue";
        
        $this->lastQuery = $sql;
        DBConnect::getConnection()->query($sql);
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::getNextId()
     */
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
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::getLastQuery()
     */
    public function getLastQuery(): string
    {
        return $this->lastQuery;
    }
    
    /**
     * {@inheritDoc}
     * @see \Jose\GenericDao\IGenericDao::query()
     */
    public function query(string $query, bool $isFetch = false): array
    {
        $result = array();
        
        $this->lastQuery = $query;
        $query = DBConnect::getConnection()->query($query);
        
        if (! $isFetch) {
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll();
            }
        }
        
        return $result;
    }
}
