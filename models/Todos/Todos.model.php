<?php

class Todos
{
    public $id;
    public $title;
    public $description;
    public $priority;
    public $status;
    public $created_at;
    public $updated_at;

    public function __construct()
    {
        throw new \Exception('Not implemented');
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
}
