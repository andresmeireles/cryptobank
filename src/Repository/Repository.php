<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @template T as object
 * @extends EntityRepository<T>
 */
class Repository extends EntityRepository
{
    /**
     * @param T $object
     * @return T
     */
    public function create($object)
    {
        $this->_em->persist($object);
        $this->_em->flush();

        return $object;
    }
}