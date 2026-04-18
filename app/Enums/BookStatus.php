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

    public function badgeClass(): string
    {
        return match($this){
            self::Unread  => 'bg-red-100 text-red-700 border-red-200',
            self::Reading => 'bg-blue-100 text-blue-700 border-blue-200',
            self::Done    => 'bg-green-100 text-green-700 border-green-200',
        };
    }
}
