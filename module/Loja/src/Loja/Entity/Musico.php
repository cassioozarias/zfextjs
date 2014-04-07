<?php

namespace Loja\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="musicos")
 * @ORM\Entity(repositoryClass="Loja\Entity\MusicoRepository")
 */
class Musico {

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
     * @var
     */
    protected $nome;

    /**
     * @ORM\ManyToOne(targetEntity="Loja\Entity\Categoria", inversedBy="musicos")
     * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")     
     */
    protected $categoria;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    protected $cpf;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
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

    public function getCpf() {
        return $this->cpf;
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

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function toArray() {
        return array(
            'id'       => $this->getId(),
            'nome'     => $this->getNome(),
            'cpf'      => $this->getCpf(),
            'categoria'=> $this->getCategoria()->getId()
        );
    }

}
