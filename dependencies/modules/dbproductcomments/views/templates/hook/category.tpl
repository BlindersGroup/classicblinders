
<div class="dbproductcomments">
    <div class="dbcomments_category mt-3">
        <div class="info_total">
            <span class="num_comments">{$total_comments} {l s='opiniones verificadas' mod='dbproductcomments'}</span>
            <span class="category">{l s='en' mod='dbproductcomments'} {$name}</span>
            <span class="media_comments">{$media_comments}/5</span>
            {include file='module:dbproductcomments/views/templates/hook/_partials/rating.tpl' grade=$media_comments small=false}
        </div>

        {foreach from=$last_comments item=comment}
            <div class="info_comment">
                <span><img src="//{$comment.img}" loading="lazy" height="98" width="98" alt="{$comment.product_name}"></span>
                <span class="date_comment">{$comment.date_add|date_format:"%d/%m/%Y"} {$comment.title} {l s='en' mod='dbproductcomments'}</span>
                <span><a href="{$comment.url}">{$comment.product_name}</a></span>
                {include file='module:dbproductcomments/views/templates/hook/_partials/rating.tpl' grade=$media_comments small=true}
            </div>
        {/foreach}
    </div>
</div>