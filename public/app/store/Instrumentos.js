Ext.define('zfextjs.store.Instrumentos', {

    extend: 'Ext.data.Store',
    requires: ['zfexts.model.Instrumento'],
    model: 'Zf2ExtJS.model.Instrumentos',
    storeId: 'Instrumentos',

    autoLoad: true,
    remoteFilter: false,
    proxy: {
        type: 'ajax',
        //url: 'data/instrumento.json',
        url: 'php/instrumento.php',
        reader: {
            type: 'json',
            root: 'instrumentos'
        }
    }
});