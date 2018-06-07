<?php
namespace GenericDaoLib;

/**
 * @author José Martins <j.msantos.netto@gmail.com>
 *
 */
interface IGenericDao
{
    /**
     * @param string $primaryKeyValue
     * @return array
     */
    function getItem(string $primaryKeyValue): array;
    
    /**
     * @return array
     */
    function getItems(): array;
    
    /**
     * @param string $search
     * @param array $filds
     * @return array
     */
    function getItemsLike(string $search, array $filds): array;
    
    /**
     * @param array $item
     */
    function addItem(array $item): void;
    
    /**
     * @param array $item
     */
    function updateItem(array $item): void;
    
    /**
     * @param string $primaryKeyValue
     */
    function removeItem(string $primaryKeyValue): void;
    
    /**
     * @return string
     */
    function getNextId(): string;
    
    /**
     * @return string
     */
    function getLastQuery(): string;
    
    /**
     * @param string $query
     * @return array
     */
    function query(string $query): array;
}
