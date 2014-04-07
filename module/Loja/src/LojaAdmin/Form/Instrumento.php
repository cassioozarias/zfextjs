<?php

namespace LojaAdmin\Form;

use Zend\Form\Form,
    Zend\Form\Element\Select;

class Instrumento extends Form {
    
    protected $categorias;

    public function __construct($name = null, array $categorias = null) {
        parent::__construct('instrumento');
        $this->categorias  = $categorias;

        $this->setAttribute('method', 'post');
//       $this->setInputFilter(new InstrumentoFilter);

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
                'placeholder' => 'Entre com o nome'
            )
        ));
        
        $categoria = new Select();
        $categoria->setLabel("Categoria")
                ->setName("categoria")
                ->setOptions(array('value_options' => $this->categorias)
        );
        $this->add($categoria);

        $this->add(array(
            'name' => 'marca',
            'options' => array(
                'type' => 'text',
                'label' => 'Marca' 
            ),
            'attributes' => array(
                'id' => 'marca',
                'placeholder' => 'Entre com o marca'
            ),
        ));
       
        $this->add(array(
            'name' => 'valor',
            'options' => array(
                'type' => 'text',
                'label' => 'Valor'
            ),
            'attributes' => array(
                'id' => 'valor',
                'placeholder' => 'Entre com o Valor'
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
