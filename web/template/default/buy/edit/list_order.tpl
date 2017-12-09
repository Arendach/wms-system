<?php foreach ($products as $product) { ?>
    <tr data-id="<?= $product->id ?>" class="product" data-pto="0">

        <td class="product_name">
            <?= $product->name ?>
        </td>

        <td>
            <?= $product->identefire_storage ?>
        </td>

        <td>
            <?= $product->articul ?>
        </td>

        <td class="price">
            <div class="input-group">
                <span class="input-group-addon remained"><?= $product->count_on_storage - 1 ?></span>
                <input name="amount" class="el_amount count form-control product_field" value="1">
                <input type="hidden" value="<?= $product->count_on_storage - 1 ?>" class="count_on_storage">
                <input type="hidden" class="amount_in_order" value="1">
            </div>
        </td>

        <td class="price">
            <input name="price" class="el_price count form-control product_field" value="<?= $product->costs ?>">
        </td>

        <td class="price">
            <input disabled class="el_sum count form-control" value="<?= $product->costs ?>">
        </td>

        <td class="attributes">
            <?php if (my_count(json_decode($product->attributes, 1)) > 0) {
                foreach (json_decode($product->attributes, 1) as $key => $attr) { ?>
                    <div>
                        <span><?= $key ?></span>
                        <select class="attributes" data-key="<?= $key ?>">
                            <?php foreach ($attr as $k => $v) { ?>
                                <option value="<?= $v ?>"><?= $v ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php }
            } ?>
        </td>

        <?php if ($type == 'sending') { ?>
            <td>
                <select class="place product_field" name="place">
                    <?php for ($i = 1; $i < 11; $i++) { ?>
                        <option name="place" value="<?= $i ?>"><?= $i ?></option>
                    <?php } ?>
                </select>
            </td>
        <?php } ?>

        <td>
            <button class="btn btn-danger btn-xs drop_product" data-id="remove">
                <span class="glyphicon glyphicon-remove"></span>
            </button>
        </td>

    </tr>
<?php } ?>
