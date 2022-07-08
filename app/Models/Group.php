<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    const HEAD_GROUP_ID = 1;
    /**
     * @var bool
     */
    public $timestamps = false;




    public static function getDefaultGroupId(): int
    {
        $group = self::select('id')->where('default', true)->first();

        return $group ? $group->id : false;
    }

    /**
     * Является ли группа Руководители
     *
     * @return bool
     */

    public function isHead(): bool
    {
        return $this->id == self::HEAD_GROUP_ID;
    }
}
