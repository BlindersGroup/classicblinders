<div class="dbproductcomments_menu">
    <span class="title">{l s='Opiniones' mod='dbmenu'}</span>
    <div class="comment_stars">
        <span class="grade">{$media_comments}/5</span>
        {include file='module:dbproductcomments/views/templates/hook/_partials/rating.tpl' grade=$media_comments small=false}
        <span>{l s='Opiniones verificadas' mod='dbproductcomments'}</span>
    </div>
</div>