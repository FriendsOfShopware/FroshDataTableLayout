//{namespace name=backend/plugins/frosh/datatablelayout}
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
    getItems: function () {
        return [
            {
                fieldLabel: '{s name="labelColumn"}{/s}',
                labelWidth: 100,
                anchor: '100%',
                name: 'label',
                allowBlank: false
            },
            {
                fieldLabel: '{s name="propertyColumn"}{/s}',
                labelWidth: 100,
                anchor: '100%',
                name: 'property',
                allowBlank: false
            },
            {
                fieldLabel: '{s name="renderColumn"}{/s}',
                xtype: 'codemirrorfield',
                mode: 'javascript',
                name: 'render',
                labelWidth: 100,
                anchor: '100%',
                height: 300,
                allowBlank: true
            }
        ];
    }
});