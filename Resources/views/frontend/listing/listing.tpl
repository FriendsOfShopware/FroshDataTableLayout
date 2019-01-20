{extends file="parent:frontend/listing/listing.tpl"}

{block name="frontend_listing_bottom_paging"}
    {if $productBoxLayout != 'data_table'}
        {$smarty.block.parent}
    {/if}
{/block}