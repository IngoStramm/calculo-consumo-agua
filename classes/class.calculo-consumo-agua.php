<?php

/**
* 
* CalculoConsumoAgua class.
* 
*/
class Calculo_Consumo_Agua
{
	private $dir;

	function __construct() {
		$this->dir = plugin_dir_url( __DIR__ );
	}

	public function return_plugin_dir() {
		return $this->dir;
	}

	public function calcula_consumo( $peso ) {
		$resultado = $peso * 30;
		return $resultado;
	}

	public function ml_pra_lt( $ml ) {
		$lt = $ml / 1000;
		return ( float )$lt;
	}

	public function lt_exibicao( $lt ) {
		$lt_exibicao = is_float( $lt ) ? number_format( $lt, 2, ',', '.' ) : $lt;
		return $lt_exibicao;
	}

}