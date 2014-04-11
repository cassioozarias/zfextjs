<?php

require_once 'Db/Base.php';

class Intrumentos extends Base {

    private     $valor = null;
    private     $data = null;
    protected   $table = "instrumentos";
    
    public function insert() {
        
        $data = json_decode($_POST['data']);
        
        $db = $this->getDb();
        $stm = $db->prepare('Insert into ' . $this->getTable() . ' (nome, valor, marca) Values(:nome, :valor, :marca)');
        $stm->bindValue(':nome', $data->nome);
        $stm->bindValue(':valor', $data->valor);
        $stm->bindValue(':marca', $data->marca);
        $stm->execute();

        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        $insert = $db->lastInsertId('categorias');
        
        $msg = $insert ? 'Registro(s) inserido(s) com sucesso' : 'Erro ao inserir o registro, tente novamente.';
        
        $newData = $data;
        $newData->id = $insert;

        echo json_encode(array(
            "success" => true,
            "message" => $msg,
            "data" => $newData
        ));
    }

    public function update() {
        
        $data = json_decode($_POST['data']);
        
        $db = $this->getDb();
        $stm = $db->prepare('update ' . $this->getTable() . ' set nome=:nome, valor=:valor, :marca=:marca where id=:id');
        $stm->bindValue(':id', $data->id);
        $stm->bindValue(':nome', $data->nome);
        $stm->bindValue(':valor', $data->valor);
        $stm->bindValue(':marca', $data->marca);
        $update = $stm->execute();
        
        $msg = $update ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';
        
        echo json_encode(array(
            "success" => $update,
            "message" => $msg,
            "data" => $data
        ));
    }
}

new Instrumentos();
