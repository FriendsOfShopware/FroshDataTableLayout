{extends file="parent:frontend/listing/listing.tpl"}

{block name="frontend_listing_listing_content"}
    {if $productBoxLayout == 'data_table'}
        <div class="listing">
            <table id="dataTableListing">
                <thead>
                <tr>
                    {foreach $dataTableListingColumns as $column}
                        <th>{$column.label|snippet:$column.label:"frontend/plugins/frosh/datatablelayout/column"}</th>
                    {/foreach}
                </tr>
                </thead>
            </table>
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

{block name="frontend_listing_bottom_paging"}
    {if $productBoxLayout != 'data_table'}
        {$smarty.block.parent}
    {/if}
{/block}