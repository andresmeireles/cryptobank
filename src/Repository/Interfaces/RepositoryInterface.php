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
     * @return T[]
     */
    public function findAll();

    /**
     * @param array $criteria
     * @return T[]
     */
    public function findBy(array $criteria);

    /**
     * @param T $object
     * @return T
     */
    public function create($object);
}