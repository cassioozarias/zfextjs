<?php

namespace  MoodController\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

class CursoController extends AbstractRestfulController
{
    public function getList()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $entity = $em->getRepository('SONCursos\Entity\Curso')->findAll();

        return $entity;
    }

    /**
     * Return single resource
     *
     * @param mixed $id
     * @return mixed
     */
    public function get($id)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $entity = $em->getRepository('SONCursos\Entity\Curso')->find($id);

        if($entity) {
            return $entity;
        }

        $this->getResponse()->setStatusCode(404);
        return $this->getResponse();
    }

    /**
     * Create a new resource
     *
     * @param mixed $data
     * @return mixed
     */
    public function create($data)
    {
        /** @var  $serviceCurso   \SONCursos\Service\Curso */
        $serviceCurso = $this->getServiceLocator()->get('SONCursos\Service\Curso');
        $curso = $serviceCurso->save($data);

        if ($curso) {
            return $curso;
        } else {
            return ['error'=>'Erro durante a inclusão'];
        }

    }

    /**
     * Update an existing resource
     *
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     */
    public function update($id, $data)
    {
        /** @var  $serviceCurso   \SONCursos\Service\Curso */
        $serviceCurso = $this->getServiceLocator()->get('SONCursos\Service\Curso');
        $data['id'] = $id;

        $curso = $serviceCurso->save($data);

        if ($curso) {
            return $curso;
        } else {
            return ['error'=>'Erro durante a alteração'];
        }
    }

    /**
     * Delete an existing resource
     *
     * @param  mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $entity = $em->getReference('SONCursos\Entity\Curso',$id);

        $em->remove($entity);
        $em->flush();

        return ['success'=>true];
    }
}
