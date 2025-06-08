<?php

/**
 * Plugin Name: WooCommerce Credit Card Fee
 * Description: Automatically adds a 3% fee for credit card payments during checkout.
 * Version: 1.0
 * Author: Venkata Lakshmi Parimala
 */

// Hook into the cart calculation
add_action('woocommerce_cart_calculate_fees', 'add_credit_card_fee_conditionally');

function add_credit_card_fee_conditionally($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) return;

    // Check if a payment method is selected
    $chosen_gateway = WC()->session->get('chosen_payment_method');

    // You can add or replace these with your gateway slugs
    $credit_card_gateways = ['stripe'];

    if (in_array($chosen_gateway, $credit_card_gateways)) {
        $fee_percentage = 0.03;
        $fee = $cart->subtotal * $fee_percentage;
        $cart->add_fee(__('Credit Card Fee (3%)', 'woocommerce'), round($fee, 2), false);
    }
}

