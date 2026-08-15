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

    // update data 
    public function update($id)
    {
        global $db;
        $stmt = $db->prepare("UPDATE todos SET title=?, description=?, priority=?, status=?, due_time=? WHERE id=?");
        $stmt->bind_param(
            "sssssi",
            $this->title,
            $this->description,
            $this->priority,
            $this->status,
            $this->due_time,
            $id
        );
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // delete data 
    public function delete($id)
    {
        global $db;
        $stmt = $db->prepare("DELETE FROM todos WHERE id=?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
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


    public static function dashboardData()
    {
        global $db;
        //summary
        $sql = "SELECT COUNT(*) as total,
        SUM(status = 'pending') as pending,
        SUM(status = 'in_progress') AS in_progress,
            SUM(status = 'completed') AS completed
        FROM todos";
        $summaryResult = $db->query($sql);
        $summary = $summaryResult->fetch_assoc();

        // Recent Tasks
        $recentSql = "SELECT * FROM todos ORDER BY created_at DESC LIMIT 5";
        $recentResult = $db->query($recentSql);
        $recentTasks = [];
        if ($recentResult && $recentResult->num_rows > 0) {
            $recentTasks = $recentResult->fetch_all(MYSQLI_ASSOC);
        }

        return [
            "summary" => [
                "total"       => (int) $summary['total'],
                "pending"     => (int) $summary['pending'],
                "in_progress" => (int) $summary['in_progress'],
                "completed"   => (int) $summary['completed'],
            ],
            "recent_tasks" => $recentTasks
        ];
    }
}
