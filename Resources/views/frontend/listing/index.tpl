{extends file="parent:frontend/listing/index.tpl"}

{block name="frontend_listing_listing_content"}
    {if $productBoxLayout == 'data_table'}
        <div class="listing">
            <script>
                window.dataTableListingConfig = {
                    processing: true,
                    serverSide: true,
                    pageLength: {$criteria->getLimit()},
                    searching: false,
                    ajax: {
                        data: function() {
                            var info = $('#dataTableListing').DataTable().page.info();
console.log(info);
                            $('#dataTableListing').DataTable().ajax.url(
                                 "{url module=widgets controller=listing action=listingCount sCategory=$sCategoryContent.id loadProducts=1}?p=" + (info.page + 1) + "&n=" + info.length
                            );
                        }
                    },
                    columns: [
                        { data: "articleID" },
                        {
                            data: "articleName",
                            render: function (data, type, row) {
                                {literal}return '<a href="{row.linkDetails}">{data}</a>';{/literal}
                            }
                        },
                        { data: "instock" },
                        { data: "price" },
                    ]
                };
            </script>
            <table id="dataTableListing">
                <thead>
                    <tr>
                        <th>Article ID</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Price</th>
                    </tr>
                </thead>
            </table>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
