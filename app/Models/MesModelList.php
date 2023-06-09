<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;
use Carbon\Carbon;

class MesModelList extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public static function getModelListData()
    {
        //原SQL語法使用了GROUP BY子句，它將結果集中的行分組，每個組僅顯示一行。但是，它將不同版本的fw_index視為不同的組，因此可能會遺漏某些版本的fw_index。
        //新版的GROUP BY是要求查詢都必須放進去，才能執行
        //調整後如下，順利執行
        //     $value = DB::select("SELECT
        //     fw_index.customer,
        //     item_temp.COD_ITEM,
        //     item_temp.DSC_ITEM,
        //     item_temp.NAM_ITEM,
        //     item_temp.DAT_FILE,
        //     item_temp.DAT_USET,
        //     item_temp.DAT_SALED,
        //     eol_list.official_website2,
        //     fw_index.version,
        //     fw_index.file_app_url,
        //     eol_list.model,
        //     tb_product.is_enable,
        //     tb_product.urlTag,
        //     tb_product.fileGroup
        // FROM
        //     item_temp
        // LEFT JOIN (
        //     SELECT
        //         tmp1.model_name,
        //         tmp1.fw_id,
        //         tmp1.customer,
        //         tmp1.version,
        //         tmp1.file_app_url
        //     FROM
        //         fw_index tmp1,
        //         (
        //             SELECT
        //                 model_name,
        //                 MAX(fw_id) AS fw_id
        //             FROM
        //                 fw_index
        //             GROUP BY
        //                 model_name
        //         ) tmp2
        //     WHERE
        //         tmp1.model_name = tmp2.model_name
        //         AND tmp1.fw_id = tmp2.fw_id
        // ) AS fw_index ON item_temp.COD_ITEM = fw_index.model_name
        // LEFT JOIN eol_list ON item_temp.COD_ITEM = eol_list.model
        // LEFT JOIN tb_product ON item_temp.COD_ITEM = tb_product.urlTag
        // GROUP BY
        //     item_temp.COD_ITEM
        // ORDER BY
        //     fw_index.fw_id DESC
        //             ");
        $value = DB::table('mes_modellist')
            ->orderBy('COD_ITEM', 'asc')
            ->get();

        return $value;
    }


    public static function getUploadListData()
    {
        $value = DB::select("SELECT 
    fw_id, customer,
    model_no,
    model_customer,
    product_type,
    model_name,
    version,
    pantilt_ver,
    lens_ver,
    lens_parameter,
    ipcam_lens_isp,
    p_ver,
    recovery_ver,
    ai_ver,
    customer_oem,
    file_kernel,
    file_other_url,
    ow_url,
    file_report_url,
    file_kernel_url,
    file_app_url,
    file_app,
    file_note_text,
    file_note_pdf,
    file_note_text_url,
    file_note_pdf_url,
    upload_date,
    upload_man,
    upload_date2,
    Remark
    FROM fw_index AS t1
    WHERE upload_date <> '0000-00-00 00:00:00' AND fw_status = 0
    ORDER BY fw_id DESC");
        return $value;
    }



    public static function getItemListData()
    {
        $value = DB::table('mes_lcst_item')
            ->where('qty_stk', '!=', 0)
            ->orderBy('qty_stk', 'asc')
            ->get();
        return $value;
    }

    public static function getItemPartListData()
    {

        $value = DB::table('mes_lcst_parts')
            ->where('qty_stk', '!=', 0)
            ->orderBy('qty_stk', 'asc')
            ->get();
        return $value;
    }

    public static function getKickoffListData()
    {
        $value = DB::select("SELECT * FROM `kickoff` where upload_date ='2022-10-07' order by kickoff_No desc");
        return $value;
    }

    public static function getCutsQueryData()
    {
        $value = DB::select("SELECT * FROM CUST order by COD_CUST Asc");
        return $value;
    }

    public static function getMonProductionListAjax($type, $date)
    {
        if ($type == 'launchDate') {
            $value = DB::select("SELECT * FROM order_this_month WHERE dat_bega LIKE '$date%' ORDER BY dat_bega ASC");
        } else {
            $value = DB::select("SELECT * FROM order_this_month WHERE dat_ends LIKE '$date%' ORDER BY dat_ends ASC");
        }
        return $value;
    }
    public static function getProductionResumeListAjax($search, $searchtype)
    {
        $value = DB::table('mac_query')
            ->where($searchtype, 'like', '%' . $search . '%')
            ->orderBy('NUM_PS', 'asc')
            ->get();
        return $value;
    }
    public static function getHistoryProductionQuantity()
    {
        $value = DB::table('mes_historical_oroduct_output')
            ->orderBy('COD_ITEM', 'asc')
            ->get();
        return $value;
    }


    public static function getMesMfrList()
    {
        $value = DB::select("SELECT * ,datediff(`DAT_RRTN`,now()) as DATE_GAP FROM `mes_mfr05_view` WHERE `CLS_BROW` <> 6  ORDER BY `DAT_BROW` DESC");
        return $value;
    }

    public static function getRunCardList($first_day, $last_day)
    {
        if ($first_day && $last_day) {
            $value = DB::select("SELECT `PS1`, `NUM_PS`, `work_no`, `COD_MITEM`, `SEQ_MITEM`, `PS2`, `version`, `PS3`, `P2PKey`, `LPR_Key`, `COD_ITEM`, `SEQ_ITEM`, `SEQ_NO`, `startTime`, `productionLine`, `operation`
            FROM `runcard`
            WHERE `startTime` BETWEEN '$first_day' AND '$last_day'");
        }

        return $value;
    }
    public static function getRunCardListAjax($search, $searchtype)
    {
        if ($searchtype == 'thisyear') {
            $value = DB::select("SELECT `PS1`, `NUM_PS`, `work_no`, `COD_MITEM`, `SEQ_MITEM`, `PS2`, `version`, `PS3`, `P2PKey`, `LPR_Key`, `COD_ITEM`, `SEQ_ITEM`, `SEQ_NO`, `startTime`, `productionLine`, `operation`
                    FROM `runcard`
                    WHERE YEAR(`startTime`) = $search;");
        }
        if ($searchtype == 'NUM_PS' || $searchtype == 'runcard_no') {
            $value = DB::select("SELECT * FROM `runcard` WHERE `$searchtype` = '$search'");
        }

        return $value;
    }

    public static function getRuncardListNotinAjax($type, $date)
    {
        if ($type == 'launchDate') {
            $value = DB::select("SELECT * from order_this_month WHERE NUM_PS NOT IN (SELECT NUM_PS FROM runcard) and dat_bega LIKE '$date%'");
        } else {
            $value = DB::select("SELECT * from order_this_month WHERE NUM_PS NOT IN (SELECT NUM_PS FROM runcard) and dat_begs LIKE '$date%'");
        }
        return $value;
    }

    public static function getDefectiveListAjax($type, $date)
    {

        if ($type === 'PART_NO') {
            $date = base64_encode($date);
            $value = DB::select("SELECT a.*, b.description AS pc_desc, c.description AS comr_desc, d.cod_item AS Model ,
                                ROUND(TIME_TO_SEC(TIMEDIFF(TIM_END, TIM_BEG))/60) as TIMEDIFF 
                                FROM runcard_ng as a 
                                left join defective as b on a.cod_qc = b.item_no 
                                left join defective as c on a.STS_COMR = c.item_no 
                                left join pops as d on a.work_no = d.NUM_PS
                                where a.`$type`='$date'");
        } else {
            $value = DB::select("SELECT a.*, b.description AS pc_desc, c.description AS comr_desc, d.cod_item AS Model ,
                                ROUND(TIME_TO_SEC(TIMEDIFF(TIM_END, TIM_BEG))/60) as TIMEDIFF 
                                FROM runcard_ng as a 
                                left join defective as b on a.cod_qc = b.item_no 
                                left join defective as c on a.STS_COMR = c.item_no 
                                left join pops as d on a.work_no = d.NUM_PS
                                where a.`$type`='$date'");
        }
        return $value;
    }

    public static function getDefectiveRateAjax($date)
    {
        $value = DB::select("SELECT 
        `work_no`,
        GROUP_CONCAT(DISTINCT `model` SEPARATOR ', ') as model,
        GROUP_CONCAT(DISTINCT `version` SEPARATOR ', ') as version,
        GROUP_CONCAT(DISTINCT `order_qty` SEPARATOR ', ') as order_qty,
        LEFT(`runcard_no`,11) as GANO,
        COUNT(`ng_qty`) as ng_pcs,
        ROUND(COUNT(`ng_qty`) / `order_qty` * 100, 1) as ngRate
        FROM 
        runcard_ng_rate 
        WHERE 
        `num_comr` LIKE 'MR$date%'  
        GROUP BY runcard_ng_rate.work_no, runcard_ng_rate.order_qty, LEFT(runcard_ng_rate.runcard_no,11)");
        return $value;
    }

    public static function getRepairNGListAjax($date)
    {
    }
    public static function getBuyDelayAjax($searchtype)
    {
        if ($searchtype == 'MaterialDeliveryDate') {
            $value = DB::table('mes_purchase_overdue')
                ->whereNotNull('DAT_POR')
                ->where('DIFF_DAYS', '>', 0)
                ->orderBy('DAT_BUY', 'desc')
                ->get();
        } else {
            $value = DB::table('mes_purchase_overdue')
                ->whereNull('DAT_POR')
                ->orderBy('DAT_BUY', 'desc')
                ->get();
        }
        return $value;
    }
    public static function getMesECNList()
    {
        $value = DB::select("SELECT * FROM mes_ecrecn order by `createDate` desc");
        return $value;
    }
    public static function getRMAListAjax($searchtype, $search)
    {
        $value = DB::table('mes_rma_analysis')
            ->where($searchtype, 'like', $search . '%')
            ->orderBy('NUM_ONCA', 'asc')
            ->get();
        return $value;
    }
    public static function getRMAAnalysisAjax($searchtype, $search)
    {

        $value = DB::table('mes_rma_analysis')
            ->where($searchtype, 'like', $search . '%')
            ->orderBy('NUM_ONCA', 'asc')
            ->get();
        return $value;
    }

    public static function getShipmentListAjax($searchtype, $search, $rans, $rane)
    {

        if ($searchtype == 'DAT_DEL') {
            $value = DB::table('mes_deld_shipment')
                ->whereBetween('DAT_DEL', [$rans, $rane])
                ->orderBy('DAT_DEL', 'asc')
                ->get();
        } else {
            $value = DB::table('mes_deld_shipment')
                ->where($searchtype, 'like', '%' . $search . '%')
                ->orderBy('DAT_DEL', 'asc')
                ->get();
        }
        return $value;
    }

    public static function insertDelFile($directory,$data)
    {

        $del_time = Carbon::now();
        $value = DB::table('mes_del_file')->insert([
            'id' => '',
            'file_url' => $directory,
            'model' =>  $data[0]->model_customer,
            'del_time' => $del_time
        ]);
        return $value;
    }
}
