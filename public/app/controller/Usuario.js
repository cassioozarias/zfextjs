Ext.define('zfextjs.controller.Usuario', {
    extend: 'Ext.app.Controller',

    stores: ['Usuarios'],
    models: ['Usuario'],
    views: ['usuario.Grid'],

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

    onStoreRemove: function() {

    },

    onStoreAdd: function() {
    },

    minhaFuncaoParaMetodoDoController: function() {

    },

    addCategoria: function() {
        var categoriaWindow = this.getCategoriaWindow();
        categoriaWindow.setTitle('Adicionando usuario');
    },

    editarUsuario: function() {
        var usuarioWindow = this.getUsuarioWindow(),
            form = this.getUsuarioForm(),
            linhasSelecionadas = this.getUsuarioGrid().getSelectionModel().getSelection(),
            usuarioelecionado = linhasSelecionadas[0];
        usuarioWindow.setTitle('Editando usuario');
        form.loadRecord(usuarioSelecionado);
    },

    loadData: function() {
        var storeUsuario = Ext.getStore('Usuario');
        storeUsuario.load();
    },

    deletarusuario: function() {
        var form = this.getUsuarioForm(),
            linhasSelecionadas = this.getUsuarioGrid().getSelectionModel().getSelection(),
            usuarioSelecionado = linhasSelecionadas[0],
            storeUsuario = this.getCategoeiaGrid().getStore();
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
                var objetoUsuario = Ext.create('zfextjs.model.Usuario');
                objetoUsuario.set(valoresForm);
                storeUsuario.add(objetoUsuario);
            }
        }
        storeUsuario.sync();
        usuarioWindow.close();
    }
});
