<div class="dbhomecategories full_width">
    <div class="container">
        {*        <p class="h3 title">{l s='Categorias' mod='dbhomecategories'}</p>*}
        <ul class="dbhomecategories_list">
            {foreach from=$categories item=cat}
                <a href="{$cat.url}" class="home_cat">
                    <img src="{$cat.img}" alt="{$cat.name}" loading="lazy" width="141" height="180">
                    <span class="name">{$cat.name}</span>
                </a>
            {/foreach}
        </ul>
    </div>
</div>

