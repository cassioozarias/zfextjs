Ext.define('zfextjs.controller.Instrumento', {
    extend: 'Ext.app.Controller',
    stores: ['Instrumentos', 'Categorias'],
    models: ['Usuario', 'Categira'],
    views: ['usuario.Grid', 'usuario.Form', 'usuario.Window'],
    refs: [
        {
            ref: 'usuarioGrid',
            selector: 'usuariogrid'
        },
        {
            ref: 'usuarioForm',
            selector: 'usuarioform'
        },
        {
            ref: 'usuarioWindow',
            selector: 'usuariowindow',
            xtype: 'usuariowindow',
            autoCreate: true
        },

        {
            ref: 'comboCategoria',
            selector: '#categoria'
        }
    ],

    config: {
        record: null
    },

    init: function() {
        var me = this;
        me.control(
            {
                'usuariogrid button[action=addUsuario]': {
                    click: me.addUsuario
                },

                'usuariogrid button[text=Editar usuario]': {
                    click: me.editarUsuario
                },

                'usuariogrid #deletarUsuario': {
                    click: me.deletarUsuario
                },

                'usuariogrid button[action=loadData]': {
                    click: me.loadData
                },

                'usuarioform button[action=salvarUsuario]': {
                    click: me.salvarUsuario
                },

                'usuarioform #estado': {
                    meuEvento: me.buscarCidade
                }
            }
        );

        me.listen({
            controller: {
                '*': {
                    metodoDeUmController: 'minhaFuncaoParaMetodoDoController'
                }
            },

            store: {
                '#Usuarios': {
                    remove: 'onStoreRemove',
                    add: 'onStoreAdd'
                }
            }

        });
    },

    buscarCidade: function(param1, param2){
        console.log(param1);
        console.log(param2);

        var comboCidade = this.getComboCidade(),
            storeCidade = comboCidade.getStore();

        storeCidade.filter('id_estado', param2);


    },

    onStoreRemove: function() {

    },

    onStoreAdd: function() {
    },

    minhaFuncaoParaMetodoDoController: function() {

    },

    addUsuario: function() {
        var usuarioWindow = this.getUsuarioWindow();
        usuarioWindow.setTitle('Adicionando usuario');

    },

    editarUsuario: function() {
        var usuarioWindow = this.getUsuarioWindow(),
            form = this.getUsuarioForm(),
            linhasSelecionadas = this.getUsuarioGrid().getSelectionModel().getSelection(),
            usuarioSelecionado = linhasSelecionadas[0];
        usuarioWindow.setTitle('Editando usuario');
        form.loadRecord(usuarioSelecionado);
    },

    loadData: function() {
        var storeUsuario = Ext.getStore('Usuarios');
        storeUsuario.load();
    },

    deletarUsuario: function() {
        var form = this.getUsuarioForm(),
            linhasSelecionadas = this.getUsuarioGrid().getSelectionModel().getSelection(),
            usuarioSelecionado = linhasSelecionadas[0],
            storeUsuario = this.getUsuarioGrid().getStore();
        Ext.Msg.show({
            title: 'Confirmação',
            msg: 'Tem certeza que deseja deletar?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.MessageBox.WARNING,
            scope: this,
            fn: function(btn, evt) {
                if(btn == 'yes') {
                    storeUsuario.remove(usuarioSelecionado);
                    storeUsuario.getProxy().setExtraParam('meuNovoParametro', 'meuValor');
                    storeUsuario.sync();
                }
            }

        });
    },

    salvarUsuario: function() {
//        var form = Ext.ComponentQuery.query('usuarioform')[0];
        var form = this.getUsuarioForm(),
            usuarioWindow = this.getUsuarioWindow(),
            basicForm = form.getForm(),
            valoresForm = basicForm.getValues(),
            storeUsuario = this.getUsuarioGrid().getStore(),
            registroUsuario = basicForm.getRecord();

        if(basicForm.isValid()) {
            if(registroUsuario) {
                registroUsuario.set(valoresForm);
            } else {
                var objetoUsuario = Ext.create('Zf2ExtJS.model.Usuario');
                objetoUsuario.set(valoresForm);
                storeUsuario.add(objetoUsuario);
            }
        }
        storeUsuario.sync();
        usuarioWindow.close();
    }
});