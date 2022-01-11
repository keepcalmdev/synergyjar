<?php
function onecommunity_featured_products($atts, $content = null) {
ob_start();

    $meta_query  = WC()->query->get_meta_query();
    $tax_query   = WC()->query->get_tax_query();
    $tax_query[] = array(
        'taxonomy' => 'product_visibility',
        'field'    => 'name',
        'terms'    => 'featured',
        'operator' => 'IN',
    );

	// Setup your custom query
	$args = array(
		'post_type' => 'product',
    	'meta_query' => $meta_query,
    	'tax_query' => $tax_query
	);

$loop = new WP_Query( $args );

echo '<ul class="shortcode-featured-products products col-3">';

while ( $loop->have_posts() ) : $loop->the_post(); ?>

<li class="product">

    <?php
    global $product;
    $product_id = $product->get_id();

	echo '<a class="product-thumbnail" href="' . get_permalink($product_id) . '">' . woocommerce_get_product_thumbnail() . '</a>';

	echo '<div class="woocommerce-listing-item-content">';

	echo '<div class="woocommerce-listing-item-details">';

	echo '<span class="woocommerce-listing-item-cat">';
	echo wc_get_product_category_list($product_id);
	echo '</span>';

	woocommerce_template_loop_price();

	$rating = $product->get_average_rating();

	if($rating > 0.99 AND $rating < 1.74 ) {
		echo '<span class="product-rating rating-1"></span>';
	} elseif ($rating >= 1.75 AND $rating < 2.74) {
		echo '<span class="product-rating rating-2"></span>';
	} elseif ($rating >= 2.75 AND $rating < 3.74) {
		echo '<span class="product-rating rating-3"></span>';
	} elseif ($rating >= 3.75 AND $rating < 4.49) {
		echo '<span class="product-rating rating-4"></span>';
	} elseif ($rating >= 4.50) {
		echo '<span class="product-rating rating-5"></span>';
	}

	echo '</div><!-- woocommerce-listing-item-details -->';

	echo '<h2><a href="' . get_permalink($product_id) . '">' . $product->get_title() . '</a></h2>';
	?>

	</div><!-- woocommerce-listing-item-content -->

</li>

<?php endwhile; wp_reset_query(); // Remember to reset ?>
</ul>

<?php
$shortcode_content = ob_get_clean();
return $shortcode_content;

}

add_shortcode("onecommunity-featured-products", "onecommunity_featured_products");
