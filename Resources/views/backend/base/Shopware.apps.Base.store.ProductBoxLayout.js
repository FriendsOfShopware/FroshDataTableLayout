//{namespace name=backend/base/product_box_layout}
//{block name="backend/category/view/tabs/settings" prepend}
Ext.define('Shopware.apps.Base.store.ProductBoxLayout.Override', {

    override: 'Shopware.apps.Base.store.ProductBoxLayout',

    constructor: function() {
        var me = this;

        me.callParent(arguments);

        me.add({
            key: 'data_table',
            label: 'Data Table',
            description: 'List products in a configurable table',
            image: '{link file="custom/plugins/FroshDataTableLayout/Resources/views/frontend/_public/src/images/data_table.png"}'
        });
    }
});
//{/block}