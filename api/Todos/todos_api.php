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
}
