<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{

    public function created(Task $task)
    {
        $task->createActivity('task_created');
    }

    public function deleted(Task $task)
    {
        $task->createActivity('task_deleted');
    }
}
