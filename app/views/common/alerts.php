<?php 
$alertClass = "";
$alertContent = "";
if (isset($alerts['success'])) {
    $alertClass = "alert-success";
    $alertContent = $alerts['success'];
} elseif ($alerts['warning']) {
    $alertClass = "alert-warning";
    $alertContent = $alerts['warning'];
}
?>
<div class="alert <?php echo $alertClass;?> alert-dismissible fade show" role="alert">
    <?php echo $alertContent; ?>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>        
