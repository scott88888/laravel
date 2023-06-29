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
    public static function getRMAMonList($search)
    {
        $value = DB::table('mes_rma_analysis')
        ->select('COD_ITEM', DB::raw('COUNT(*) AS COD_ITEM_Count'))
        ->where('DAT_ONCA', 'LIKE', $search.'%')
        ->groupBy('COD_ITEM')
        ->orderByDesc('COD_ITEM_Count')
        ->limit(10)
        ->get();
        return $value;
    }

    public static function getShipmentMon($day1, $day31)
    {
        
        $value = DB::select("SELECT SUM(QTY_DEL) as QTY ,mes_typ_item.TYP_CODE from mes_deld_shipment
        LEFT JOIN mes_typ_item ON mes_deld_shipment.TYP_ITEM = mes_typ_item.TYP_ITEM
        WHERE mes_deld_shipment.DAT_DEL >= $day1 AND mes_deld_shipment.DAT_DEL <= $day31
        GROUP BY TYP_CODE");
        return $value;
    }
    public static function getBorrowItem()
    {
        
        $value = DB::select("SELECT nam_emp, SUM(qty_brow) as total_qty
        FROM mes_mfr05_view
        WHERE cls_brow <> 6
        GROUP BY nam_emp
        ORDER BY total_qty DESC
        LIMIT 10");
        return $value;
    }
    public static function getUnsalableProducts()
    {
        
        $value = DB::select("SELECT * FROM mes_lcst_item WHERE qty_stk > 0 ORDER BY CAST(qty_stk AS UNSIGNED) DESC LIMIT 10");
        return $value;
    }
    public static function productionStatus()
    {
        $value = DB::select("SELECT *, COUNT(*) AS count
        FROM (
            SELECT tmp1.`runcard_no`, tmp1.`work_no`, tmp1.`version`, tmp1.`startTime`, tmp1.`NUM_PS`, tmp1.`COD_MITEM`, tmp1.`productionLine`, tmp1.`operation`, tmp2.remark2, tmp2.num_po, tmp2.qty_pcs
            FROM runcard tmp1, order_this_month tmp2
            WHERE tmp1.`startTime` LIKE '2023-06-19%'
              AND tmp1.`NUM_PS` = tmp2.`num_ps`
            GROUP BY tmp1.runcard_no
        ) AS temp_table
        GROUP BY work_no
        ORDER BY `startTime` DESC");
        return $value;
    }
}
   

