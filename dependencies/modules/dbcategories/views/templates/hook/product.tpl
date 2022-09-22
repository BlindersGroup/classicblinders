{if isset($categories) AND $categories|count > 0}
    <div class="dbcategories">
        <p class="h3 title">{l s='Lo has podido ver en' mod='dbcategories'}</p>
        <ul class="categories_list">
            {foreach from=$categories item=cat}
                <li class="cat_list">
                    <a href="{$cat.url}" class="cat_home">
                        <span class="name">{$cat.name}</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}