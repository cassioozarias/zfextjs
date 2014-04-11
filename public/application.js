Ext.define('zfextjs.Application', {
    name: 'zfextjs',

    extend: 'Ext.app.Application',

    requires: ['Ext.data.TreeStore'],

    views: [
        // TODO: add views here
    ],

    controllers: [
        'Categoria',
        ''
    ],

    stores: [
    ],

    launch: function() {
        //ajax - pegar as permissoes
        //Zf2ExtJS.utils.Permissao.setBotaoAddAtivo(false);
        Ext.Ajax.request({
            url: 'php/token.php',
            success: function(response){
                var text = response.responseText;
                // process server response here
                //console.log(text);
                var token = Ext.decode(text);
                Zf2ExtJS.utils.Permissao.setToken(token.token.token);
            }
        });
    }
});
