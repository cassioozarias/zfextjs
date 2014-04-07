<?php

namespace Loja\Service;

use Doctrine\ORM\EntityManager; 
use Loja\Entity\Configurator;

class Instrumento extends AbstractService {
   
    public function __construct(EntityManager $em) {
        parent::__construct($em);
        $this->entity = "Loja\Entity\Instrumento";
    }
    public function insert(array $data) {
        $entity = new $this->entity($data);
        
        $categoria = $this->em->getReference("Loja\Entity\Categoria" , $data['categoria']);       
        $entity->setCategoria($categoria);
        
        $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
    }
    
    public function update(array $data) {
      $entity = $this->em->getReference($this->entity, $data['id']);
      $entity = configurator::configure($entity,$data);
      
       $categoria = $this->em->getReference("Loja\Entity\Categoria" , $data['categoria']);       
       $entity->setCategoria($categoria);
       
       $this->em->persist($entity);
        $this->em->flush();
        
        return $entity;
  }
}