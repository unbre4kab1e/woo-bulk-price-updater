<div class="wrap_price_updater">
    <h1>Individual Price Updater</h1>
    <form method="post" action="">
        <?php wp_nonce_field('individual_price_update', 'individual_price_update_nonce'); ?>
        <label for="price_change">Enter Price Change:</label>
        <input type="number" id="price_change" name="price_change" step="0.01" required>
        <label for="change_type">Change Type:</label>
        <select id="change_type" name="change_type" required>
            <option value="percentage">Percentage</option>
            <option value="fixed">Fixed Amount</option>
        </select>
        <label for="price_type">Price Type:</label>
        <select id="price_type" name="price_type" required>
            <option value="regular">Regular Price</option>
            <option value="sale">Sale Price</option>
            <option value="both">Both</option>
        </select>
        <label for="operation_type">Operation:</label>
        <select id="operation_type" name="operation_type" required>
            <option value="add">Add</option>
            <option value="reduce">Reduce</option>
        </select>
        <label>Select Products:</label>
        <div id="product-list">
            <?php
            if (!empty($products_data)) {
                foreach ($products_data as $product) {
                    echo '<div>';
                    echo '<input type="checkbox" name="product_ids[]" value="' . esc_attr($product['id']) . '"> ';
                    echo esc_html($product['id']) . ' - ' . esc_html($product['name']) . ' ';
                    echo '(Regular Price: ' . esc_html($product['regular_price']) . ', Sale Price: ' . esc_html($product['sale_price']) . ')';
                    echo '</div>';
                }
            } else {
                echo 'No products found.';
            }
            ?>
        </div>
        <input type="submit" name="update_individual_prices" value="Update Prices" class="button button-primary">
    </form>
</div>