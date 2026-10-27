<?php

namespace App\Enums;

enum TaskStatus: string
{
    use EnumHelper;
    
    case Todo = 'todo';
    case InProgress = 'in_progress';
    case Done = 'done';
}
