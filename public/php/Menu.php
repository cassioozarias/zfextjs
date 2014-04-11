<?php

$menu = "{ 
            children: [
                {
                    text:'Cadastros',
                    expanded: true,
                    children:[
                        {
                            text: 'Cursos',
                            leaf:true,
                            xtypeClass: 'cursogrid'
                        },
                        {
                            text: 'Usuarios',
                            leaf:true,
                            xtypeClass: 'usuariogrid'
                        }
                    ]
                }
            ]
        }";
echo $menu;
