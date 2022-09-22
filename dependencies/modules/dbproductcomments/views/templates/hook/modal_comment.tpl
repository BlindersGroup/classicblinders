<div class="modal fade" id="CommentModal" tabindex="-1" role="dialog" aria-labelledby="CommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="{l s='Close' d='Shop.Theme.Global'}">
                    <span aria-hidden="true"><i class="fa-solid fa-xmark"></i></span>
                </button>
                <p class="title h3">{l s='Da tu opinión sobre este producto' mod='dbproductcomments'}</p>
                <p class="subtitle">{l s='Hola %name%, dejanos tu valoración sobre este producto' sprintf=['%name%' => $customer.firstname] mod='dbproductcomments'}</p>

                <div class="valoracion_global">
                    <p class="minititle">{l s='Valoración global' mod='dbproductcomments'}</p>
                    <div class="rating_global">
                        <input type="radio" name="rate_global" id="star5" value="5" />
                        <label for="star5">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25713 1.50931L6.22286 5.4866L1.67147 6.12645C0.855269 6.24061 0.528167 7.2109 1.12007 7.76664L4.4129 10.8608L3.63408 15.2316C3.49389 16.0216 4.35682 16.6134 5.07956 16.2439L9.15121 14.1802L13.2229 16.2439C13.9456 16.6104 14.8085 16.0216 14.6683 15.2316L13.8895 10.8608L17.1823 7.76664C17.7742 7.2109 17.4471 6.24061 16.6309 6.12645L12.0795 5.4866L10.0453 1.50931C9.6808 0.800361 8.62473 0.791349 8.25713 1.50931Z" fill="#FABC2A"></path>
                            </svg>
                        </label>

                        <input type="radio" name="rate_global" id="star4" value="4" checked />
                        <label for="star4">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25713 1.50931L6.22286 5.4866L1.67147 6.12645C0.855269 6.24061 0.528167 7.2109 1.12007 7.76664L4.4129 10.8608L3.63408 15.2316C3.49389 16.0216 4.35682 16.6134 5.07956 16.2439L9.15121 14.1802L13.2229 16.2439C13.9456 16.6104 14.8085 16.0216 14.6683 15.2316L13.8895 10.8608L17.1823 7.76664C17.7742 7.2109 17.4471 6.24061 16.6309 6.12645L12.0795 5.4866L10.0453 1.50931C9.6808 0.800361 8.62473 0.791349 8.25713 1.50931Z" fill="#FABC2A"></path>
                            </svg>
                        </label>

                        <input type="radio" name="rate_global" id="star3" value="3" />
                        <label for="star3">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25713 1.50931L6.22286 5.4866L1.67147 6.12645C0.855269 6.24061 0.528167 7.2109 1.12007 7.76664L4.4129 10.8608L3.63408 15.2316C3.49389 16.0216 4.35682 16.6134 5.07956 16.2439L9.15121 14.1802L13.2229 16.2439C13.9456 16.6104 14.8085 16.0216 14.6683 15.2316L13.8895 10.8608L17.1823 7.76664C17.7742 7.2109 17.4471 6.24061 16.6309 6.12645L12.0795 5.4866L10.0453 1.50931C9.6808 0.800361 8.62473 0.791349 8.25713 1.50931Z" fill="#FABC2A"></path>
                            </svg>
                        </label>

                        <input type="radio" name="rate_global" id="star2" value="2" />
                        <label for="star2">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25713 1.50931L6.22286 5.4866L1.67147 6.12645C0.855269 6.24061 0.528167 7.2109 1.12007 7.76664L4.4129 10.8608L3.63408 15.2316C3.49389 16.0216 4.35682 16.6134 5.07956 16.2439L9.15121 14.1802L13.2229 16.2439C13.9456 16.6104 14.8085 16.0216 14.6683 15.2316L13.8895 10.8608L17.1823 7.76664C17.7742 7.2109 17.4471 6.24061 16.6309 6.12645L12.0795 5.4866L10.0453 1.50931C9.6808 0.800361 8.62473 0.791349 8.25713 1.50931Z" fill="#FABC2A"></path>
                            </svg>
                        </label>

                        <input type="radio" name="rate_global" id="star1" value="1" />
                        <label for="star1">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.25713 1.50931L6.22286 5.4866L1.67147 6.12645C0.855269 6.24061 0.528167 7.2109 1.12007 7.76664L4.4129 10.8608L3.63408 15.2316C3.49389 16.0216 4.35682 16.6134 5.07956 16.2439L9.15121 14.1802L13.2229 16.2439C13.9456 16.6104 14.8085 16.0216 14.6683 15.2316L13.8895 10.8608L17.1823 7.76664C17.7742 7.2109 17.4471 6.24061 16.6309 6.12645L12.0795 5.4866L10.0453 1.50931C9.6808 0.800361 8.62473 0.791349 8.25713 1.50931Z" fill="#FABC2A"></path>
                            </svg>
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="form-control-label has_value_textarea minititle">{l s='Título opinión' mod='dbproductcomments'}</label>
                        <input class="form-control" name="title_comment" type="text" value="" placeholder="{l s='Tú título aquí' mod='dbproductcomments'}">
                        <span class="error_title_comment"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="form-control-label has_value_textarea minititle">{l s='Tú opinión' mod='dbproductcomments'}</label>
                        <textarea id="CommentModalContent" class="form-control" name="content_comment" rows="3"></textarea>
                        <span class="error_content_comment"></span>
                    </div>
                </div>

                {if $premium == 1}
                    <div class="caracteristicas">
                        <p class="minititle">{l s='Ayudanos a hacerlo mucho más fácil' mod='dbproductcomments'}</p>
                        <p class="minisubtitle">{l s='Valorando estas características, nos permitiras ofercer una mejor descripciuón del producto.' mod='dbproductcomments'}</p>
                        <p class="minisubtitle">{l s='¡Sabemos que os encantan las barritas de puntuación!' mod='dbproductcomments'}</p>
                        <div class="vote_caracteristica">
                            <span class="name">{$charact1}</span>
                            <div class="rating_caracteristicas">
                                <input type="radio" name="charact1" id="charact1_5" value="5" />
                                <label for="charact1_5"></label>

                                <input type="radio" name="charact1" id="charact1_4" value="4" checked />
                                <label for="charact1_4"></label>

                                <input type="radio" name="charact1" id="charact1_3" value="3" />
                                <label for="charact1_3"></label>

                                <input type="radio" name="charact1" id="charact1_2" value="2" />
                                <label for="charact1_2"></label>

                                <input type="radio" name="charact1" id="charact1_1" value="1" />
                                <label for="charact1_1"></label>
                            </div>
                        </div>
                        <div class="vote_caracteristica">
                            <span class="name">{$charact2}</span>
                            <div class="rating_caracteristicas">
                                <input type="radio" name="charact2" id="charact2_5" value="5" />
                                <label for="charact2_5"></label>

                                <input type="radio" name="charact2" id="charact2_4" value="4" checked />
                                <label for="charact2_4"></label>

                                <input type="radio" name="charact2" id="charact2_3" value="3" />
                                <label for="charact2_3"></label>

                                <input type="radio" name="charact2" id="charact2_2" value="2" />
                                <label for="charact2_2"></label>

                                <input type="radio" name="charact2" id="charact2_1" value="1" />
                                <label for="charact2_1"></label>
                            </div>
                        </div>
                        <div class="vote_caracteristica">
                            <span class="name">{$charact3}</span>
                            <div class="rating_caracteristicas">
                                <input type="radio" name="charact3" id="charact3_5" value="5" />
                                <label for="charact3_5"></label>

                                <input type="radio" name="charact3" id="charact3_4" value="4" checked />
                                <label for="charact3_4"></label>

                                <input type="radio" name="charact3" id="charact3_3" value="3" />
                                <label for="charact3_3"></label>

                                <input type="radio" name="charact3" id="charact3_2" value="2" />
                                <label for="charact3_2"></label>

                                <input type="radio" name="charact3" id="charact3_1" value="1" />
                                <label for="charact3_1"></label>
                            </div>
                        </div>
                    </div>

                    <div class="recomendacion">
                        <p class="minititle">{l s='¿Recomendarias a otros usuarios la compra de este producto?' mod='dbproductcomments'}</p>
                        <div class="switch-field">
                            <input type="radio" id="radio-one" name="recomendacion" value="1" checked/>
                            <label for="radio-one">{l s='Si' mod='dbproductcomments'}</label>
                            <input type="radio" id="radio-two" name="recomendacion" value="0" />
                            <label for="radio-two">{l s='No' mod='dbproductcomments'}</label>
                        </div>
                    </div>
                {/if}

                <button class="btn btn-primary btn_createcomment" data-idproduct="{$id_product}" data-idcustomer="{$customer.id}">{l s='Guardar y continuar' mod='dbproductcomments'}</button>
            </div>
        </div>
    </div>
</div>
