Ext.define('Shopware.apps.FroshDataTableLayout.view.column.Form', {
    extend:'Ext.form.Panel',
    alias:'widget.data-table-layout-column-form',
    collapsible: false,
    bodyPadding: 10,
    split: false,
    region: 'center',
    defaultType: 'textfield',
    autoScroll: true,
    items: [],
    initComponent: function() {
        var me = this;
        me.items = me.getItems();
        me.callParent(arguments);
        me.loadRecord(me.record);
    },
    getItems:function () {
        return [
            {
                fieldLabel: 'Label',
                labelWidth: 200,
                name: 'label',
                allowBlank: false
            },
            {
                fieldLabel: 'Property',
                labelWidth: 200,
                name: 'property',
                allowBlank: false
            }
        ];
    }
});