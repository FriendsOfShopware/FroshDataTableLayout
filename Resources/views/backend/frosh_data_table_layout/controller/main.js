//{namespace name=backend/plugins/frosh/datatablelayout}
Ext.define('Shopware.apps.FroshDataTableLayout.controller.Main', {
    extend: 'Ext.app.Controller',
    mainWindow: null,
    init: function() {
        var me = this;

        me.mainWindow = me.getView('Window').create({
            columnStore: me.getStore('Column')
        });

        me.callParent(arguments);

        me.control({
            'data-table-layout-column-list button[action=addColumn]' : {
                'click': function (btn) {
                    this.addColumn(btn);
                }
            },
            'data-table-layout-column-list':{
                openColumnDetail: me.openColumnDetail,
                deleteColumn: me.deleteColumn
            },
            'data-table-layout-column-window button[action=save]' : {
                'click': function (btn) {
                    this.saveColumn(btn);
                }
            }
        });
    },
    addColumn: function () {
        var me = this;
        me.detailRecord = Ext.create('Shopware.apps.FroshDataTableLayout.model.Column');

        me.getView('column.Window').create({
            record: me.detailRecord
        }).show();
    },
    openColumnDetail: function (view, rowIndex) {
        var me = this,
            record = me.getStore('Column').getAt(rowIndex);

        me.record = record;
        me.detailStore = new Ext.data.Store({
            extend: 'Ext.data.Store',
            remoteFilter: true,
            model: 'Shopware.apps.FroshDataTableLayout.model.Column'
        });

        me.detailStore.load({
            params: {
                id: record.get('id')
            },
            callback: function(records, operation) {
                if (operation.success !== true || !records.length) {
                    return;
                }
                me.detailRecord = records[0];
                me.getView('column.Window').create({
                    record: me.detailRecord,
                    detailStore: me.detailStore
                }).show();
            }
        });
    },
    saveColumn: function (btn) {
        var win = btn.up('window'),
            form = win.down('form'),
            formBasis = form.getForm(),
            me = this,
            store = me.getStore('Column'),
            record = form.getRecord();

        if (!(record instanceof Ext.data.Model)){
            record = Ext.create('Shopware.apps.FroshDataTableLayout.model.Column');
        }

        formBasis.updateRecord(record);
        if (formBasis.isValid()) {
            record.save({
                success: function() {
                    store.load();
                    win.close();
                }
            });
        }
    },
    deleteColumn: function (view, rowIndex) {
        var me = this,
            store = me.getStore('Column');

        me.record = store.getAt(rowIndex);

        //use the model from the record because article in split view mode can be outdated
        if (me.record instanceof Ext.data.Model && me.record.get('id') > 0) {
            Ext.MessageBox.confirm('', '{s name="deleteColumn"}{/s}' , function (response) {
                if ( response !== 'yes' ) {
                    return;
                }
                me.record.destroy({
                    callback: function() {
                        store.load();
                    }
                });
            });
        }
    }
});
