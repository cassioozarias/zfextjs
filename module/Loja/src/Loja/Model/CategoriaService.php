<?php

namespace Loja\Model;

class CategoriaService {

    /**
     * @var Loja\Model\CategoriaTable
     */
    protected $categoriaTable;
    
    public function __construct(CategoriaTable $table) {
        $this->categoriaTable = $table;
    }
    
    public function fetchAll() {
        $resultSet = $this->categoriaTable->select();
        return $resultSet;
    }
    
}
