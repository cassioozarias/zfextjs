Ext.require(['WSExt.Categoria.Combo']);

Ext.define('WSExt.view.Categoria.Edit', {
    extend: 'Ext.window.Window',
    alias : 'widget.categoriaEdit',
    title : 'Edição de Categoria',
    layout: 'fit',
    autoShow: true,
    modal: true,

    initComponent: function() {
    	
        this.items = [{
            xtype: 'form',
            style: 'background-color: #fff;',
            fieldDefaults: {
                anchor: '100%',
                labelAlign: 'left',
                labelWidth: 150,
                allowBlank: false,
                combineErrors: false,
                msgTarget: 'side'
            },
            defaultType: 'textfield',
            defaults: {
                anchor: '100%'
            },
            items: [
            {
                xtype: 'numberfield',
                name : 'valor',
                ref: 'valor',
                fieldLabel: 'Valor',
                minValue: 0,
                allowDecimals: true,
                decimalPrecision: 2,
                decimalSeparator: '.',
                allowBlank: false
            }
            ,
            {
                xtype: 'datefield',
                name : 'data',
                ref: 'data',
                fieldLabel: 'data',
                maxValue: new Date(),
                format: 'd/m/Y',
                submitFormat: 'Y-m-d',
                allowBlank: false
            }
            ,{
                xtype: 'categoriaCombo'
            }
            ]
        }
        ];

        this.buttons = [{
            text: 'Salvar',
            action: 'save',
            iconCls: 'save'
        },
        {
            text: 'Cancelar',
            scope: this,
            iconCls: 'cancel',
            handler: this.close
        }];

        this.callParent(arguments);
    }
});