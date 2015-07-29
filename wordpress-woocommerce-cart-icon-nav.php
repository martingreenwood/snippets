<?php

	// this function places a cart icon with number of 
	// items and total cost in the menu bar.

	function wcmenucart($menu, $args) {

		// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
		if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'top' !== $args->theme_location )
			return $menu;

		// turn on output buffering
		ob_start();

			// setup woocommerce
			global $woocommerce;

			// label vars
			$viewing_cart = __('View your shopping cart', 'theme_slug');
			$start_shopping = __('Start shopping', 'theme_slug');

			// get cart contents
			$cart_url = $woocommerce->cart->get_cart_url();

			// get the shop page link
			$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );

			// count the items in the cart
			$cart_contents_count = $woocommerce->cart->cart_contents_count;

			// build string
			$cart_contents = sprintf(_n('%d', '%d', $cart_contents_count, 'theme_slug'), $cart_contents_count);

			// get cart total
			$cart_total = $woocommerce->cart->get_cart_total();

			// uncomment the line below to hide nav menu cart item when there are no items in the cart
			// if ( $cart_contents_count > 0 ) {

				// build the li item
				if ($cart_contents_count == 0) {
					$menu_item = '<li class="cart_meniu_item"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
				} else {
					$menu_item = '<li class="cart_meniu_item"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
				}
				$menu_item .= '<div class="cart_icon"></div>';
				$menu_item .= '<div class="cart_contents">'.$cart_contents.'</div>';
				$menu_item .= '</a></li>';
			
			// Uncomment the line below to hide nav menu cart item when there are no items in the cart
			// }
			
			// echo it
			echo $menu_item;

		//  tet current buffer contents and delete current output buffer
		$social = ob_get_clean();

		// retunn menu
		return $menu . $social;

	}

	// add function to wp nav menu items filter
	add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);
