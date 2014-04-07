<?php

namespace Loja\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {

    public function indexAction(){
        $em    = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $repo  = $em->getRepository('Loja\Entity\Categoria');
        
        $categorias = $repo->findAll();
    
        /** Zend\DB
         $categoriaService = $this->getServiceLocator()->get("Loja\Model\CategoriaService");
         $cateoria = $categoriaService->fetchAll();
         */
        return new ViewModel(Array('categorias' => $categorias));
    }
}
