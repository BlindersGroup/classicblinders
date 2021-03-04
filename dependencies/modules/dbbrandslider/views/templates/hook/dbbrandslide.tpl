<div class="dbbrandslide mt-3">
    <p class="h3 title">{l s='Principales marcas' mod='dbbrandslide'}</p>
    <div id="splide_dbbrandslide" class="splide">
        <div class="splide__track">
            <div class="splide__list">
                {foreach from=$brands item=brand}
                    <div class="splide__slide">
                        <a href="{$brand.url}">
                            <img src="//{$brand.img}" alt="{$brand.name}" loading="lazy" width="125" height="125">
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#splide_dbbrandslide', {
                perPage     : 5,
                pagination: false,
                lazyLoad: 'sequential',
                arrows: true,
                breakpoints: {
                    600: {
                        perPage: 2,
                        padding: {
                            right: '2rem',
                        },
                        arrows: false,
                    },
                    800: {
                        perPage: 2,
                        padding: {
                            right: '2rem',
                        },
                        arrows: false,
                    },
                }
            } ).mount();
        } );
    </script>
</div>