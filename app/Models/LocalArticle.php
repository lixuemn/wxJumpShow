<?php
/**
 * Created by PhpStorm.
 * User: ALG
 * Date: 2019/3/7
 * Time: 18:27
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 本地文章数据库操作模型
 *
 * Class LocalArticle
 * @package App\Models
 */
class LocalArticle extends Model
{
    /*
      * 置操作表
      */
    protected $table = 'articles';


    /*
     * 全字段可写
     */
    protected $guarded = [];

    const OPEN = 1;

    const CLOSE = 0;
}