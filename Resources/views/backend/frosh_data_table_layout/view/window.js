Ext.define('Shopware.apps.FroshDataTableLayout.view.Window', {
    extend: 'Enlight.app.Window',
    title: 'Data Table Layout',
    alias: 'widget.data-table-layout-main-window',
    border: false,
    autoShow: true,
    height: 650,
    width: 925,
    layout: 'fit',
 
    initComponent: function() {
        var me = this;
        me.items = [
            {
                xtype: 'data-table-layout-column-list',
                store: me.columnStore,
                flex: 1
            }
        ];
    
        me.callParent(arguments);
    }

});
 
