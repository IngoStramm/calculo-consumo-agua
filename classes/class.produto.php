<?php
/**
* 
*/
class Produto
{
	private $id;
	private $nome;
	private $url;
	private $preco;
	private $ml;
	private $img;

	function __construct( $id, $nome, $url, $preco, $img )
	{
		$this->id = $id;
		$this->nome = $nome;
		$this->url = $url;
		$this->preco = $preco;
		$this->img = $img;
	}

	public function get_ID()
	{
		return $this->id;
	}

	public function get_nome()
	{
		return $this->nome;
	}

	public function get_url()
	{
		return $this->url;
	}

	public function get_preco()
	{
		return $this->preco;
	}

	public function get_img()
	{
		return $this->img;
	}

	public function set_ml( $ml )
	{
		$this->ml = $ml;
	}

	public function get_ml()
	{
		return $this->ml;
	}
}