<?php 
        $password = 10;
        $hashSenha = hash('sha512', $password );
        for ($i = 0; $i < 64000; $i++) {
            $hashSenha = hash('sha512', $hashSenha);
        }

        echo $hashSenha;
  

