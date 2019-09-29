<?php
$formControlClass = "";
$value = "";
if (isset($source)) {
    $value = $source;
}
if (isset($errors) && count($errors) > 0) {
    if (isset($router->post[$name])) {
        $value = $router->post[$name];
    }
    $formControlClass = "is-valid";
    if (isset($errors[$name])) {
        $formControlClass = "is-invalid";
    }
}
?>
<?php if (isset($label)):?>
<label for="<?php echo $id; ?>"><?php echo $label;?></label>
<?php endif;?>
<?php if (in_array($type, ["text", "password"])):?>
<input type="<?php echo $type; ?>"
       class="form-control <?php echo $formControlClass; ?>"
       id="<?php echo $id; ?>"
       name="<?php echo $name; ?>"
       value="<?php echo $value; ?>"
       placeholder="<?php echo $placeholder; ?>">
<?php elseif ($type === "textarea"):?>
<textarea class="form-control <?php echo $formControlClass; ?>"
          id="<?php echo $id;?>"
          rows="4"
          name="<?php echo $name;?>"
          placeholder="<?php echo $placeholder;?>"><?php echo $value; ?></textarea>
        
<?php endif; ?>
<?php if (isset($errors[$name])): ?>
    <div class="invalid-feedback"><?php echo $errors[$name]; ?></div>
<?php endif; ?>

