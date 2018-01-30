<?php

require_once 'class.produto.php';

/**
* 
*/
class Combinacao extends Produto
{
	private $quantidade;

	public function get_quantidade()
	{
		return $this->quantidade;
	}

	public function set_quantidade( $quantidade )
	{
		$this->quantidade = $quantidade;
	}
}