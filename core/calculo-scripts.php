<?php
add_action( 'wp_enqueue_scripts', 'calculo_consumo_agua_script' );

function calculo_consumo_agua_script() {
	$utils = new Utils;
	$calc = new Calculo_Consumo_Agua();
	$dir = $calc->return_plugin_dir();
	wp_enqueue_style( 'calculo-consumo-agua-style', $dir . 'assets/css/style.css' );
	wp_enqueue_script( 'calculo-consumo-agua-script', $dir . 'assets/js/calculo-consumo-agua.min.js', array( 'jquery' ), 1.0, true );
		// wp_enqueue_script( 'cf-livereload', 'http://localhost:35729/livereload.js?snipver=1', array(), null, true );

}