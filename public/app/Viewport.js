Ext.define('Zfextjs.view.Viewport', {
    extend: 'zfetjs.container.Viewport',
    title: ' Aprendendo Cássio zfextjs',
    layout: 'border',
    itemId: 'viewPortPrincipal',
    items: [
    {
        xtype: 'box',
        id: 'header',
        region: 'north',
        html: '<h1>Loja de Instrumento</h1>',
        height: 40
    }
    ,{
        region:'west',
        border: false,
        split: true,
        margins: '0 0 5 5',
        width: 275,
        minWidth: 150,
        maxWidth: 400,
        xtype: 'treepanel',
        title: 'Menu',
        rootVisible: false,
        autoScroll: true,
        collapsible: true,
        animate: true,
        useArrows: true,
        itemId: 'treePanelPrincipal',
        dockedItems: [{
            xtype: 'toolbar',
            items: [{
                text: 'Expandir todos',
                iconCls: 'expand', 
                handler: function(){
                    this.up('#treePanelPrincipal').expandAll();
                }
            }, {
                text: 'Contrair todos',
                iconCls: 'collapse', 
                handler: function(){
                    this.up('#treePanelPrincipal').collapseAll();
                }
            }]
        }],
        listeners: {
            itemclick: function(view, record, item, index, evt, options) {
                if (record.get('leaf')) {
                    
//                    var controller = WSExt.app.getController(record.raw['controllerName']);
//                    controller.init();
                    
                    var abaAberta = this.ownerCt.down('#tabCenter').items.findBy(function( aba ){
                        return aba.title === record.get('text');
                    });
                    
                    if(!abaAberta){
                        this.ownerCt.down('#tabCenter').add({
                            title: record.get('text') || 'Tela do sistema',
                            closable: true,
                            layout: 'fit',
                            autoDestroy: true,
                            items: {
                                xtype: record.raw['xtypeClass']
                            }
                        }).show();
                    }else{
                        this.ownerCt.down('#tabCenter').setActiveTab(abaAberta);
                    }
                    
                }
            }
        },
        store: Ext.create('Ext.data.TreeStore', {
            proxy: {
                type: 'ajax',
                url: 'php/Menu.php',
                noCache : false,
                actionMethods: {
                    read: 'POST'
                }
            }
        })
    }
    ,{
        xtype: 'tabpanel',
        region: 'center', 
        margins: '0 5 5 0',
        border: false,
        itemId: 'tabCenter'
    }
    ]
    
});
