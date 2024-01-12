<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerUserModel extends Model
{
    use HasFactory;
    protected $table = 'dealer_users'; // 替換成你的資料表名稱
    protected $fillable = [
        'dealer_id',
        'password',
        // 其他可填充的欄位
    ];

    // 可以在這裡定義其他模型邏輯或關聯
}
