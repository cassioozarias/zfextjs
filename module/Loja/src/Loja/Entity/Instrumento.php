<?php

namespace Loja\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instrumentos")
 * @ORM\Entity(repositoryClass="Loja\Entity\InstrumentoRepository")
 */
class Instrumento {
    
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */

    protected $id;
    /**
     *
     * @ORM\Column(type="text")
     * @var string
     */
    
    protected $nome;
    
    /**
     *@ORM\ManyToOne(targetEntity="Loja\Entity\Categoria", inversedBy="instrumentos")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
     */
    
    protected $categoria;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $marca;
    
    /**
     *@ORM\Column(type="text")
     *@var string
     */
    
    protected $valor;
    
    
    
    public function __construct($options = null) {
        Configurator::configure($this, $options);
    }
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getMarca() {
        return $this->marca;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public function setMarca($marca) {
        $this->marca = $marca;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
    
    public function toArray() {
        return array(
          'id'        => $this->getId(),
          'nome'      => $this->getNome(),  
          'marca'     => $this->getMarca(),
          'valor'     => $this->getValor(),
          'categoria' => $this->getCategoria()->getId()
        );
    }
}