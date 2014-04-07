<?php

namespace Loja\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="categorias")
 * @ORM\Entity(repositoryClass="Loja\Entity\CategoriaRepository")
 */
class Categoria {
    
    public function __construct($options = null) {
           Configurator::configure($this,$options);
           $this->instrumentos = new ArrayCollection();
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $nome;
    
    /**
     *
     *@ORM\OneToMany(targetEntity="Loja\Entity\Instrumento", mappedBy="categoria")
     */
    
    protected $instrumentos;
    
    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function __toString() {
        return $this->nome;
    }
    
    public function getinstrumentos() {
        return $this->instrumentos;
    }

    public function toArray() {
        return array('id' => $this->getId(), 'nome' => $this->getNome());
    }

}
