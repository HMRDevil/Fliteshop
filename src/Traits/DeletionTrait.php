<?php

namespace App\Traits;

trait DeletionTrait
{
    public function delete(array $ids)
    {
        foreach ($ids as $id)
        {
            $this->_em->createQuery('DELETE ' . $this->_entityName . ' Entity WHERE Entity.id = :id')
                    ->setParameter('id', $id)
                    ->getResult();
            $this->_em->flush();
        }
    }
}