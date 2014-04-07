<?php

namespace LojaAdmin\Controller;

class CategoriasController extends CrudController {

    public function __construct() {
        $this->entity = "Loja\Entity\Categoria";
        $this->form = "LojaAdmin\Form\Categoria";
        $this->service = "Loja\Service\Categoria";
        $this->controller = "categorias";
        $this->route = "loja-admin";
    }

}
