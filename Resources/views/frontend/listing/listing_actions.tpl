{extends file="parent:frontend/listing/listing_actions.tpl"}

{block name='frontend_listing_actions_paging'}
    {if $productBoxLayout != 'data_table'}
        {$smarty.block.parent}
    {/if}
{/block}