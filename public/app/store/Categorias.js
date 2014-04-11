Ext.define('zfextjs.store.Categorias', {

    extend: 'Ext.data.Store',
    requires: ['zfexts.model.Categoria'],
    model: 'Zf2ExtJS.model.Categorias',
    storeId: 'Categorias',

    autoLoad: true,
    remoteFilter: false,
    proxy: {
        type: 'ajax',
        //url: 'data/categoria.json',
        url: 'php/categoria.php',
        reader: {
            type: 'json',
            root: 'categorias'
        }
    }
});