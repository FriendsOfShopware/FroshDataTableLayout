{if $productBoxLayout == 'data_table'}
    {if $Controller == 'search'}
        window.dataTableListingUrl = '{url module=widgets controller=listing action=listingCount sCategory=$Shop->getCategory()->getId() loadProducts=1 productBoxLayout=$productBoxLayout}';
    {else}
        window.dataTableListingUrl = '{url module=widgets controller=listing action=listingCount sCategory=$sCategoryContent.id loadProducts=1}';
    {/if}
    window.dataTableListingConfig = {
        processing: true,
        serverSide: true,
        pageLength: {$criteria->getLimit()},
        ordering: false,
        {if $Controller == 'search'}searching: false,{/if}
        responsive: true,
        autoWidth: false,
        lengthMenu: [[{$criteria->getLimit()}, 25, 50], [{$criteria->getLimit()}, 25, 50]],
        columns: [
            {foreach $dataTableListingColumns as $column}
                { data: "{$column.property}"{if $column.render}, render: function (data, type, row) { {$column.render} }{/if} },
            {/foreach}
        ],
        language: {
            search: "{s name="search" namespace="frontend/plugins/frosh/datatablelayout"}{/s}",
            info: "{s name="info" namespace="frontend/plugins/frosh/datatablelayout"}{/s}",
            lengthMenu: "{s name="lengthMenu" namespace="frontend/plugins/frosh/datatablelayout"}{/s}",
            processing: "{s name="processing" namespace="frontend/plugins/frosh/datatablelayout"}{/s}",
            paginate: {
                next: "{s name="next" namespace="frontend/plugins/frosh/datatablelayout"}{/s}",
                previous: "{s name="previous" namespace="frontend/plugins/frosh/datatablelayout"}{/s}"
            }
        }
    };
{/if}
