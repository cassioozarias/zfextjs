Ext.define('zfextjs.model.Usuario', {
    extend: 'Ext.data.Model',
    
    fields: [
        {
            name: 'id'
        },
        {
            name: 'nome'
        },
        {
            name: 'email'
        },
        {    
            name: 'categoria'
        }
    ]
});