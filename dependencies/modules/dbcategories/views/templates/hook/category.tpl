{if isset($categories) AND $categories|count > 0}
    <div class="dbcategories">
        <p class="h3 title">{l s='Otras categorías de interés' mod='dbcategories'}</p>
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

{if isset($manufacturers) AND $manufacturers|count > 0}
    <div class="dbcategories">
        <p class="h3 title">{l s='Marcas relacionadas' mod='dbcategories'}</p>
        <ul class="categories_list">
            {foreach from=$manufacturers item=cat}
                <li class="cat_list">
                    <a href="{$cat.url}" class="cat_home">
                        <span class="name">{$cat.name}</span>
                    </a>
                </li>
            {/foreach}
        </ul>
    </div>
{/if}