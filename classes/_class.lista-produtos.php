<?php
/**
* 
*/
class Lista_Produtos
{
	private $lista_produtos;

	function __construct()
	{
		$this->lista_produtos = [];
	}

	public function define_lista( $lista_produtos )
	{
		$this->lista_produtos = $lista_produtos;
	}

	public function get_lista()
	{
		$this->lista_produtos;
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
		return $produtos_array;
	}
}