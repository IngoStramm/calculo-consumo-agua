<?php
/**
* Plugin Name: Aguaboa: Cálculo de Consumo de Água
* Plugin URI: https://convertefacil.com.br/
* Text Domain: calculo-consumo-agua
* Description: Plugin para Cálculo de Consumo de Água do site do Aguaboa.
* Version: 1.1.0
* Author: Ingo Stramm
* Author URI: https://convertefacil.com.br/
* License: Parte integrante do sistema ConverteFácil, não pode ser comercializado separadamente.
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'CALCULADORA_DIR', plugin_dir_path( __FILE__ ) );
define( 'CALCULADORA_URL', plugin_dir_url( __FILE__ ) );

require_once 'classes/classes.php';
require_once 'core/core.php';

function debug_calc() {
	$dir = new Calculo_Consumo_Agua();
	echo '<pre>';
	var_dump( $dir->return_plugin_dir() );
	echo '</pre>';
}