<?php

namespace app\models;

defined('LOADED_FROM_INDEX') OR exit('No direct access allowed');

use \system\MModel;

/**
 * Model for tasks
 */
class Tasks extends MModel {

    const ROWS_PER_PAGE = 3;

    /**
     * Get Tasks for main page
     * @param int $page
     * @param array $sortOrder
     * @return array
     */
    public function getTasksk(int $page, array $sortOrder): array {
        $orderStr = "order by date_created desc";

        if (count($sortOrder) > 0) {
            $tmpSortArr = array_values($sortOrder);
            $orderStr = "order by " . $tmpSortArr[0];
        }

        $sql = "
            select a.*, b.name status_name
            from tasks a
            left join statuses b on a.status_id = b.id
            " . $orderStr . "
            limit " . ($page - 1) * self::ROWS_PER_PAGE . ", " . self::ROWS_PER_PAGE . "
        ";
        $res = $this->db
                ->query($sql)
                ->fetchAll(\PDO::FETCH_ASSOC);
        return $res;
    }

    /**
     * Get count pages for tasks
     * 
     * @return int
     */
    public function getTasksCountPages(): int {
        $sql = "
            select count(*) cnt
            from tasks 
        ";
        $res = $this->db
                ->query($sql)
                ->fetchAll(\PDO::FETCH_ASSOC);
        return (int) ceil($res[0]['cnt'] / self::ROWS_PER_PAGE);
    }

    /**
     * Get sort condition for task
     * 
     * @param \system\Router $router
     * @return array
     */
    public function getSortCondition(\system\Router $router): array {
        $query = $router->getQueryUrl();
        if (!isset($query['sort'])) {
            return [];
        }
        $possibleOrders = $this->getSortOrders();
        if (!array_key_exists($query['sort'], $possibleOrders)) {
            return [];
        }
        return [$query['sort'] => $possibleOrders[$query['sort']]];
    }

    /**
     * Return all possible types of task orders
     * 
     * @return array
     */
    public function getSortOrders(): array {
        return [
            1 => 'username asc',
            2 => 'email asc',
            3 => 'is_done asc',
            4 => 'username desc',
            5 => 'email desc',
            6 => 'is_done desc',
        ];
    }

    public function validateTask(\GUMP $gump, array $post) {
        $res = $gump->validation_rules([
            'username' => 'required|min_len,4',
            'email' => 'required|valid_email',
            'task' => 'required',
        ]);

        \GUMP::set_error_messages([
            'validate_required' => 'Поле %{field} обязательно для заполнения.',
            'validate_valid_email' => '%{field} должно быть адресом E-mail.',
            'validate_min_len' => '%{field} должно быть не короче 4-х символов.',
        ]);

        return $gump->run($post);
    }

    public function saveTask(\system\Router $router): int {
        $res = $this->db
                ->insert('tasks', [
            'username' => $router->post['username'],
            'email' => $router->post['email'],
            'task' => $router->post['task'],
            'task_hash' => md5($router->post['task']),
            'status_id' => 1,
            'is_done' => 0,
            'date_created' => date('Y-m-d H:i:s'),
            'date_updated' => date('Y-m-d H:i:s'),
        ]);

        $createdTaskId = $this->db->id();
        return (int) $createdTaskId;
    }

    public function getTaskForEdit(int $taskId): array {
        $sql = "
            select a.*, b.name status_name
            from tasks a
            left join statuses b on a.status_id = b.id
            where a.id=:id
        ";
        $res = $this->db
                ->query($sql, [":id" => $taskId])
                ->fetch(\PDO::FETCH_ASSOC);
        if ($res === false) {
            $res = [];
        }
        return $res;
    }

    public function validateEditTask(\GUMP $gump, array $post) {
        $res = $gump->validation_rules([
            'username' => 'required|min_len,4',
            'email' => 'required|valid_email',
            'task' => 'required',
        ]);

        \GUMP::set_error_messages([
            'validate_required' => 'Поле %{field} обязательно для заполнения.',
            'validate_valid_email' => '%{field} должно быть адресом E-mail.',
            'validate_min_len' => '%{field} должно быть не короче 4-х символов.',
        ]);

        return $gump->run($post);
    }

    public function updateTask(\system\Router $router, array $task) {
        $isDone = isset($router->post['is_done']) ? 1 : 0;

        $toUpdate = [
            'username' => $router->post['username'],
            'email' => $router->post['email'],
            'task' => $router->post['task'],
            'task_hash' => md5($router->post['task']),
            'is_done' => $isDone,
            'date_updated' => date('Y-m-d H:i:s'),
        ];

        if ($task['task_hash'] !== md5($router->post['task'])) {
            $toUpdate['status_id'] = '2';
        }

        $res = $this->db
                ->update('tasks', $toUpdate, ['id' => $task['id']]);

        return (int) $res;
    }

}
