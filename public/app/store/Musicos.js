Ext.define('zfextjs.store.Musicos', {

    extend: 'Ext.data.Store',
    requires: ['zfexts.model.Musico'],
    model: 'Zf2ExtJS.model.Musicos',
    storeId: 'Musicos',

    autoLoad: true,
    remoteFilter: false,
    proxy: {
        type: 'ajax',
        //url: 'data/musico.json',
        url: 'php/musico.php',
        reader: {
            type: 'json',
            root: 'musicos'
        }
    }
});