<?php $this->layout('template') ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
    <a href="<?php echo $router->getBaseUrl(); ?>" class="btn btn-primary">К списку задач</a>
</nav>

<div class="container">
    <div class="card border-info mt-3 mx-auto" style="max-width: 20rem;">
        <div class="card-header"><h5 class="mb-0">Логин</h5></div>
        <div class="card-body text-info">
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
                        'placeholder' => 'Введите имя пользователя',
                        'router' => $router,
                        'errors' => $errors ?? null]);
                    ?>
                </div>

                <div class="form-group">
                    <?php
                    echo $this->insert('common/inputs', [
                        'type' => 'password',
                        'label' => 'Пароль',
                        'id' => 'password',
                        'name' => 'password',
                        'placeholder' => 'Введите пароль',
                        'router' => $router,
                        'errors' => $errors ?? null]);
                    ?>
                </div>

                <button type="submit" class="btn btn-success float-right">Войти</button>
            </form>

        </div>
    </div>

</div>

