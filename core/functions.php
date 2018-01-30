<?php

add_action( 'init', 'init_functions_calculadora' );

function init_functions_calculadora() {

	add_filter( 'woocommerce_cart_item_remove_link', 'add_js_event', 1, 2 ) ;

	function add_js_event( $string, $cart_item_key ) {
	    $string = str_replace( '>&times;<', 'onclick="remove_produto_do_carrinho(this);" >&times;<', $string);
	    return $string;
	}

}