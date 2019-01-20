Ext.define('Shopware.apps.FroshDataTableLayout.model.Column', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'id', type: 'int', useNull: true },
        { name: 'label', type: 'string' },
        { name: 'property', type: 'string' },
        { name: 'render', type: 'string', useNull: true }
    ],
    proxy: {
        type: 'ajax',
        api:{
            read: '{url controller="FroshDataTableLayout" action="listColumns"}',
            create: '{url controller="FroshDataTableLayout" action="createColumn"}',
            update: '{url controller="FroshDataTableLayout" action="updateColumn"}',
            destroy: '{url controller="FroshDataTableLayout" action="deleteColumn"}'
        },
        reader: {
            type: 'json',
            root: 'data'
        }
    }
});
