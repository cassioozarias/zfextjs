Ext.define('zfextjs.view.Viewport', {
    extend: 'Ext.container.Viewport',
    requires:[
        'Ext.layout.container.Fit',
        'zfextjs.view.Main',
        'zfextjs.view.categoria.Grid',
        'zfextjs.utils.Permissao'
    ],

    itemId: 'viewPortPrincipal',

    layout: {
        type: 'fit'
    },

    items: [
        {
            xtype: 'app-main'
        }
    ]
});
