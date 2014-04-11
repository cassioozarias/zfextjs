Ext.define('zfextjs.controlle.Categoria', {
    extend: 'Ext.app.Controlle',
    
    stores: ['Categorias'],
    models: ['Categoria'],
    views:  ['categoria.Grid', 'categoria.Form', 'categoria.Window'],
    
    refs:   [
        {
          ref: 'categoriaGrid',
          selector: 'categoriagrid'  
        },
        {
           ref: 'categoriaForm',
           selector: 'categoriaform'
        },
        {
           ref: 'categoriaWindow',
          selector: 'categoriawindow',
          xtype: 'categoriawindow',
          autoCreate: 'true'  
        }
 ],

 config: {
    record: null
  },

   init: function() {
   var me = this;
   me.control(
       {
                'categoriagrid button[action=addCategoria]': {
                    click: me.addCategoria 	 
                },

                'categoriagrid button[text=Editar categoria]': {
                    click: me.editarCategoria
                },

                'categoriagrid #deletarCategoria': {
                    click: me.deletarCategoria
                },

                'categoriagrid button[action=loadData]': {
                    click: me.loadData
                },

                'categoriaform button[action=salvarCategoria]': {
                    click: me.salvarCategoria
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
                '#Categorias': {
                    add: 'onStoreAdd',
                    remove: 'onStoreRemove'
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
        categoriaWindow.setTitle('Adicionando categoria');

    },

    editarCategoria: function() {
        var categoriaWindow = this.getCategoriaWindow(),
            form = this.getCategoriaForm(),
            linhasSelecionadas = this.getCategoriaGrid().getSelectionModel().getSelection(),
            categoriaelecionado = linhasSelecionadas[0];
        categoriaWindow.setTitle('Editando categoria');
        form.loadRecord(categoriaSelecionado);
    },

    loadData: function() {
        var storeCategoria = Ext.getStore('Categoria');
        storeCategoria.load();
    },

    deletarCategoria: function() {
        var form = this.getCategoriaForm(),
            linhasSelecionadas = this.getCategoriaGrid().getSelectionModel().getSelection(),
            categoriaSelecionado = linhasSelecionadas[0],
            storeCategoria = this.getCategoeiaGrid().getStore();
        Ext.Msg.show({
            title: 'Confirmação',
            msg: 'Tem certeza que deseja deletar?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.MessageBox.WARNING,
            scope: this,
            fn: function(btn, evt) {
                if(btn == 'yes') {
                    storeCategoria.remove(categoriaSelecionado);
                    storeCategoria.getProxy().setExtraParam('meuNovoParametro', 'meuValor');
                    storeCategoria.sync();
                }
            }

        });
    },

    salvarCategoria: function() {
        var form = this.getCategoriaForm(),
            categoriaWindow = this.getCategoriaWindow(),
            basicForm = form.getForm(),
            valoresForm = basicForm.getValues(),
            storeCategoria = this.getCategoriaGrid().getStore(),
            registroCategoria = basicForm.getRecord();

        if(basicForm.isValid()) {
            if(registroCategoria) {
                registroCategoria.set(valoresForm);
            } else {
                var objetoCategoria = Ext.create('zfextjs.model.Categoria');
                objetoCategoria.set(valoresForm);
                storeCategoria.add(objetoCategoria);
            }
        }
        storeCategoria.sync();
        categoriaWindow.close();
    }
});