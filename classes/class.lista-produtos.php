<?php

require_once 'class.produto.php';

/**
* 
*/
class Lista_Produtos
{
	private $lista_produtos;
	private $utils;

	function __construct()
	{
		$this->lista_produtos = [];
		$this->utils = new Utils;
	}

	public function get_wc_produtos()
	{
		$this->reset_lista();
		$args = array(
			'post_type'		=> 'product',
			'post_status'	=> 'publish'
		);
		$query = new WP_Query( $args );

		while ( $query->have_posts() ) : $query->the_post();
			$post_id = get_the_ID();
			$product = wc_get_product( $post_id );
			$ml = get_post_meta( $post_id, 'calculo_cmb_number', true );
			$img = get_the_post_thumbnail_url( $post_id, 'thumbnail' );
			$item = new Produto( $post_id, get_the_title(), get_the_permalink(), $product->get_price(), $img );
			if( $ml ) :
				$item->set_ml( $ml );
				$this->lista_produtos[] = $item;
			endif;
		endwhile;
		wp_reset_postdata();

		return $this->lista_produtos;
	}

	public function teste_produtos( $total_produtos = 3 )
	{
		$this->reset_lista();
		$produtos = [];
		for ($i=0; $i < $total_produtos; $i++) :
			$id = $i + 1;
			$nome = 'Produto #' . ( $i + 1 );
			$url = '#' . $i;
			$preco = ( $i + 1 ) * 10;
			$ml = ( $i + 1) * 100;
			$produto = new Produto( $id, $nome, $url, $preco );
			$produto->set_ml( $ml );
			$this->lista_produtos[] = $produto;
		endfor;
		return $this->lista_produtos;
	}

	public function get_ml_produtos( $lista_produtos )
	{
		// $this->utils->debug( $lista_produtos );
		$ml_produtos = [];
		foreach ($lista_produtos->get_lista() as $prod) :
			$ml_produtos[] = $prod->get_ml();
		endforeach;
		return $ml_produtos;
	}

	public function teste_ml_produtos()
	{
		$ml_produtos = [];
		$produtos = $this->teste_produtos();
		foreach ($produtos as $prod) :
			$ml_produtos[] = $prod->get_ml();
		endforeach;
		return $ml_produtos;
	}

	public function define_lista( $lista_produtos )
	{
		$this->lista_produtos = $lista_produtos;
	}

	public function get_lista()
	{
		return $this->lista_produtos;
	}

	public function reset_lista()
	{
		$this->lista_produtos = [];
	}

	public function add_produto( Produto $produto )
	{
		$this->lista_produtos[] = $produto;
	}

	public function get_produto( $prod_id )
	{
		$produtos_array = $this->lista_produtos;
		foreach ( $produtos_array as $k => $prod ) :
			if( $prod->get_ID() != $prod_id )
				unset( $produtos_array[$k] );
		endforeach;
		return array_pop( array_reverse( $produtos_array ) );
	}

}