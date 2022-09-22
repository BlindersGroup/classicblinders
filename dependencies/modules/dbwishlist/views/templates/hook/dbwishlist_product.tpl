
<div class="dbwishlist_product">
    <span class="custom-checkbox">
        <label>
            <input class="dbwishlist_checkbox" name="dbwishlist" onclick="saveWishlist({$product.id})" type="checkbox" value="1" {if $active == 1}checked{/if}>
            <span><i class="fa-solid fa-check rtl-no-flip checkbox-checked"></i></span>
            <span class="text">{l s='Añadir a favoritos' mod='dbwishlist'}</span>
        </label>
    </span>
</div>
