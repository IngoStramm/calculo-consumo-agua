<?php 
add_action( 'wp_ajax_calc_agua_response', 'calc_agua_response' );
add_action( 'wp_ajax_nopriv_calc_agua_response', 'calc_agua_response' );

function calc_agua_response() {
	$utils = new Utils;
	$calculadora = new Calculo_Consumo_Agua();
	$combinacao = new Calculo_Soma_Produtos();
	// $email = isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : false;
	$peso = isset( $_POST[ 'peso' ] ) ? $_POST[ 'peso' ] : false;
	$return = [];
	if( $peso ) :
	// if( $email && $peso ) :
		// $produtos = new Busca_Produtos();
		// $ml_produtos = $produtos->get_ml_produtos();
		// $utils->debug( $ml_produtos );



		$return[ 'status' ] = 'success';
		$consumo_diario = $calculadora->calcula_consumo( $peso );
		$consumo_mensal = $consumo_diario * 30;
		$consumo_mensal_em_lt = $calculadora->ml_pra_lt( $consumo_mensal );
		$consumo_mensal_em_lt_exibicao = $calculadora->lt_exibicao( $consumo_mensal_em_lt );

		$return[ 'consumo_diario' ] = $consumo_diario;
		$return[ 'consumo_mensal' ] = $consumo_mensal;
		$return[ 'consumo_mensal_em_lt' ] = $consumo_mensal_em_lt;
		$return[ 'consumo_mensal_em_lt_exibicao' ] = $consumo_mensal_em_lt_exibicao;

		// $to = $email;
		// $subject = 'Água Boa | Cálculo de Consumo de Água';
		// $body = '<html>';
		// $body .= '<body>';
		// $body .= '<table>';
		// $body .= '<tr>';
		// $body .= '<td>';
		// $body .= '<p>';
		// $body .= __( 'Seu consumo mensal de água é de ', 'calc_agua_response' ) . $consumo_mensal_em_lt_exibicao . __( ' litros.', 'calc_agua_response' );
		// $body .= '</p>';
		// $body .= '</td>';
		// $body .= '</tr>';
		// $body .= '</table>';
		// $body .= '</body>';
		// $body .= '</html>';
		// $headers = array('Content-Type: text/html; charset=UTF-8');
		 
		// wp_mail( $to, $subject, $body, $headers );
		
		// $return[ 'produtos' ] = $produtos->get_ml_produtos();
	else :
		$return[ 'status' ] = 'error';
		$return[ 'msg_error' ] = __( 'E-mail e/ou peso ausentes.', 'calculo-consumo-agua' );
	endif;
	wp_send_json( $return );
	wp_die();
}

