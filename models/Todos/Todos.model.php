<?php

use BcMath\Number;

class Todos
{
    public $id;
    public $title;
    public $description;
    public $priority;
    public $status;
    public $due_time;
    public $created_at;
    public $updated_at;

    public function __construct() {}

    public function set($title, $description, $priority, $status, $due_time)
    {
        $this->title = $title;
        $this->description = $description;
        $this->priority = $priority;
        $this->status = $status;
        $this->due_time = $due_time;
    }

    public function save()
    {
        global $db;
        $sql = "INSERT INTO todos (title, description, priority, status, due_time) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('sssss', $this->title, $this->description, $this->priority, $this->status, $this->due_time);
        if (!$stmt) {
            return false;
        }
        if ($stmt->execute()) {
            $this->id = $db->insert_id;
            return true;
        }
        return false;
    }

    public static function allTodos()
    {
        global $db;
        $result = $db->query("SELECT * FROM todos ORDER BY id DESC");
        if ($result && $result->num_rows > 0) {
            return array_map(
                fn($item) => (object)$item,
                $result->fetch_all(MYSQLI_ASSOC)
            );
        }
        return [];
    }

    public static function findTodo($id)
    {
        global $db;
        $sql = "SELECT * FROM todos WHERE id=?";
        $stmt = $db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }
}
