<?php foreach ($attrs as $key => $value) { ?>
    <div class='input-group'>
        <span class="input-group-addon" id="basic-addon1"><?php print($key) ?> : </span>
        <input type='text' name='attrs[<?php print($key) ?>]' value="<?php print($value) ?>" class="form-control"/>
        <span class='input-group-addon delFromAttrList'>[x]</span>
    </div>
<?php } ?>