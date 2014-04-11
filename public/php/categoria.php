<?php

require_once 'Db/Base.php';

class Intrumentos extends Base {

    private     $valor = null;
    private     $data = null;
    protected   $table = "categorias";
    
    public function insert() {
        
        $data = json_decode($_POST['data']);
        
        $db = $this->getDb();
        $stm = $db->prepare('Insert into ' . $this->getTable() . ' (nome) Values(:nome)');
        $stm->bindValue(':nome', $data->nome);
        $stm->execute();

        $result = $stm->fetch(\PDO::FETCH_ASSOC);

        $insert = $db->lastInsertId();
        
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
        $stm = $db->prepare('update ' . $this->getTable() . ' set nome=:nome where id=:id');
        $stm->bindValue(':id', $data->id);
        $stm->bindValue(':nome', $data->nome);
        $update = $stm->execute();
        
        $msg = $update ? 'Registro(s) atualizado(s) com sucesso' : 'Erro ao atualizar, tente novamente.';
        
        echo json_encode(array(
            "success" => $update,
            "message" => $msg,
            "data" => $data
        ));
    }
}

new Musicos();
