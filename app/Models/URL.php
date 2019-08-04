<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class URL extends Model
{
    /**
     * 置操作表
     *
     * @var string
     */
    protected $table = 'urls';

    const A = 0;
    const B = 1;

    public static function B($userId)
    {
        return self::query()
            ->where('user_id', $userId)
            ->where('type', self::B)
            ->inRandomOrder()
            ->first()
            ->url;
    }

    public static function A($userId)
    {
        return self::query()
            ->where('user_id', $userId)
            ->where('type', self::A)
            ->inRandomOrder()
            ->first()
            ->url;
    }
}