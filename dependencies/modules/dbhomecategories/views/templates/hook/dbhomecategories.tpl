<div class="dbhomecategories">
    <p class="h3 title">{l s='Categorias' mod='dbhomecategories'}</p>
    <ul class="row">
        {foreach from=$categories item=cat}
            <li class="col-md-2 col-xs-6">
                <a href="{$cat.url}" class="home_cat">
                    <img src="{$cat.img}" alt="{$cat.name}" loading="lazy" width="141" height="180">
                    <span class="name">{$cat.name}</span>
                </a>
            </li>
        {/foreach}
    </ul>
</div>

