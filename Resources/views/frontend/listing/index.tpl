{extends file="parent:frontend/listing/index.tpl"}

{block name="frontend_index_header_javascript_inline"}
    {$smarty.block.parent}
    {include file='frontend/plugins/frosh/datatablelayout/inline.tpl'}
{/block}
