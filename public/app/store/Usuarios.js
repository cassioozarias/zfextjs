Ext.define('zfextjs.store.Usuarios', {

    extend: 'Ext.data.Store',
    requires: ['zfextjs.model.Usuario'],
    model: 'zfextjs.model.Usuario',
    storeId: 'Usuarios',

    autoLoad: false,
    pageSize: '5',
    remoteSort: false,

    sorters: [
        {
            property: 'nome',
            direction: 'ASC'
        }
    ],
    proxy: {
        type: 'ajax',
        api: {
            create: '/admin/users/new/',
            read: '/admin/users/list/',
            update: 'php/usuarios.php?action=update',
            destroy: 'php/usuarios.php?action=delete'
        },
        reader: {
            type: 'json',
            root: 'data'
        },
        writer: {
            type: 'json',
            root: 'data',
            encode: true,
            writeAllFields: true
        },
        actionMethods: {
            create: 'POST',
            read: 'POST',
            update: 'POST',
            destroy: 'POST'
        }
//        type: 'ajax',
//        url: 'php/usuarios.php?action=fetchAll',
//        reader: {
//            type: 'json',
//            root: 'data'
//        }

//        type: 'ajax',
//        url: 'php/usuariosxml.php',
//        reader: {
//            type: 'xml',
//            root: 'usuarios',
//            record: 'usuario'
//        }
//          url: 'data/usuario.json',
//        reader: {
//            type: 'json',
//            root: 'usuarios'
//        }
    },

    listeners: {

        write: function(proxy, operation){

            var obj = Ext.decode(operation.response.responseText);

            if(obj.success){
                Ext.MessageBox.show({
                    title: 'Ok',
                    msg: obj.message,
                    icon: Ext.MessageBox.INFO,
                    buttons: Ext.Msg.OK
                });
            }else{
                Ext.MessageBox.show({
                    title: 'Erro',
                    msg: obj.message,
                    icon: Ext.MessageBox.ERROR,
                    buttons: Ext.Msg.OK
                });
            }
        }

    }
});