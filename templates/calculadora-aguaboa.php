<?php
/**
 * Template name: Calculadora: AguaBoa.
 *
 * @package flatsome
 */

if(flatsome_option( 'pages_layout' ) != 'default' ) {
	
	// Get default template from theme options.
	echo get_template_part( 'page', flatsome_option( 'pages_layout' ) );
	return;

} else {

get_header();
do_action( 'flatsome_before_page' ); ?>

<div class="calculadora-consumo-wrapper">
	
	<div class="content-area page-wrapper calculadora-consumo-wrapper-pre" role="main">

		<div class="blockUI blockOverlay calculadora-consumo-overlay">
			<div class="processing calculadora-consumo-overlay-processing"></div>
		</div>

		<div class="row row-main">
			
			<div class="large-6 col">
				<div class="aguaboinha-wrapper">
					<div class="clearfix"></div>
					<div class="baloes">
						<img src="<?php echo CALCULADORA_URL; ?>assets/images/balao-ola.png" alt="<?php _e( 'Olá!', 'calculo-consumo-agua' ); ?>" class="balao calculo-content-pre">
						<img src="<?php echo CALCULADORA_URL; ?>assets/images/balao-boa.png" alt="<?php _e( 'Boa!', 'calculo-consumo-agua' ); ?>" class="balao calculo-content-pos">
					</div>
					<!-- /.baloes -->
					<img src="<?php echo CALCULADORA_URL; ?>assets/images/aguaboinha.png" alt="<?php _e( 'Agua Boínha', 'calculo-consumo-agua' ); ?>" class="aguaboinha">
				</div>
				<!-- /.aguaboinha-wrapper -->
			</div>
			<!-- /.large-6 col -->

			<div class="large-6 col">
				<div class="col-inner">					

					<div class="calculadora-consumo-wrapper-titles">
						<h2 class="calculadora-consumo-wrapper-title calculo-content-pre"><?php _e( 'Calcule quanta água seu corpo necessita por dia', 'calculo-consumo-agua' ); ?></h2>
						<h2 class="calculadora-consumo-wrapper-title calculo-content-pos"><?php _e( 'Seu consumo mensal é de:', 'calculo-consumo-agua' ); ?></h2>
					</div>

					<div class="clearfix m-b-40"></div>

					<div class="calculadora-consumo-wrapper-text">
						<p class="calculo-content-pre"><?php _e( 'Sabe aquela conversa que toda pessoa precisa consumir 2 litros de água diariamente? Não é bem assim. Cada pessoa necessita de uma quantidade específica. Informe seu peso abaixo e a Aguaboa irá calcular a quantidade ideal de água diária e mensal para você.', 'calculo-consumo-agua' ); ?></p>
					</div>
					<!-- /.calculadora-consumo-wrapper-text -->

					<div class="calculadora-form calculo-content-pre" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
						<?php /* ?>
						<input type="email" name="email" class="form-control" id="email" placeholder="<?php _e( 'Seu e-mail', 'calculo-consumo-agua' ); ?>">
						<?php */ ?>
						<input type="number" name="peso" class="calculadora-wrapper-form-control" id="peso" aria-describedby="pesoHelp" placeholder="<?php _e( 'Seu peso (em Kg)', 'calculo-consumo-agua' ); ?>">
						<button type="submit" class="btn button btn-primary btn-submit calculadora-wrapper-btn calcular-btn"><?php _e( 'Calcular', 'calculo-consumo-agua' ); ?></button>
					</div>
					<!-- /.calculadora-form -->
					
					<div class="clearfix m-b-200 calculo-content-pre"></div>

					<div class="calculadora-consumo-wrapper-text">
						<p class="calculo-content-pos"><?php _e( 'Selecione os produtos abaixo para preencher a sua quota de consumo mensal de água.', 'calculo-consumo-agua' ); ?></p>
					</div>
					<!-- /.calculadora-consumo-wrapper-text -->

					<div class="calculo-content-pos">
						<div class="consumo-mensal-wrapper">
							<span class="consumo-mensal-exibicao" id="consumo-mensal-exibicao">60</span> <span class="litros">litros</span>
						</div>
						<!-- /.consumo-mensal-wrapper -->
					</div>
					<!-- /.calculo-content-pos -->

					<div class="calculadora-consumo-wrapper-text calculo-content-pos">
						<a href="#" class="btn button btn-primary btn-submit calculadora-wrapper-btn recalcular-btn"><?php _e( 'Recalcular', 'calculo-consumo-agua' ); ?></a>
					</div>
					<!-- /.calculadora-consumo-wrapper-text -->

					<div class="clearfix m-b-20 calculo-content-pos"></div>

					<div class="calculo-content-pos">
						<img class="calculadora-consumo-wrapper-icon" src="<?php echo CALCULADORA_URL; ?>assets/images/seta-down.png" />
					</div>
					<!-- /.calculo-content-pos -->


					<div class="clearfix m-b-20 calculo-content-pos"></div>
					
				</div><!-- .col-inner -->
			</div><!-- .large-6 -->

		</div><!-- .row -->

	</div>
	<!-- /.content-area page-wrapper calculadora-consumo-wrapper-pre -->

	<div class="calculo-content-pos">
		<div class="content-area page-wrapper calculadora-consumo-wrapper-pos" role="main">
		
			<div class="row row-main">
		
				<div class="large-8 col">
					<div class="col-inner">
		
						<?php
							$lista_produtos = new Lista_Produtos();
							$produtos = $lista_produtos->get_wc_produtos();
							$produtos_no_carrinho = [];
							$consumo_mensal_total = isset( $_POST[ 'consumo_mensal_total' ] ) ? isset( $_POST[ 'consumo_mensal_total' ] ) : 1000;
							$calcula_porcentagem_ml = new Calcula_Porcentagem_Ml();
							// $utils->debug( $produtos );
						?>
		
						<?php if( $produtos ) : ?>
		
							<div class="lista-produtos">
								
								<input type="hidden" id="consumo-mensal-total" name="consumo_mensal_total" value="<?php echo $consumo_mensal_total; ?>" />
								<input type="hidden" id="consumo-preenchido" name="consumo_preenchido" value="0" />
		
								<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents lista-produtos-table" cellspacing="0">
									<thead>
										<tr>
											<th class="product-name" colspan="2"><?php _e( 'Product', 'woocommerce' ); ?></th>
											<th class="porcentagem-ml" colspan="1"><?php _e( '%', 'woocommerce' ); ?></th>
											<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
										</tr>
									</thead>
									<tbody>
		
										<?php
										foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
		
											$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
											$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
											$ml = get_post_meta( $product_id, 'calculo_cmb_number', true );
		
											if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :
		
												$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
												$produtos_no_carrinho[] = $product_id;
												?>
		
												<tr class="woocommerce-cart-form__cart-item lista-produtos-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>" data-ml="<?php echo $ml; ?>" data-prod-id="<?php echo $product_id; ?>" data-cart-item-key="<?php echo $cart_item_key; ?>" id="produto-<?php echo $product_id; ?>">
		
													<td class="product-thumbnail">
														<?php
														$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
		
														if ( ! $product_permalink ) {
															echo $thumbnail;
														} else {
															printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
														}
														?>
													</td>
		
													<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
														<?php
														if ( ! $product_permalink ) {
															echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
														} else {
															echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" style="color: #008285 !important;">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
														}
		
														// Meta data
														echo WC()->cart->get_item_data( $cart_item );
		
														// Backorder notification
														if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
															echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
														}
														?>
													</td>
													
													<td class="porcentagem-ml">
														<?php echo $calcula_porcentagem_ml->getPorcentagem( $consumo_mensal_total, $ml ); ?>
													</td>
		
													<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
														<?php
														if ( $_product->is_sold_individually() ) {
															$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
														} else {
															$product_quantity = woocommerce_quantity_input( array(
																'input_name'  => "cart[{$cart_item_key}][qty]",
																'input_value' => $cart_item['quantity'],
																'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
																'min_value'   => '0',
															), $_product, false );
														}
		
														echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
														?>
													</td>
		
												</tr>
		
											<?php endif;
		
										endforeach;
										?>
		
									<?php /* ?>
									</tbody>
									<thead>
										<tr>
											<th colspan="3"><h3 class="text-center"><?php _e( 'Adicionar outros Produtos', 'calculo-consumo-agua' ); ?></h3></th>
										</tr>
										<tr>
											<th class="product-name" colspan="2"><?php _e( 'Product', 'woocommerce' ); ?></th>
											<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
										</tr>
									</thead>
									<tbody>
									<?php */ ?>
		
										<?php foreach ($produtos as $produto) : ?>
		
											<?php
												$tem_no_carrinho = false;
												$post_id = $produto->get_ID();
												$nome = $produto->get_nome();
												$url = $produto->get_url();
												$img = $produto->get_img();
												$ml = $produto->get_ml();
											?>
		
											<?php foreach ($produtos_no_carrinho as $cart_prod_id) :
												if( $cart_prod_id == $post_id )
													$tem_no_carrinho = true;
											endforeach ?>
		
											<?php if( !$tem_no_carrinho ) : ?>
		
												<tr class="woocommerce-cart-form__cart-item lista-produtos-item" data-ml="<?php echo $ml; ?>" data-prod-id="<?php echo $post_id; ?>" id="produto-<?php echo $post_id; ?>">
		
													<td class="product-thumbnail">
														<?php
														$thumbnail = '<img src="' . $img . '" alt="' . $nome . '" class="lista-produtos-item-figure-img" />';
														if ( ! $url ) :
															echo $thumbnail;
														else :
															echo '<a href="' . $url . '">' . $thumbnail . '</a>';
														endif;
														?>
													</td>
		
													<td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
														<?php
														if ( ! $url ) :
															echo $nome . '&nbsp;';
														else :
															echo '<a href="' . $url . '" style="color: #008285 !important;">' . $nome . '</a>';
														endif;
														?>
		
													</td>	
		
													<td class="porcentagem-ml">
														<?php echo $calcula_porcentagem_ml->getPorcentagem( $consumo_mensal_total, $ml ); ?>
													</td>
		
													<td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
														<?php
														$args = array(
															'input_value' => '0',
														);
		
														$_product = wc_get_product( $post_id );
														woocommerce_quantity_input( $args, $_product );
														?>
													</td>
		
												</tr>
		
											<?php endif; ?>
		
												<?php /* ?>
		
												<div class="lista-produtos-item" id="produto-<?php echo $post_id; ?>" data-ml="<?php echo $ml; ?>" data-prod-id="<?php echo $post_id; ?>">
													<figure class="lista-produtos-item-figure">
														<img src="<?php echo $img; ?>" alt="<?php echo $nome ?>" class="lista-produtos-item-figure-img" />
													</figure>
													<!-- /.lista-produtos-item-figure -->
													<h4 class="lista-produtos-item-titulo"><?php echo $nome; ?></h4>
													<div class="porcentagem-consumo-mensal"><span class="porcentagem-consumo-mensal-valor"></span><span class="porcentagem-consumo-mensal-unidade">%</span></div>
													<button class="btn button btn-default lista-produtos-item-btn"><?php _e( 'Selecionar', 'calculo-consumo-geral' ); ?></button>
												</div>
												<!-- /.lista-produtos-item -->
		
												<?php */ ?>
											
										<?php endforeach; ?>
		
									</tbody>
								</table>
		
								<div class="calculadora-consumo-wrapper-sidebar calculadora-consumo-wrapper-sidebar-horizontal">
									<img class="calculadora-consumo-wrapper-icon" src="<?php echo CALCULADORA_URL; ?>assets/images/aguaboinha-small.png" />
									<div class="clearfix m-b-40"></div>
									<div class="calculadora-consumo-wrapper-sidebar-text">
										<p><?php _e( 'Atualmente você está com', 'calculo-consumo-agua' ); ?> <strong><span class="consumo-preenchido-wrapper"><span class="consumo-preenchido">0</span>%</span></strong> <?php _e( 'do seu consumo mensal preenchido.', 'calculo-consumo-agua' ) ?></p>
									</div>
									<!-- /.calculadora-consumo-wrapper-sidebar-text -->
										<a id="btn-finaliza-calculo" class="button primary mt-0 pull-left small calculadora-consumo-wrapper-sidebar-btn" href="<?php echo wc_get_cart_url(); ?>"><span class="d-b-i"><?php _e( 'Fechar', 'calculo-consumo-agua' ); ?></span><span class="d-b-i"><?php _e( 'pedido', 'calculo-consumo-agua' ); ?></span></a>
								</div>
								<!-- /.calculadora-consumo-wrapper-sidebar -->
		
							</div>
							<!-- /.lista-produtos -->
						
						<?php endif; ?>
		
						
					</div>
					<!-- /.col-inner -->
				</div>
				<!-- /.large-8 col -->
		
				<div class="large-4 col">
					<div class="calculadora-consumo-wrapper-sidebar">
						<img class="calculadora-consumo-wrapper-icon" src="<?php echo CALCULADORA_URL; ?>assets/images/aguaboinha-small.png" />
						<div class="clearfix m-b-40"></div>
						<div class="calculadora-consumo-wrapper-sidebar-text">
							<p><?php _e( 'Atualmente você está com', 'calculo-consumo-agua' ); ?> <strong><span class="consumo-preenchido-wrapper"><span class="consumo-preenchido">0</span>%</span></strong> <?php _e( 'do seu consumo mensal preenchido.', 'calculo-consumo-agua' ) ?></p>
							<a id="btn-finaliza-calculo" class="button primary mt-0 pull-left small calculadora-consumo-wrapper-sidebar-btn" href="<?php echo wc_get_cart_url(); ?>"><span class="d-b-i"><?php _e( 'Fechar', 'calculo-consumo-agua' ); ?></span><span class="d-b-i"><?php _e( 'pedido', 'calculo-consumo-agua' ); ?></span></a>
							<div class="clearfix"></div>
						</div>
						<!-- /.calculadora-consumo-wrapper-sidebar-text -->
					</div>
					<!-- /.calculadora-consumo-wrapper-sidebar -->
		
				</div>
				<!-- /.large-4 col -->
			</div><!-- .row -->
		</div>
		<!-- /.calculadora-consumo-wrapper-pos -->
	</div>
	<!-- /.calculo-content-pos -->

</div>
<!-- /.calculadora-consumo-wrapper -->

<?php
do_action( 'flatsome_after_page' );
get_footer();

}

?>