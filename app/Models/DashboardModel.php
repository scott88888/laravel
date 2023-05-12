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
        $value = DB::table('mes_mfr05_view')
            ->select('cod_item', DB::raw('SUM(qty_brow) as qty_brow'))
            ->where('cls_brow', '<>', 6)
            ->whereBetween('dat_brow', ['2023-01-01', '2023-10-31'])
            ->groupBy('cod_item')
            ->orderByDesc('qty_brow')
            ->limit(10)
            ->get();
        return $value;
    }


    public static function getProductStockList()
    {
        $value = DB::table('mes_lcst_item')
            ->select('COD_ITEM AS cod_item', DB::raw('CAST(QTY_STK AS UNSIGNED) AS qty_stk'))
            ->where('qty_stk', '>', 0)
            ->orderBy(DB::raw('CAST(QTY_STK AS UNSIGNED)'), 'desc')
            ->limit(10)
            ->get();



        return $value;
    }

    public static function getPartsStockList()
    {
        $value = DB::table('mes_lcst_parts')
            ->select('COD_ITEM AS cod_item', DB::raw('CAST(QTY_STK AS UNSIGNED) AS qty_stk'))
            ->where('qty_stk', '>', 0)
            ->orderBy(DB::raw('CAST(QTY_STK AS UNSIGNED)'), 'desc')
            ->limit(10)
            ->get();
        return $value;
    }

    public static function getBuyDelayList()
    {
        $value = DB::table('mes_purchase_overdue')
            ->select('*')
            ->whereNotNull('DAT_POR')
            ->where('DIFF_DAYS', '>', 0)
            ->where('DAT_REQ', '>', '20230101')
            ->orderBy('UN_QTY', 'desc')
            ->get();
        return $value;
    }
}
