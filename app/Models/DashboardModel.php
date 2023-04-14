<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;

class DashboardModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public static function getMfrList()
    {
        $value = DB::select("SELECT `cod_item`, SUM(`qty_brow`) as qty_brow
        FROM `mfr05`
        WHERE `cls_brow` <> 6 AND `dat_brow` BETWEEN '2022-10-01' AND '2022-10-31'
        GROUP BY `cod_item`
        ORDER BY qty_brow DESC LIMIT 10;");
        return $value;
    }

    
    public static function getProductStockList()
    {
        $value = DB::select("SELECT 
        lcst_temp.cod_item,lcst_temp.nam_item,lcst_temp.dsc_allc,lcst_temp.dsc_alle,lcst_temp.cod_loc,lcst_temp.qty_stk,lcst_temp.ser_pcs, eol_list.official_website2 
        FROM `lcst_temp` 
        left JOIN eol_list on lcst_temp.COD_ITEM = eol_list.model 
        where lcst_temp.cod_item not REGEXP '^[0-9]' and lcst_temp.cod_loc ='GO-001' or lcst_temp.cod_loc ='WO-003' or lcst_temp.cod_loc ='LL-000'
        ORDER BY qty_stk DESC LIMIT 10;");
        return $value;
    }

    public static function getPartsStockList()
    {
        $value = DB::select("SELECT * FROM lcst_temp
        ORDER BY qty_stk DESC LIMIT 10;");
        return $value;
    }
   
}
