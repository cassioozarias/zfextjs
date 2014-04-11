Ext.define('Zf2ExtJS.controller.Curso', {
    extend: 'Ext.app.Controller',

    stores: ['Cursos'],
    models: ['Curso'],
    views: ['curso.Grid', 'curso.Form', 'curso.Window'],

    refs: [
        {
            ref: 'cursoGrid',
            selector: 'cursogrid'
        },
        {
            ref: 'cursoForm',
            selector: 'cursoform'
        },
        {
            ref: 'cursoWindow',
            selector: 'cursowindow',
            xtype: 'cursowindow',
            autoCreate: true
            //forceCreate: true
        }
    ],

    config: {
        record: null
    },

    init: function() {
        var me = this;
        me.control(
            {
                'cursogrid button[action=addCurso]': {
                    click: me.addCurso
                },

                'cursogrid button[text=Editar curso]': {
                    click: me.editarCurso
                },

                'cursogrid #deletarCurso': {
                    click: me.deletarCurso
                },

                'cursogrid button[action=loadData]': {
                    click: me.loadData
                },

                'cursoform button[action=salvarCurso]': {
                    click: me.salvarCurso
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
                '#Cursos': {
                    remove: 'onStoreRemove',
                    add: 'onStoreAdd'
                }
            }

        });
    },

    onStoreRemove: function() {

    },

    onStoreAdd: function() {
//        var form = this.getCursoForm(),
//            storeCurso = this.getCursoGrid().getStore(),
//            quantidadeRegistroStore = storeCurso.getCount(),
//            novoRegistroCurso = storeCurso.getAt( (quantidadeRegistroStore-1) );
//        form.loadRecord(novoRegistroCurso);
    },

    minhaFuncaoParaMetodoDoController: function() {

    },

    addCurso: function() {
//        var cursoWindow = Ext.create('Zf2ExtJS.view.curso.Window');
        var cursoWindow = this.getCursoWindow();
        cursoWindow.setTitle('Adicionando curso');
        //var cursoWindow = Ext.widget('cursowindow');

//        rowEditing.cancelEdit();
//
//        // Create a model instance
//        var r = Ext.create('Employee', {
//            name: 'New Guy',
//            email: 'new@sencha-test.com',
//            start: Ext.Date.clearTime(new Date()),
//            salary: 50000,
//            active: true
//        });
//
//        store.insert(0, r);
//        rowEditing.startEdit(0, 0);
    },

    editarCurso: function() {
//        var cursoWindow = Ext.create('Zf2ExtJS.view.curso.Window');
        //var form = cursoWindow.down('cursoform'),
        var cursoWindow = this.getCursoWindow(),
            form = this.getCursoForm(),
            linhasSelecionadas = this.getCursoGrid().getSelectionModel().getSelection(),
            cursoSelecionado = linhasSelecionadas[0];
        cursoWindow.setTitle('Editando curso');
        form.loadRecord(cursoSelecionado);
    },

    loadData: function() {
        var storeCurso = Ext.getStore('Cursos');
        storeCurso.load();
    },

    deletarCurso: function() {
        var form = this.getCursoForm(),
            linhasSelecionadas = this.getCursoGrid().getSelectionModel().getSelection(),
            cursoSelecionado = linhasSelecionadas[0],
            storeCurso = this.getCursoGrid().getStore();
        Ext.Msg.show({
            title: 'Confirmação',
            msg: 'Tem certeza que deseja deletar?',
            buttons: Ext.Msg.YESNO,
            icon: Ext.MessageBox.WARNING,
            scope: this,
            fn: function(btn, evt) {
                if(btn == 'yes') {
                    storeCurso.remove(cursoSelecionado);
                    storeCurso.getProxy().setExtraParam('meuNovoParametro', 'meuValor');
                    storeCurso.sync();
                }
            }

        });
    },

    salvarCurso: function() {
//        var form = Ext.ComponentQuery.query('cursoform')[0];
        var form = this.getCursoForm(),
            cursoWindow = this.getCursoWindow(),
            basicForm = form.getForm(),
            valoresForm = basicForm.getValues(),
            storeCurso = this.getCursoGrid().getStore(),
            registroCurso = basicForm.getRecord();

        //console.log(registroCurso);
        //console.log(registroCurso.get('nome'));

        if(basicForm.isValid()) {
            if(registroCurso) {
                registroCurso.set(valoresForm);
            } else {
                var objetoCurso = Ext.create('Zf2ExtJS.model.Curso');
                objetoCurso.set(valoresForm);
                storeCurso.add(objetoCurso);
            }
        }
        storeCurso.sync();
        cursoWindow.close();
    }
});
