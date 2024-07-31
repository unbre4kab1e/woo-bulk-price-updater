<?php

class BulkPriceUpdater {
    public function __construct() {
        add_action('admin_menu', array($this, 'create_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
    }

    public function enqueue_styles() {
        wp_enqueue_style('bulk-price-updater-css', BPU_PLUGIN_URL . 'css/bulk-price-updater.css');
    }

    public function create_admin_menu() {
        add_menu_page(
            'Bulk Price Updater',
            'Bulk Price Updater',
            'manage_options',
            'bulk-price-updater',
            array($this, 'bulk_update_page'),
            'dashicons-update',
            20
        );

        add_submenu_page(
            'bulk-price-updater',
            'Individual Price Updater',
            'Individual Price Updater',
            'manage_options',
            'individual-price-updater',
            array($this, 'individual_update_page')
        );
    }

    public function bulk_update_page() {
        include BPU_PLUGIN_DIR . 'templates/bulk-update-page.php';
    }

    public function individual_update_page() {
        $products_data = $this->get_products_data();
        include BPU_PLUGIN_DIR . 'templates/individual-update-page.php';
    }

    private function get_products_data() {
        $products_data = array();
    
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );
        $products = new WP_Query($args);
    
        while ($products->have_posts()) {
            $products->the_post();
            $product_id = get_the_ID();
            $product = wc_get_product($product_id);
    
            if ($product) {
                $products_data[] = array(
                    'id' => $product_id,
                    'name' => get_the_title(),
                    'regular_price' => $product->get_regular_price(),
                    'sale_price' => $product->get_sale_price(),
                );
            }
        }
    
        wp_reset_postdata();
        return $products_data;
    }

    public function update_product_prices($price_change, $change_type, $price_type, $operation_type) {
        if (!current_user_can('manage_woocommerce')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );
        $products = new WP_Query($args);

        while ($products->have_posts()) {
            $products->the_post();
            $product_id = get_the_ID();
            $product = wc_get_product($product_id);

            if ($product) {
                if ($price_type === 'regular' || $price_type === 'both') {
                    $regular_price = $product->get_regular_price();
                    $new_regular_price = bpu_calculate_new_price($regular_price, $price_change, $change_type, $operation_type);
                    $product->set_regular_price($new_regular_price);
                }

                if ($price_type === 'sale' || $price_type === 'both') {
                    $sale_price = $product->get_sale_price();
                    if ($sale_price) {
                        $new_sale_price = bpu_calculate_new_price($sale_price, $price_change, $change_type, $operation_type);
                        $product->set_sale_price($new_sale_price);
                    }
                }

                $product->save();
            }
        }

        wp_reset_postdata();

        echo '<div class="notice notice-success is-dismissible"><p>Prices updated successfully!</p></div>';
    }

    public function update_individual_product_price($product_id, $price_change, $change_type, $price_type, $operation_type) {
        if (!current_user_can('manage_woocommerce')) {
            wp_die('You do not have sufficient permissions to access this page.');
        }

        $product = wc_get_product($product_id);

        if ($product) {
            if ($price_type === 'regular' || $price_type === 'both') {
                $regular_price = $product->get_regular_price();
                $new_regular_price = bpu_calculate_new_price($regular_price, $price_change, $change_type, $operation_type);
                $product->set_regular_price($new_regular_price);
            }

            if ($price_type === 'sale' || $price_type === 'both') {
                $sale_price = $product->get_sale_price();
                if ($sale_price) {
                    $new_sale_price = bpu_calculate_new_price($sale_price, $price_change, $change_type, $operation_type);
                    $product->set_sale_price($new_sale_price);
                }
            }

            $product->save();
            echo '<div class="updated"><p>Product ID ' . $product_id . ' price updated successfully!</p></div>';
        } else {
            echo '<div class="error"><p>Product ID ' . $product_id . ' not found!</p></div>';
        }
    }
}
