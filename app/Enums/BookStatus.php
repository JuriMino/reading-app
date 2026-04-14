<?php

namespace App\Enums;

enum BookStatus: string
{
    case Unread = 'unread';
    case Reading = 'reading';
    case Done = 'done';

    public function label(): string
    {
        return match($this){
            self::Unread => '未読',
            self::Reading => '読書中',
            self::Done => '読了',
        };
    }
}
