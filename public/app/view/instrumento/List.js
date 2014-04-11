Ext.require(['WSExt.view.Instrumento.ComboRenderer']);

Ext.define('WSExt.view.Instrumento.List' ,{
    extend: 'Ext.grid.Panel',
    alias : 'widget.InstrumentoList',
    store: 'Categorias',
    title : 'Lista de Instrumento',
    //selModel: {mode: 'MULTI'},
    selModel: Ext.create('Ext.selection.CheckboxModel'),
    columnLines: true,
    tbar :[
        {
            text: 'Incluir',
            action: 'insert',
            iconCls: 'add',
            itemId: 'insert'
        }
        ,{
            text: 'Editar',
            action: 'edit',
            iconCls: 'edit',
            itemId: 'edit',
            disabled: true
        },
        {
            text: 'Excluir',
            action: 'destroy',
            iconCls: 'delete',
            itemId: 'delete',
            disabled: true
        }
        ,{
            text: 'Recarregar dados',
            action: 'refresh',
            iconCls: 'refresh',
            itemId: 'refresh'
        }
    ],
    
    dockedItems: [{
            xtype: 'pagingtoolbar',
            store: 'Instrumento',
            dock: 'bottom',
            displayInfo: true
        }],
    
    initComponent: function(){
        
        this.columns = [
            Ext.create('Ext.grid.RowNumberer'),
            {
                header: 'ID',  
                dataIndex: 'id',  
                flex: 1
            },

            {
                header: 'Nome',  
                dataIndex: 'nome',  
                flex: 1, 
                format:'0.00', 
                renderer: Ext.util.Format.valorRenderer
            },
            {
                header: 'Categoria',  
                dataIndex: 'categoria',  
                flex: 1, 
                format:'0.00', 
                renderer: Ext.util.Format.valorRenderer
            },
            {
                header: 'Valor',  
                dataIndex: 'Valor',  
                flex: 1, 
                format:'0.00', 
                renderer: Ext.util.Format.valorRenderer
            },
            {
                header: 'Marca',  
                dataIndex: 'marca',  
                flex: 1, 
                format:'0.00', 
                renderer: Ext.util.Format.valorRenderer
            },
            //{header: 'Data',  dataIndex: 'data',  flex: 1, renderer: Ext.util.Format.dateRenderer('d/m/Y')}

            {
                header: 'Data',  
                dataIndex: 'data',  
                flex: 1, 
                xtype:'datecolumn', 
                format:'d/m/Y'
            },

            {
                header: 'Categoria',  
                flex: 1,
                //field: Ext.create('WSExt.view.tipoDespesa.ComboRenderer'),
                renderer: Ext.util.Format.comboRenderer(Ext.create('WSExt.view.instrumento.ComboRenderer'))
                //renderer: function (value, metadata, record, rowIndex, colIndex, store) {
                    
//                    var storeCombo = Ext.getStore('TipoDespesas');
//                    var recordCombo = storeCombo.find('id', value);
//                    return recordCombo.get('nome');

//                    var combo = Ext.create('widget.tipoDespesaCombo');
//                    var despesa = combo.store.find('id', value);
//                    return despesa ? despesa.get('nome') : '';

                    
                    //var idx = this.columns[colIndex].field.store.find('id', value);
                    //return idx !== -1 ? this.columns[colIndex].field.store.getAt(idx).get('nome') : '';
                //}
            }
        ];
        
        this.callParent();
        this.getSelectionModel().on('selectionchange', this.onSelectChange, this);
    },
    
    onRender: function(){
        this.store.load();
        this.callParent(arguments);
    },
    
    onSelectChange: function(selModel, selections){
        this.down('#delete').setDisabled(selections.length === 0);
        this.down('#edit').setDisabled(selections.length !== 1);
    }
   
});