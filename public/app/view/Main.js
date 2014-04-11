Ext.define('zfextjs.view.Main', {
    extend: 'Ext.container.Container',
    requires:[
        'Ext.tab.Panel',
        'Ext.layout.container.Border',
        'Ext.tree.Panel'
    ],
    
    xtype: 'app-main',

    layout: {
        type: 'border'
    },

    items: [
        {
            region: 'west',
            width: 150,
            xtype: 'treepanel',
            title: 'Menu de ações',
            rootVisible: false,
            autoScroll: true,
            collapsible: true,
            animate: true,
            useArrows: true,
            itemId: 'treePanelPrincipal',
            listeners: {
                itemclick: function(view, record, item, index, evt, options) {
                    var tabPanel = view.up('#viewPortPrincipal').down('#tabCenter'),
                        aba = tabPanel.items.findBy(
                            function(tab){
                                return tab.title === record.get('text');
                            }
                        );
                    if(!aba){
                        if(record.get('leaf')){
                            tabPanel.add(
                                {
                                    xtype: record.raw['xtypeClass'],
                                    title: record.get('text'),
                                    layout: 'fit',
                                    closable: true
                                }
                            );
                        }
                    } else{
                        tabPanel.setActiveTab(aba);
                    }
                }
            },
            store: Ext.create('Ext.data.TreeStore', {
                proxy: {
                    type: 'ajax',
                    url: 'php/menu.php',
                    noCache : false,
                    actionMethods: {
                        read: 'POST'
                    }
                }
            })
        }
        ,{
            region: 'center',
            xtype: 'tabpanel',
            margins: '0 5 5 0',
            border: false,
            itemId: 'tabCenter'
        }
    ]
});