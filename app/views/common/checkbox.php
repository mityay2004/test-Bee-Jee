<?php
$value = "";
if (isset($source) && !empty($source)) {
    $value = "checked";
}
if (isset($errors) && count($errors) > 0) {
    if (isset($router->post[$name])) {
        $value = "checked";
    } else {
        $value = "";
    }
}
?>

<div class="custom-control custom-checkbox">
    <input type="checkbox" 
           class="custom-control-input" 
           id="<?php echo $id; ?>"
           <?php echo $value;?>
           name="<?php echo $name; ?>">
    <label class="custom-control-label" for="<?php echo $id; ?>"><?php echo $label; ?></label>
</div>

