<?php

namespace App\Traits;

trait VisibilityTrait
{
    public function visible(array $ids, $visible = true)
    {
        $this->_em->createQuery('UPDATE ' . $this->_entityName . ' Entity SET Entity.visible = :visible WHERE Entity.id IN (:ids)')
                    ->setParameter('ids', $ids)
                    ->setParameter('visible', $visible)
                    ->getResult();
        $this->_em->flush();
    }
}