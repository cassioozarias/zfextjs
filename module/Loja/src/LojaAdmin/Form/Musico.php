<?php

namespace LojaAdmin\Form;

use Zend\Form\Form,
    Zend\Form\Element\Select;

class Musico extends Form {
    
    protected $categorias;

    public function __construct($name = null, array $categorias = null) {
        parent::__construct('musico');
        $this->categorias  = $categorias;

        $this->setAttribute('method', 'post');
//       $this->setInputFilter(new MusicoFilter);

        $this->add(array(
            'name' => 'id',
            'attibutes' => array(
                'type' => 'hidden'
            )
        ));

        $this->add(array(
            'name' => 'nome',
            'options' => array(
                'type' => 'text',
                'label' => 'Nome'
            ),
            'attributes' => array(
                'id' => 'nome',
                'placeholder' => 'Digite seu nome'
            )
        ));
        
        $categoria = new Select();
        $categoria->setLabel("Categoria")
                ->setName("categoria")
                ->setOptions(array('value_options' => $this->categorias)
        );
        $this->add($categoria);

        $this->add(array(
            'name' => 'cpf',
            'options' => array(
                'type' => 'text',
                'label' => 'CPF' 
            ),
            'attributes' => array(
                'id' => 'cpf',
                'placeholder' => 'Entre com CPF'
            ),
        ));
       
                $this->add(array(
            'name' => 'submit',
            'type' => 'Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Salvar',
                'class' => 'btn-success'
            )
        ));
    }

}
