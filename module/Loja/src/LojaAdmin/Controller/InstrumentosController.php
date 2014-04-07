<?php

namespace LojaAdmin\Controller;

use Zend\View\Model\ViewModel;

class InstrumentosController extends CrudController {

    public function __construct() {
        $this->entity = "Loja\Entity\Instrumento";
        $this->form = "LojaAdmin\Form\Instrumento";
        $this->service = "Loja\Service\Instrumento";
        $this->controller = "instrumentos";
        $this->route = "loja-admin";
    }

    public function newAction() {
        $form = $this->getServiceLocator()->get($this->form);


        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->insert($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel(array('form' => $form));
    }

    public function editAction() {
        $form = $this->getServiceLocator()->get($this->form);
        $request = $this->getRequest();

        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id', 0));

        if ($this->params()->fromRoute('id', 0))
            $form->setData($entity->toArray());

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $service = $this->getServiceLocator()->get($this->service);
                $service->update($request->getPost()->toArray());

                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller));
            }
        }

        return new ViewModel(array('form' => $form));
    }

}
