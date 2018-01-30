<?php
/**
* 
*/
class Calculo_Soma_Produtos
{
	private $utils;
	public function __construct() {
		$this->utils = new Utils;
	}
	public function get_melhor_combinacao( $consumo_mensal, $lista_produtos ) {

		/*
		 * 1.0		-	Verifica se existe um produto/ml que é exatamente igual ao consumo. 
		 * 1.1		-	Se existir, este é o resultado.
		 * 2.0		- 	Verifica se existem produtos/ml que são maiores que o consumo.
		 * 2.1		- 	Verifica qual é o produto/ml maior que o consumo que possui a menor diferença (entre o produto/ml e o consumo).
		 * 2.2		-	Salva o resultado.
		 * 3.0		-	Verifica se existes produtos/ml que são menores que o consumo.
		 * 3.1		-	Verifica qual é o produto/ml menor que o consumo que possui a menor diferença(entre o produto/ml e o consumo) e que a diferença seja maior que o menor produto/ml.
		 * 3.2		-	Salva o resultado.
		 * 4.0		-	Compara os resultados para ver qual dos 2 possui a menor diferença em comparação com o consumo.
		 */

		$resultados = [];
		$valores_exatos = [];
		$valores_maiores = [];
		$valores_menores = [];
		$array_lista_produtos = $lista_produtos->get_lista();
		$quantidade = 0;

		foreach ( $array_lista_produtos as $produto ) :
			//pega o ml do produto
			$ml = $produto->get_ml();
			// Verifica se existe um valor igual ao consumo
			if( $ml == $consumo_mensal ) :
				$valores_exatos[ $produto->get_ID() ] = intval( $ml );
			// Verifica se existe um valor maior que o consumo
			elseif( $ml > $consumo_mensal ) :
				$valores_maiores[ $produto->get_ID() ] = intval( $ml );
			// Verifica se existe um valor menor que o consumo
			else :
				$valores_menores[ $produto->get_ID() ] = intval( $ml );
			endif;
		endforeach;

		if( $valores_exatos ) :

			foreach ( $valores_exatos as $prod_id => $valor ) :
				$quantidade = 1;
				$temp_prod = $lista_produtos->get_produto( $prod_id );
				$combinacao = new Combinacao( $temp_prod->get_ID(), $temp_prod->get_nome(), $temp_prod->get_url(), $temp_prod->get_preco() );
				$combinacao->set_ml( $temp_prod->get_ml() );
				$combinacao->set_quantidade( $quantidade );
				$resultados[] = $combinacao;
			endforeach;

		else:
			// loop
			// enquanto existir a diferença e for maior que o menor produto/ml (ou o resultado maior que o consumo?)
			$menor_valor = 0;

			// Verifica se existe valores maiores que a combinação
			if( $valores_maiores ) :

				// Ordena do menor para o maior
				asort( $valores_maiores );

				$menor_valor = 0;

				foreach ( $valores_maiores as $prod_id => $valor ) :
					$menor_valor = $menor_valor == 0 ? $valor : $menor_valor;
					if( $valor > $menor_valor ) :
						unset( $valores_maiores[ $prod_id ] );
					endif;
				endforeach;



				$resultados = $valores_maiores;

			endif;

			// Verifica se existe valores menores que a combinação
			if( $valores_menores ) :

				// Ordena do maior para o menor
				arsort( $valores_menores );

				$maior_valor = 0;

				foreach ( $valores_menores as $prod_id => $valor ) :
					$maior_valor = $maior_valor == 0 ? $valor : $maior_valor;
					if( $valor < $maior_valor ) :
						unset( $valores_menores[ $prod_id ] );
					endif;
				endforeach;

				// $resultados = $valores_menores;

			endif;

		endif;
			
			// $diferenca = ( $diferenca == ( $resultado_mais_proximo * $combinacao->get_ml() ) ) ? 0 : $consumo_mensal - ( $resultado_mais_proximo * $combinacao->get_ml() );

		return $resultados;

		// armazena os testes
		// $lista_combinacoes = [];
		// // armazena os resultados;
		// $resultados = [];
		// // armazena a diferença de ml entre os produtos e o total
		// $diferenca = 0;
		// // Define o total para a primeira verificação
		// $total = $consumo_mensal;
		// // Armazena a lista dos produtos
		// $array_lista_produtos = $lista_produtos->get_lista();

		// // menor ml na lista de produtos
		// $menor_ml = min( $lista_produtos->get_ml_produtos( $lista_produtos ) );

		// debug

		// 1ª iteração

		// $lista_combinacoes = $this->verificacao( $lista_produtos->get_lista(), $total );

		// $resultado_exato = array_search( $total, $lista_combinacoes );
		

		// $resultado_mais_proximo = min( $lista_combinacoes );

		// $melhor_resultado = $resultado_exato ? $resultado_exato : $resultado_mais_proximo;
		// $this->utils->debug( $lista_combinacoes );

		// $prod_id = array_search( $melhor_resultado, $lista_combinacoes );

		// $temp_prod = $lista_produtos->get_produto( $prod_id );

		// $combinacao = new Combinacao( $temp_prod->get_ID(), $temp_prod->get_nome(), $temp_prod->get_url(), $temp_prod->get_preco(), $melhor_resultado );
		// $combinacao->set_ml( $temp_prod->get_ml() );
		// $combinacao->set_combinacao( $melhor_resultado );
		
		// $diferenca = ( $diferenca == ( $resultado_mais_proximo * $combinacao->get_ml() ) ) ? 0 : $consumo_mensal - ( $resultado_mais_proximo * $combinacao->get_ml() );
		// $this->utils->debug( $diferenca );

		// $total = $diferenca > 0 ? $diferenca : $consumo_mensal;

		// $resultados[] = $combinacao;

		// 2ª iteração

		// $lista_combinacoes = $this->verificacao( $lista_produtos->get_lista(), $total );
		// $this->utils->debug( $lista_combinacoes );

		// $resultado_exato = array_search( $total, $lista_combinacoes );

		// $resultado_mais_proximo = min( $lista_combinacoes );

		// $melhor_resultado = $resultado_exato ? $resultado_exato : $resultado_mais_proximo;
		
		// $prod_id = array_search( $melhor_resultado, $lista_combinacoes );


		// $temp_prod = $lista_produtos->get_produto( $prod_id );

		// $combinacao = new Combinacao( $temp_prod->get_ID(), $temp_prod->get_nome(), $temp_prod->get_url(), $temp_prod->get_preco(), $melhor_resultado );
		// $combinacao->set_ml( $temp_prod->get_ml() );
		// $combinacao->set_combinacao( $melhor_resultado );
		
		// $diferenca = ( $diferenca == ( $resultado_mais_proximo * $combinacao->get_ml() ) ) ? 0 : $consumo_mensal - ( $resultado_mais_proximo * $combinacao->get_ml() );
		// $this->utils->debug( $diferenca );

		// $total = $diferenca > 0 ? $diferenca : $consumo_mensal;

		// $resultados[] = $combinacao;

		// // 3ª iteracao

		// $diferenca = ( $diferenca == ( $resultado_mais_proximo * $combinacao->get_ml() ) ) ? 0 : $consumo_mensal - ( $resultado_mais_proximo * $combinacao->get_ml() );
		// $this->utils->debug( $diferenca );

		// acabou

		// do {

		// 	$lista_combinacoes = $this->verificacao( $lista_produtos->get_lista(), $total, $menor_ml );

		// 	// Verifica por resultados de combinações iguais
		// 	$counts_lista_combinacoes = array_count_values($lista_combinacoes);
		// 	// armazena os resultados de combinações iguais
		// 	$lista_combinacoes_duplicados = array_filter($lista_combinacoes, function ($value) use ($counts_lista_combinacoes) {
		// 	    return $counts_lista_combinacoes[$value] > 1;
		// 	});

		// 	$lista_ml_combinacoes_duplicados = [];
		// 	$conta_lista = 0;
		// 	foreach ( $lista_combinacoes_duplicados as $id => $comb ) :
		// 		$lista_ml_combinacoes_duplicados[ $id ] = $array_lista_produtos[ $conta_lista ]->get_ml();
		// 		$conta_lista++;
		// 	endforeach;

		// 	// busca o valor mais próximo
		// 	$ml_duplicado_mais_proximo = null;
		// 	foreach ( $lista_ml_combinacoes_duplicados as $item ) :
		// 		if ( $ml_duplicado_mais_proximo === null || abs( $total - $ml_duplicado_mais_proximo ) > abs( $item - $total ) ) :
		// 			$ml_duplicado_mais_proximo = $item;
		// 		endif;
		// 	endforeach;

		// 	$this->utils->debug( $total );
		// 	$this->utils->debug( $ml_duplicado_mais_proximo );

		// 	$resultado_exato = array_search( $total, $lista_combinacoes );
			
		// 	$resultado_mais_proximo = min( $lista_combinacoes );

		// 	$melhor_resultado = $resultado_exato ? $resultado_exato : $resultado_mais_proximo;

		// 	$prod_id = array_search( $melhor_resultado, $lista_combinacoes );

		// 	$temp_prod = $lista_produtos->get_produto( $prod_id );

		// 	$combinacao = new Combinacao( $temp_prod->get_ID(), $temp_prod->get_nome(), $temp_prod->get_url(), $temp_prod->get_preco(), $melhor_resultado );
		// 	$combinacao->set_ml( $temp_prod->get_ml() );
		// 	$combinacao->set_combinacao( $melhor_resultado );
			
		// 	$diferenca = ( $diferenca == ( $resultado_mais_proximo * $combinacao->get_ml() ) ) ? 0 : $consumo_mensal - ( $resultado_mais_proximo * $combinacao->get_ml() );

		// 	$total = $diferenca > 0 ? $diferenca : $consumo_mensal;

		// 	$resultados[] = $combinacao;

		// } while ( $diferenca > 0 && $diferenca >= $menor_ml );

		// return $resultados;
	}

	public function verificacao( $lista_produtos, $total, $menor_ml )
	{
		$retorna = [];
		$valor_exato = [];
		foreach ( $lista_produtos as $produto ) :
			//pega o ml do produto
			$ml = $produto->get_ml();
			if( $ml == $total ) :
				$valor_exato[ $produto->get_ID() ] = intval( floor( $total / $ml ) );
			// elseif( $ml <= $total ) :
			else:
				//divide o total pelo ml de cada produto e salva nos testes
				$combinacao = $total / $ml;
				$combinacao = $combinacao > $menor_ml ? floor( $combinacao ) : ceil( $combinacao );
				$retorna[ $produto->get_ID() ] = intval( $combinacao );
				// $retorna[ $produto->get_ID() ] = floor( $total / $ml );
				// $this->utils->debug( floor( $total / $ml ) );
			endif;
		endforeach;
		return $valor_exato ? $valor_exato : $retorna;
	}

}