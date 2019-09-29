<?php $this->layout('template', ['alerts' => $alerts]) ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
    <a href="<?php echo $router->getBaseUrl(); ?>" class="btn btn-primary">Назад</a>
</nav>

<div class="container">
    <h1 class="text-center mt-2 mb-3">Редактирование задачи ID: <?php echo $task['id']; ?></h1>
    <form accept-charset="UTF-8" 
          action="<?php echo $router->getFullUrl(); ?>"
          method="post"
          autocomplete="off">
        <div class="form-group">
            <?php
            echo $this->insert('common/inputs', [
                'type' => 'text',
                'label' => 'Имя пользователя',
                'id' => 'username',
                'name' => 'username',
                'placeholder' => 'Введите свой ник',
                'router' => $router,
                'source' => $task['username'],
                'errors' => $errors ?? null]);
            ?>
        </div>

        <div class="form-group">
            <?php
            echo $this->insert('common/inputs', [
                'type' => 'text',
                'label' => 'Email адрес',
                'id' => 'email',
                'name' => 'email',
                'placeholder' => 'Введите E-mail',
                'router' => $router,
                'source' => $task['email'],
                'errors' => $errors ?? null]);
            ?>
        </div>

        <div class="form-group">
            <?php
            echo $this->insert('common/inputs', [
                'type' => 'textarea',
                'label' => 'Задача',
                'id' => 'task',
                'name' => 'task',
                'placeholder' => 'Опишите задачу',
                'router' => $router,
                'source' => $task['task'],
                'errors' => $errors ?? null]);
            ?>
        </div>

        <div class="form-group">
            <?php
            echo $this->insert('common/checkbox', [
                'label' => 'Отметка о выполнении',
                'id' => 'is_done',
                'name' => 'is_done',
                'router' => $router,
                'source' => $task['is_done'],
                'errors' => $errors ?? null]);
            ?>
        </div>

        <button type="submit" class="btn btn-success">Сохранить</button>
    </form>
</div>

