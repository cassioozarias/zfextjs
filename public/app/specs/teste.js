describe("Users", function() {
    var store = null, ctlr = null;

    beforeEach(function(){
        if (!ctlr) {
            ctlr = Application.getController('Users');
        }

        if (!store) {
            store = ctlr.getStore('Users');
        }

        expect(store).toBeTruthy();

        waitsFor(
            function(){ return !store.isLoading(); },
            "load never completed",
            4000
        );
    });

    it("should have users",function(){
        expect(store.getCount()).toBeGreaterThan(1);
    });

    it("should open the editor window", function(){
        var grid = Ext.ComponentQuery.query('userlist')[0];

        ctlr.editUser(grid,store.getAt(0));

        var edit = Ext.ComponentQuery.query('useredit')[0];

        expect(edit).toBeTruthy();
        if(edit)edit.destroy();
    });

});

describe('MyController refs', function() {
    var view = new Zf2ExtJS.view.curso.Window({ renderTo: Ext.getBody() }),
        ctrl = new Zf2ExtJS.controller.Curso();

    it('should ref MyView objects', function() {
        var cmp = ctrl.getCursoWindow();

        expect(cmp).toBeDefined();
    });

    it('should ref MyView button OK', function() {
        var form = ctrl.getCursoWindow().down('cursoform');

        expect(form.title).toBe('Curso');
    });

    it('should listen to fooevent in controller domain', function() {
        spyOn(ctrl, 'metodoDeUmController');

        ctrl.fireEvent('metodoDeUmController');

        expect(ctrl.onFooEvent).toHaveBeenCalled();
    });
});