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
}