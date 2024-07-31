<div class="wrap_price_updater">
    <h1>Bulk Price Updater</h1>
    <form method="post" action="">
        <?php wp_nonce_field('bulk_price_update', 'bulk_price_update_nonce'); ?>
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
        <input type="submit" name="update_prices" value="Update Prices" class="button button-primary">
    </form>
</div>