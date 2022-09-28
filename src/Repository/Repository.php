<?php

declare(strict_types=1);

namespace Cryptocli\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template T as object
 * @extends EntityRepository<T>
 */
class Repository extends EntityRepository
{
    /**
     * @param class-string<T> $class
     */
    public function __construct(EntityManagerInterface $em, $class)
    {
        $classMetadate = $em->getClassMetadata($class);
        parent::__construct($em, $classMetadate);
    }

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

    /**
     * @param T $object
     * @throws \InvalidArgumentException
     * @return T
     */
    public function update($object)
    {
        if ($object->getId() === null) {
            throw new \InvalidArgumentException('non saved object cannot be update');
        }

        $this->_em->flush();

        return $object;
    }
}