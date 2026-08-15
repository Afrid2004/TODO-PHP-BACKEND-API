<?php

class TodosApi
{
    public function index()
    {
        $todos = Todos::allTodos();
        if (!empty($todos)) {
            echo json_encode([
                "success" => true,
                "data"    => $todos
            ]);
        }
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $error = $this->validate($data);
        if ($error) {
            echo json_encode([
                "success" => false,
                "message" => $error
            ]);
            return;
        }
        $todos = new Todos();
        $todos->title = trim($data['title']);
        $todos->description = trim($data['description']);
        $todos->priority = trim($data['priority']);
        $todos->status = trim($data['status']);
        $todos->due_time = trim($data['due_time']);
        $success = $todos->save();
        if ($success) {
            echo json_encode([
                "success" => true,
                "message" => "Task created successfully",
            ]);
            return;
        }
        echo json_encode([
            "success" => false,
            "message" => "Failed to create task"
        ]);
    }

    public function find()
    {
        $id = intval($_GET['id'] ?? 0);
        $data = Todos::findTodo($id);
        if ($data) {
            echo json_encode(
                [
                    "success" => true,
                    "data"    => $data
                ]
            );
        } else {
            echo json_encode(
                [
                    "success" => false,
                    "message" => "Data not found"
                ]
            );
        }
    }

    private function validate($data)
    {
        $title = trim($data['title'] ?? '');
        $description = trim($data['description'] ?? '');
        $priority = trim($data['priority'] ?? '');
        $status = trim($data['status'] ?? '');
        $due_time = trim($data['due_time'] ?? '');

        if (empty($title)) {
            return "Title is required";
        }

        if (strlen($title) < 3) {
            return "Title must be at least 3 characters";
        }

        if (empty($description)) {
            return "Description is required";
        }

        if (strlen($description) < 3) {
            return "Description must be at least 3 characters";
        }

        if (!in_array($priority, ['low', 'medium', 'high'])) {
            return "Invalid priority";
        }

        if (!in_array($status, ['pending', 'in_progress', 'completed'])) {
            return "Invalid status";
        }

        if (empty($due_time)) {
            return "Due date and time is required";
        }

        return null;
    }
}
