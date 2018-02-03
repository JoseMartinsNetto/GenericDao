<?php
interface IDBConnect{    
    static function verifyConection(array $dbConection, string $font): bool;
    static function connect();
}