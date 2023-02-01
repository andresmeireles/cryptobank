<?php

namespace CryptoBank\Repository\Api;

use CryptoBank\Exception\ItemNotFoundException;

/**
 * @template T of object
 */
interface RepositoryInterface
{

    /**
     * @param  $id 
     * @return T|null
     */
    public function find(int $id);

    /**
     * @param int $id
     * @return T
     * @throws ItemNotFoundException
     */
    public function getById(int $id);

    /**
     * @param T $item
     * @return T
     */
    public function create($item);

    /**
     * @param T $item
     * @return T
     */
    public function update($item);

    /**
     * @param int $id
     * @return T
     */
    public function removeById(int $id);
}
