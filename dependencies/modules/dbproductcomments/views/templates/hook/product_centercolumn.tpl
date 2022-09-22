<div class="dbproductcomments_product_centercolumn">
    {include file='module:dbproductcomments/views/templates/hook/_partials/rating.tpl' grade=$media_comments small=true}
    <span class="num_comments">
        {if $total_comments == 1}
            1 {l s='opinión' mod='dbproductcomments'}
        {else}
            {$total_comments} {l s='opiniones' mod='dbproductcomments'}
        {/if}
    </span>
</div>