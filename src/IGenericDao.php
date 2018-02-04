<?php
namespace GenericDaoLib;

interface IGenericDao
{
    function getItem($primaryKeyValue): array;
    function getItems(): array;
    function getItemsLike($search, array $filds): array;
    function addItem(array $item): void;
    function updateItem(array $item): void;
    function removeItem($primaryKeyValue): void;
    function getNextId(): string;
    function getLastQuery(): string;
    function query(string $query): array;
}
