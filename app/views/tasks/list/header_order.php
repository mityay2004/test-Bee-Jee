<?php
$query = $router->getQueryUrl();
$hrefAsc = $uri->addGetParam($router->getFullUrl(), ['sort' => $sortAsc]);
$hrefDesc = $uri->addGetParam($router->getFullUrl(), ['sort' => $sortDesc]);

if (isset($query['sort'])) {
    if ($query['sort'] === $sortAsc) {
        $hrefAsc = $uri->removeGetParam($router->getFullUrl(), ['sort']);
    } elseif ($query['sort'] === $sortDesc) {
        $hrefDesc = $uri->removeGetParam($router->getFullUrl(), ['sort']);
    }
}
?>

<a href="<?php echo $hrefAsc;?>"
   title="<?php echo isset($query['sort']) && $query['sort'] === $sortAsc ? 'Убрать сортировку' : 'Клик для сортировки'; ?>"
   class="align-top ml-2">
    <i class="<?php echo isset($query['sort']) && $query['sort'] === $sortAsc ? 'active' : ''; ?> align-top fas fa-sort-alpha-up"></i>
</a>
<a href="<?php echo $hrefDesc;?>"
   title="<?php echo isset($query['sort']) && $query['sort'] === $sortDesc ? 'Убрать сортировку' : 'Клик для сортировки'; ?>"
   class="align-top ml-2">
    <i class="<?php echo isset($query['sort']) && $query['sort'] === $sortDesc ? 'active' : ''; ?> align-top fas fa-sort-alpha-down"></i>
</a>
