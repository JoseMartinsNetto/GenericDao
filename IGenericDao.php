<?php
interface IGenericDao{
    static function query(string $query): PDOStatement;
    function getItem(int $primaryKeyValue): PDOStatement;
}