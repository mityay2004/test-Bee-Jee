<?php $this->layout('template', ['alerts' => $alerts]) ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-end">
    <a href="/create_task" class="btn btn-success mr-3">Добавить задачу</a>
    <?php if ($auth->isAuthorized()):?>
    <a href="/logout" class="btn btn-primary">Логаут</a>
    <?php else:?>
    <a href="/login" class="btn btn-primary">Логин</a>
    <?php endif;?>
</nav>

<div class="container">
    <h1 class="text-center mt-2 mb-3">Общий список задач</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">
                    <span class="align-top">Имя пользователя</span>
                    <?php echo $this->insert(
                            'tasks/list/header_order',
                            ['sortAsc' => '1',
                                'sortDesc' => '4',
                                'router' => $router,
                                'uri' => $uri]);?>
                </th>
                <th scope="col">
                    <span class="align-top">E-mail</span>
                    <?php echo $this->insert(
                            'tasks/list/header_order',
                            ['sortAsc' => '2',
                                'sortDesc' => '5',
                                'router' => $router,
                                'uri' => $uri]);?>
                </th>
                <th scope="col"><span class="align-top">Задача</span></th>
                <th scope="col"><span class="align-top">Статус</span>
                    <?php echo $this->insert(
                            'tasks/list/header_order',
                            ['sortAsc' => '3',
                                'sortDesc' => '6',
                                'router' => $router,
                                'uri' => $uri]);?>
                </th>
                <?php if ($auth->isAuthorized()):?>
                <th></th>
                <?php endif;?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?php echo $task['username']; ?></td>
                    <td><?php echo $task['email']; ?></td>
                    <td>
                        <div><?php echo $task['task']; ?></div>
                        <?php if ($task['status_name'] !== "0"):?>
                        <div class="badge badge-success"><?php echo $task['status_name']; ?></div>
                        <?php endif;?>
                    </td>
                    <td>
                        <?php if ($task['is_done'] === '1'):?>
                        <span class="align-top text-success">выполнено</span>
                        <?php else:?>
                        <span class="align-top text-warning">не выполнено</span>
                        <?php endif;?>
                    </td>
                    <?php if ($auth->isAuthorized()):?>
                    <td>
                        <a href="/edit/<?php echo $task['id'];?>"
                          title="Редактировать"
                          class="align-top">
                            <i class="align-top fas fa-edit"></i>
                        </a>
                        
                    </td>
                    <?php endif;?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo $paginator;?>
</div>

