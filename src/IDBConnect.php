<?php
namespace GenericDaoLib;

interface IDBConnect
{
    static function connect(): void;
    static function getConnection();
}
