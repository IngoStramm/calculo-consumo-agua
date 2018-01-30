jQuery( function( $ ) {
	$(document).ready(function(){
		$( '.calculadora-form' ).each( function() {
			var calc_form = $( this );
			var btn_submit = calc_form.find( '.btn-submit' );
			var ajaxurl = calc_form.attr( 'data-ajax-url' );
			$( '.btn-submit' ).click(function(e){
				e.preventDefault();
				$( '.calculadora-consumo-overlay' ).show();
				// var email = calc_form.find( '#email' ).val();
				var peso = calc_form.find( '#peso' ).val();
				var data = {
					'action'	: 'calc_agua_response',
					// 'email'		: email,
					'peso'		: peso
				};
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: data,
					dataType: 'json'
				})
				.done( function( data ){
					if( data.status === 'success' ) {
	                    $( '#consumo-mensal-total' ).val( data.consumo_mensal ).change();
	                    $( '#consumo-mensal-exibicao' ).text( data.consumo_mensal_em_lt_exibicao ).change();
	                    calcula_porcentagem_consumo_agua();
	                    $( '.calculadora-form' ).hide();
	                    $( '.lista-produtos' ).show();
					} else {
						console.log( 'Status: ' + data.status );
						console.log( 'Erro: ' + data.msg_error );
					}
	            }).fail( function( xhr, status, error ) {
	               console.log( 'xhr: ' + xhr );
	               console.log( 'status: ' + status );
	               console.log( 'error: ' + error );
				}).always( function(){
					$( '.calculadora-consumo-overlay' ).fadeOut();
				});

			}); // $(.btn_submit).click
		});

		var calcula_porcentagem_consumo_agua = function(){
			var total = Number( $( '#consumo-mensal-total' ).val() );
			if( total ) {
				var novo_total = 0;
				$( '.lista-produtos' ).find( '.lista-produtos-item' ).each( function() {
					var item = $( this );
					var ml = Number( item.attr( 'data-ml' ) );
					var porcentagem = ( ml / total ) * 100;
					var qtd = Number( item.find( '.qty' ).val() );
					var ml_x_qtd = ml * qtd;
					porcentagem = arredonda_1_casa( porcentagem );
					item.find( '.porcentagem-ml' ).html( porcentagem );
					novo_total += ml_x_qtd;
				});
				novo_total = ( novo_total / total ) * 100;
				$( '#consumo-preenchido' ).val( novo_total ).change();
			}
		};

		var update_cart_calculo = function() {
			$( '.input-text.qty.text' ).change(function(e){
				// e.preventDefault();
				var input = $( this );
				var qty = Number( input.val() );
				var tr = input.closest( '.lista-produtos-item' );
				var cart_item_key = tr.attr( 'data-cart-item-key' );
				// Se a quantidade for zero para um produto que não existe no carrinho
				if( qty === 0 && !cart_item_key ) {
					// interrompe a função
					return;
				} else {
					var ajaxurl = $( '.calculadora-form' ).attr( 'data-ajax-url' );
					var post_id = tr.attr( 'data-prod-id' );
					var consumo_preenchido = Number( $( '#consumo-preenchido' ).val() );
					var porcentagem_produto = Number( input.prev( '.porcentagem-consumo-mensal' ).find( '.porcentagem-consumo-mensal-valor' ).text() );
					consumo_preenchido += porcentagem_produto;
					consumo_preenchido = arredonda_1_casa( consumo_preenchido );
					$( '.consumo-preenchido' ).text( consumo_preenchido );
					$( '.calculadora-consumo-overlay' ).show();
					var data = {
						'action'	: 'update_cart_calculo',
						'post_id'	: post_id,
						'qty'	: qty,
						'cart_item_key'	: cart_item_key
					};
					$.ajax({
						type: 'POST',
						url: ajaxurl,
						data: data,
						dataType: 'json'
					})
					.done( function( data ){
						// debug
		                    // console.log( 'Post ID: ' + data.post_id );
		                    // console.log( 'Quantidade: ' + data.qty );
		                    // console.log( 'Cart item key: ' + data.cart_item_key );
		                    // console.log( 'Add to Cart: ' + data.add_to_cart );
						
						if( data.status === 'success' ) {
							if( Number( data.qty ) === 0 ) {
								tr.removeAttr( 'data-cart-item-key' );
							} else if( data.add_to_cart ) {
								tr.attr( 'data-cart-item-key', data.add_to_cart );
							}
							calcula_porcentagem_consumo_agua();
		                    $( document.body ).trigger( 'wc_fragment_refresh' );

						} else {
							console.log( 'Erro: ' + data.message );
						}
		                    // console.log('data: ' + data);
		            }).fail( function( xhr, status, error ) {
						console.log( 'xhr: ' + xhr );
						console.log( 'status: ' + status );
						console.log( 'error: ' + error );
					}).always(function(){
						$( '.calculadora-consumo-overlay' ).fadeOut();
					});
		        }

			}); // $(.lista-produtos-item-btn).click
		};


		var arredonda_1_casa = function( n ) {
			return Math.round( n * 10 ) / 10;
		};
		var atualiza_consumo_preenchido = function(){
			$( '#consumo-preenchido' ).change( function(){
				var valor = $( this ).val();
				var valor_exibicao = arredonda_1_casa( valor );
				$( '.consumo-preenchido' ).text( String( valor_exibicao ).replace( '.', ',') ) ;
				if( valor >= 100 ) {
					$( '.calculo-mensagem-alerta' ).hide();
					$( '.calculo-mensagem-ok' ).show();
					$('html, body').animate({
					        scrollTop: $( '#btn-finaliza-calculo' ).offset().top
					    }, 2000);
				} else {
					$( '.calculo-mensagem-ok' ).hide();
					$( '.calculo-mensagem-alerta' ).show();
				}
			});
		};

		var recalcular_btn = function() {
			$(' .recalcular-btn' ).click(function(e){
				e.preventDefault();
				$( '.lista-produtos' ).hide();
				$( '.calculadora-form' ).show();
			}); // $(.recalcular-btn).click
		};

		update_cart_calculo();
		atualiza_consumo_preenchido();
		recalcular_btn();

	}); // $(document).ready
});

var remove_produto_do_carrinho = function( obj ) {
	// e.preventDefault();
	if( jQuery( '.lista-produtos' ).length > 0 ) {
		var cart_item_key = jQuery( obj ).attr( 'data-cart_item_key' );
		var product_id = jQuery( obj ).attr( 'data-product_id' );
		jQuery( '#produto-' + product_id ).find( '.qty' ).val( 0 ).change();
	}
};
