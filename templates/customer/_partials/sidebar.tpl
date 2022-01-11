<div id="left-column" class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
    <div class="navigation_desktop hidden-md-down">
        <div class="card navigation_account">
            <span class="title">{l s='Account summary' d='Shop.Theme.Customeraccount'}</span>
            <a class="item" href="{$urls.pages.my_account}">
                <i class="fa-solid fa-user"></i>
                {l s='My account' d='Shop.Theme.Customeraccount'}
            </a>
        </div>

        <div class="card navigation_account">
            <span class="title">{l s='My orders' d='Shop.Theme.Customeraccount'}</span>
            <a class="item" href="{$urls.pages.history}">
                <i class="fa-solid fa-list-ul"></i>
                {l s='My orders' d='Shop.Theme.Customeraccount'}
            </a>
            {if $configuration.voucher_enabled && !$configuration.is_catalog}
                <a class="item" href="{$urls.pages.discount}">
                    <i class="fa-solid fa-tag"></i>
                    {l s='Discount coupons' d='Shop.Theme.Customeraccount'}
                </a>
            {/if}
            {if !$configuration.is_catalog}
                <a class="item" href="{$urls.pages.order_slip}">
                    <i class="fa-solid fa-file-invoice"></i>
                    {l s='Credit slips' d='Shop.Theme.Customeraccount'}
                </a>
            {/if}
            {if $configuration.return_enabled && !$configuration.is_catalog}
                <a class="item" href="{$urls.pages.order_follow}">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    {l s='Merchandise returns' d='Shop.Theme.Customeraccount'}
                </a>
            {/if}
        </div>

        <div class="card navigation_account">
            <span class="title">{l s='Personal information' d='Shop.Theme.Customeraccount'}</span>
            <a class="item" href="{$urls.pages.identity}">
                <i class="fa-solid fa-address-book"></i>
                {l s='Personal information' d='Shop.Theme.Customeraccount'}
            </a>
            <a class="item" href="{$urls.pages.addresses}">
                <i class="fa-solid fa-location-dot"></i>
                {l s='My Addresses' d='Shop.Theme.Customeraccount'}
            </a>
        </div>

        <div class="card navigation_account">
            <span class="title">{l s='Contact' d='Shop.Theme.Customeraccount'}</span>
            <a class="item" href="{$urls.pages.contact}">
                <i class="fa-solid fa-envelope"></i>
                {l s='Contact Form' d='Shop.Theme.Customeraccount'}
            </a>
        </div>
    </div>

    <div id="accordion" class="navigation_mobile hidden-lg-up">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseMenuAccount" aria-expanded="true" aria-controls="collapseMenuAccount">
            {l s='My account' d='Shop.Theme.Customeraccount'}
{*            {$page.meta.title}*}
            <i class="fa-solid fa-angle-down"></i>
        </button>
        <div id="collapseMenuAccount" class="collapse show" aria-labelledby="headingDelivery" data-parent="#accordion" aria-expanded="true">
            <div class="card-body">
                <a class="item {if $page.page_name == 'my-account'}active{/if}" href="{$urls.pages.my_account}">
                    <i class="fa-solid fa-user"></i>
                    {l s='My account' d='Shop.Theme.Customeraccount'}
                </a>
                <a class="item {if $page.page_name == 'history'}active{/if}" href="{$urls.pages.history}">
                    <i class="fa-solid fa-list-ul"></i>
                    {l s='My orders' d='Shop.Theme.Customeraccount'}
                </a>
                {if $configuration.voucher_enabled && !$configuration.is_catalog}
                    <a class="item {if $page.page_name == 'discount'}active{/if}" href="{$urls.pages.discount}">
                        <i class="fa-solid fa-tag"></i>
                        {l s='Discount coupons' d='Shop.Theme.Customeraccount'}
                    </a>
                {/if}
                {if !$configuration.is_catalog}
                    <a class="item {if $page.page_name == 'order-slip'}active{/if}" href="{$urls.pages.order_slip}">
                        <i class="fa-solid fa-file-invoice"></i>
                        {l s='Credit slips' d='Shop.Theme.Customeraccount'}
                    </a>
                {/if}
                {if $configuration.return_enabled && !$configuration.is_catalog}
                    <a class="item {if $page.page_name == 'order-follow'}active{/if}" href="{$urls.pages.order_follow}">
                        <i class="fa-solid fa-arrow-rotate-left"></i>
                        {l s='Merchandise returns' d='Shop.Theme.Customeraccount'}
                    </a>
                {/if}
                <a class="item {if $page.page_name == 'identity'}active{/if}" href="{$urls.pages.identity}">
                    <i class="fa-solid fa-address-book"></i>
                    {l s='Personal information' d='Shop.Theme.Customeraccount'}
                </a>
                <a class="item {if $page.page_name == 'addresses'}active{/if}" href="{$urls.pages.addresses}">
                    <i class="fa-solid fa-location-dot"></i>
                    {l s='My Addresses' d='Shop.Theme.Customeraccount'}
                </a>
                <a class="item" href="{$urls.pages.contact}">
                    <i class="fa-solid fa-envelope"></i>
                    {l s='Contact Form' d='Shop.Theme.Customeraccount'}
                </a>
            </div>
        </div>
    </div>
</div>
