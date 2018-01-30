<?php

add_action( 'wp_ajax_update_cart_calculo', 'update_cart_calculo' );
add_action( 'wp_ajax_nopriv_update_cart_calculo', 'update_cart_calculo' );

function update_cart_calculo() {
	$return = [];
	$post_id = isset( $_POST[ 'post_id' ] ) ? $_POST[ 'post_id' ] : false;
	$qty = isset( $_POST[ 'qty' ] ) ? $_POST[ 'qty' ] : null;
	$cart_item_key = isset( $_POST[ 'cart_item_key' ] ) ? $_POST[ 'cart_item_key' ] : false;
	$return[ 'post_id' ] = $post_id;
	$return[ 'qty' ] = $qty;
	$return[ 'cart_item_key' ] = $cart_item_key;
	// Parei aqui
	// Preciso verificar se os dados estão sendo passados corretamente via ajax
	// atualizar o carrinho (adicionar ou excluir)
	// atualizar as informações na tela (o carrinho no topo tbm)

	// Post Id é necessário para atualizar (ou adicionar novo produto a)o carrinho 
	if( $post_id ) :
		// Se o produto já existir no carrinho e houver uma quantidade para ser alterada
		if( $cart_item_key && !is_null( $qty ) ) :
			WC()->cart->set_quantity( $cart_item_key, $qty );
			$return[ 'status' ] = 'success';
			$return[ 'message' ] = __( 'Produto atualizado no carrinho com sucesso', 'calculo-consumo-agua' );
		elseif( $qty > 0 && $add_to_cart = WC()->cart->add_to_cart( $post_id ) ) :
			$return[ 'status' ] = 'success';
			$return[ 'message' ] = __( 'Novo produto adicionado ao carrinho com sucesso', 'calculo-consumo-agua' );
			$return[ 'add_to_cart' ] = $add_to_cart;
		else :
			$return[ 'status' ] = 'error';
			$return[ 'message' ] = __( 'Ocorreu um erro ao adicionar o produto ao carrinho: ', 'calculo-consumo-agua' ) . $add_to_cart;
		endif;
	else :
		$return[ 'status' ] = 'error';
		$return[ 'message' ] = __( 'ID do produto não encontrado.', 'calculo-consumo-agua' );
	endif;
	wp_send_json( $return );
}