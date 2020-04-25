<?php


namespace App\DataMapper;


use App\Entity\EntityInterface;
use App\Model\ModelInterface;

interface DataMapperInterface
{
    public function entityToModel(EntityInterface $entity);

    public function modelToEntity(ModelInterface $model, EntityInterface $entity);
}