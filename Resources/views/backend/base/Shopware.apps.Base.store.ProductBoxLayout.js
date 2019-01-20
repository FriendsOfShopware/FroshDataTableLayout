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
            description: '',
            image: ''
        });
    }
});
//{/block}