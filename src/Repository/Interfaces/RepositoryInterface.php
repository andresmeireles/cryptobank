<?php

namespace Cryptocli\Repository\Interfaces;

/**
 * @template T as object
 */
interface RepositoryInterface
{
    /**
     * @param int $id
     * @return T|null
     */
    public function find(int $id);

    /**
     * @param T $object
     * @return T
     */
    public function create($object);
}