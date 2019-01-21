{extends file="parent:frontend/listing/index.tpl"}

{block name="frontend_index_header_javascript_inline"}
    {$smarty.block.parent}
    {if $productBoxLayout == 'data_table'}
        window.dataTableListingUrl = '{url module=widgets controller=listing action=listingCount sCategory=$sCategoryContent.id loadProducts=1}';
        window.dataTableListingConfig = {
            processing: true,
            serverSide: true,
            pageLength: {$criteria->getLimit()},
            ordering: false,
            responsive: true,
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
{/block}

{block name="frontend_listing_listing_content"}
    {if $productBoxLayout == 'data_table'}
        <div class="listing">
            <table id="dataTableListing">
                <thead>
                    <tr>
                        {foreach $dataTableListingColumns as $column}
                            <th>{s name=$column.label namespace="frontend/plugins/frosh/datatablelayout/column"}{$column.label}{/s}</th>
                        {/foreach}
                    </tr>
                </thead>
            </table>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
