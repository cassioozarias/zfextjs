<?php

require_once 'Db/Base.php';

class Login extends Base {
    
    private     $nome = null;
    protected   $table = "usuarios";

    function logar() {
        
        $usuario = $_POST['usuario'];
        $senha = md5($_POST['senha']);
        
        $db = $this->getDb();
        $stm = $db->prepare("select * from " . $this->getTable() . ' where usuario=:usuario and senha=:senha');
        $stm->bindValue(':usuario', $usuario);
        $stm->bindValue(':senha', $senha);
        $stm->execute();
        $qtdUser = $stm->rowCount();
        
        if ($qtdUser > 0) {
            $result["success"] = true;
            //cria a sessao
            //pode dar um redirect
        } else {
            $result["success"] = true;
            $result["errors"]["reason"] = "Usuário ou senha inválido(s)";
        }

        echo json_encode($result);
    }

}
new Login();
