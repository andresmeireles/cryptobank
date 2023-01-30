<?php

namespace CryptoBank\Repository;

use CryptoBank\Exception\ItemNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * @template T of object
 * @extends EntityRepository<T>
 */
abstract class Repository extends EntityRepository
{
    /**
    * @psalm-param class-string<T> $className
    */ 
    public function __construct(EntityManagerInterface $em, string $className)
    {
        $classMetadata = $em->getClassMetadata($className);
        parent::__construct($em, $classMetadata);
    }

    /**
     * @return T
     * @throws ItemNotFoundException
     */
    public function getById(int $id)
    {
        $item = $this->find($id);
        if ($item === null) {
            throw new ItemNotFoundException();
        }
        return $item;
    }

    /**
     * @param T $item
     * @return T
     */
    public function create($item)
    {
        $this->_em->persist($item);
        $this->_em->flush();
        return $item;
    }

    /**
     * @return T
     * @throws ItemNotFoundException
     */
    public function removeById(int $id)
    {
        $toRemoveItem = $this->getById($id);
        $this->_em->remove($toRemoveItem);
        $this->_em->flush();
        return $toRemoveItem;
    }

    /**
     * @param T $item
     * @return T
     */
    public function update($item)
    {
        $this->_em->flush();
        return $item;
    }
}
