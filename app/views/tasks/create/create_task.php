<?php $this->layout('template') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
    <a href="<?php echo $router->getBaseUrl(); ?>" class="btn btn-primary">Назад</a>
</nav>

<div class="container">
    <h1 class="text-center mt-2 mb-3">Добавить задачу</h1>
    <form accept-charset="UTF-8" 
          action="<?php echo $router->getFullUrl(); ?>"
          method="post"
          autocomplete="off">
        <div class="form-group">
            <?php echo $this->insert('common/inputs', [
                'type' => 'text',
                'label' => 'Имя пользователя',
                'id' => 'username',
                'name' => 'username',
                'placeholder' => 'Введите свой ник',
                'router' => $router,
                'errors' => $errors ?? null]);?>
        </div>

        <div class="form-group">
            <?php echo $this->insert('common/inputs', [
                'type' => 'text',
                'label' => 'Email адрес',
                'id' => 'email',
                'name' => 'email',
                'placeholder' => 'Введите E-mail',
                'router' => $router,
                'errors' => $errors ?? null]);?>
        </div>

        <div class="form-group">
            <?php echo $this->insert('common/inputs', [
                'type' => 'textarea',
                'label' => 'Задача',
                'id' => 'task',
                'name' => 'task',
                'placeholder' => 'Опишите задачу',
                'router' => $router,
                'errors' => $errors ?? null]);?>

        </div>
        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>

