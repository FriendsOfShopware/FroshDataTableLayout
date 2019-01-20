//{namespace name=backend/plugins/frosh/datatablelayout}
Ext.define('Shopware.apps.FroshDataTableLayout.view.column.List', {
    extend:'Ext.grid.Panel',
    border: false,
    alias:'widget.data-table-layout-column-list',
    region:'center',
    autoScroll:true,
    snippets:{
    },
    initComponent: function () {
        var me = this;
        me.columns = me.getColumns();
        me.dockedItems = [
            {
                xtype: 'toolbar',
                dock: 'top',
                cls: 'shopware-toolbar',
                ui: 'shopware-ui',
                items: me.getButtons()
            }
        ];
        me.callParent(arguments);
    },
    getColumns: function () {
        var me = this;

        return [
            {
                header: '{s name="labelColumn"}{/s}',
                dataIndex: 'label',
                flex: 1
            },
            {
                header: '{s name="propertyColumn"}{/s}',
                dataIndex: 'property',
                flex: 1
            },
            {
                xtype: 'actioncolumn',
                width: 130,
                items: me.getActionColumnItems()
            }
        ];
    },
    getButtons: function()
    {
        var me = this;

        return [
            {
                text    : '{s name="add"}{/s}',
                scope   : me,
                iconCls : 'sprite-plus-circle-frame',
                action : 'addColumn'
            }
        ];
    },
    getActionColumnItems: function () {
        var me = this;

        return [
            {
                iconCls:'x-action-col-icon sprite-pencil',
                cls:'duplicateColumn',
                tooltip:'{s name="edit"}{/s}',
                getClass: function(value, metadata, record) {
                    if (!record.get("id")) {
                        return 'x-hidden';
                    }
                },
                handler:function (view, rowIndex, colIndex, item) {
                    me.fireEvent('openColumnDetail', view, rowIndex, colIndex, item);
                }
            },
            {
                iconCls:'x-action-col-icon sprite-minus-circle-frame',
                cls:'duplicateColumn',
                tooltip:'{s name="delete"}{/s}',
                getClass: function(value, metadata, record) {
                    if (!record.get("id")) {
                        return 'x-hidden';
                    }
                },
                handler: function (view, rowIndex, colIndex, item) {
                    me.fireEvent('deleteColumn', view, rowIndex, colIndex, item);
                }
            }
        ];
    },
    /**
     * @return Ext.toolbar.Paging The paging toolbar
     */
    getPagingBar: function () {
        var me = this;
        return Ext.create('Ext.toolbar.Paging', {
            store: me.store,
            dock: 'bottom',
            displayInfo: true
        });
    }
});
