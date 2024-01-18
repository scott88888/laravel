<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorUserModel extends Model
{
    use HasFactory;
    protected $table = 'mes_vendor_users'; // 替換成你的資料表名稱
    protected $fillable = [
        'dealer_id',
        'password',
        // 其他可填充的欄位
    ];

    // 可以在這裡定義其他模型邏輯或關聯
}
