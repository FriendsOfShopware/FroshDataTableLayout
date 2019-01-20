Ext.define('Shopware.apps.FroshDataTableLayout.view.column.Window', {
    extend: 'Enlight.app.Window',
    title: 'Column erstellen/bearbeiten',
    alias: 'widget.data-table-layout-column-window',
    border: false,
    autoShow: true,
    layout: 'fit',
    height: 480,
    width: 640,
    modal: true,
    initComponent: function() {
        var me = this;
        me.items = [  
            {
                xtype: 'data-table-layout-column-form',
                record: me.record
            }
        ];
        me.dockedItems = [{
            xtype: 'toolbar',
            dock: 'bottom',
            cls: 'shopware-toolbar',
            ui: 'shopware-ui',
            items: me.getButtons()
        }];
        me.callParent(arguments);
    },
    getButtons: function() {
        var me = this;

        return ['->',
            {
                text    : 'Cancel',
                scope   : me,
                cls     : 'secondary',
                handler : me.destroy
            },
            {
                text    : 'Save',
                action  : 'save',
                cls     : 'primary',
                formBind: true
            }
        ];
    }
});