//{namespace name=backend/plugins/frosh/datatablelayout}
//{block name="backend/category/view/tabs/settings" prepend}
Ext.define('Shopware.apps.Base.store.ProductBoxLayout.Override', {

    override: 'Shopware.apps.Base.store.ProductBoxLayout',

    constructor: function() {
        var me = this;

        me.callParent(arguments);

        me.add({
            key: 'data_table',
            label: '{s name="productBoxLabel"}{/s}',
            description: '{s name="productBoxDescription"}{/s}',
            image: '{link file="custom/plugins/FroshDataTableLayout/Resources/views/frontend/_public/src/images/data_table.png"}'
        });
    }
});
//{/block}