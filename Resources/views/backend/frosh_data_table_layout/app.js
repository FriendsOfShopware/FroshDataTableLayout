Ext.define('Shopware.apps.FroshDataTableLayout', {
    extend: 'Enlight.app.SubApplication',
    name: 'Shopware.apps.FroshDataTableLayout',
    bulkLoad: true,
    loadPath: '{url action=load}',
    controllers: ['Main'],
    models: [ 'Column' ],
    stores: [ 'Column' ],
    views: [ 'Window', 'column.List', 'column.Window', 'column.Form' ],
 
    /** Main Function
     * @private
     * @return [object] mainWindow - the main application window based on Enlight.app.Window
     */
    launch: function() {
        var me = this;
        var mainController = me.getController('Main');
 
        return mainController.mainWindow;
    }
});
