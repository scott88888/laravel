<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\mfrMall;
use DB;

class MailController extends Controller
{
    public function mailMFR()
    {
        $dayOfWeek = date("N");
        //逾期通知-------------------------------------
        //獲得標題 
        $subject = '【MES】' . date('m') . '月份。借品未歸還 | 逾期通知信 #稽核日' . date('Y-m-d');
        //取得未歸還名單
        $dueUserList = $this->getMfrOverdueUser();
        //獲得內容        
        foreach ($dueUserList as $key => $value) {
            $EMP_BROW = $value->EMP_BROW;
            // $EMP_BROW = 'E545';
            if ($value->COD_DPT == '0300' || $value->COD_DPT == '0350' || $value->COD_DPT == '0360' || $value->COD_DPT == '0400') {
                //獲得未歸還單號內容列表
                $dueNumlist = DB::select("SELECT * , DATEDIFF(`DAT_RRTN`, NOW()) AS DATE_GAP
                                            FROM `mes_mfrlist`
                                            WHERE `EMP_BROW` =  '$EMP_BROW'
                                            AND DAT_RRTN < NOW()
                                            ORDER BY `DAT_RRTN` DESC;");
            }
            //如果沒有資料 或六日 則該業務不用寄發通知信
            if (count($dueNumlist) == 0 || $dayOfWeek == 6 || $dayOfWeek == 7) {
                continue;
            } else {      
                $msg= '已逾期';                
                $result = $this->getMfrOverdueCC($EMP_BROW);
                //獲得主要收件人
                $recipients = $result['recipients'];                
                //獲得CC收件人
                $combinedRecipients = $result['combinedRecipients'];                
                //寄信
                $this->sendMail($msg,$dueNumlist, $recipients, $combinedRecipients, $subject);
            }
        };
      
        //即將到期通知-------------------------------------
        //獲得標題 
        $subject = '【MES】' . date('m') . '月份。借品即將到期 | 提醒通知。' . date('Y-m-d');
        //取得業務名單
        $dueUserList = $this->getMfrOverdueUser();

        //獲得內容        
        foreach ($dueUserList as $key => $value) {
           $EMP_BROW = $value->EMP_BROW;
            // $EMP_BROW = 'E545';  
            if ($value->COD_DPT == '0300' || $value->COD_DPT == '0350' || $value->COD_DPT == '0360' || $value->COD_DPT == '0400') {
                //獲得未歸還單號內容列表
                $dueNumlist = DB::select("SELECT * , DATEDIFF(`DAT_RRTN`, NOW()) AS DATE_GAP
                                            FROM `mes_mfrlist`
                                            WHERE `CLS_BROW` <> 6 AND `COD_DPT` > 0 AND DATEDIFF(`DAT_RRTN`, NOW())  = 7
                                            AND `EMP_BROW` = '$EMP_BROW'
                                            ORDER BY `DAT_RRTN` DESC;");
            }
            //如果沒有資料 或六日 則該業務不用寄發通知信
            if (count($dueNumlist) == 0 || $dayOfWeek == 6 || $dayOfWeek == 7) {
                continue;
            } else {
                $msg= '即將到期';            
                $result = $this->getMfrOverdueCC($EMP_BROW);
                //獲得主要收件人
                $recipients = $result['recipients'];
                //獲得CC收件人
                $combinedRecipients = $result['combinedRecipients'];
                //寄信
                $this->sendMail($msg,$dueNumlist, $recipients, $combinedRecipients, $subject);
            }
        };
    }


    public function sendMail($msg,$dueNumlist, $recipients, $combinedRecipients, $subject)
    {
        Mail::to($recipients)
            ->cc($combinedRecipients)
            ->send(new mfrMall($msg,$dueNumlist, $subject));
    }

    public function getMfrOverdueUser()
    {
        //需要通知的業務
        $saleList = array('E201', 'E220', 'E230', 'E235', 'E242', 'E802', 'E708', 'E712', 'E718', 'E303', 'E302', 'E205', 'E107', 'E150', 'E151', 'E152', 'E153');
        $saleListSql = '';
        for ($i = 0; $i < count($saleList); $i++) {
            $saleListSql .= "`EMP_BROW` = '" . $saleList[$i] . "' OR ";
        }
        $saleListSql = rtrim($saleListSql, ' OR');

        //取得未歸還名單 (測試使用第一筆而已 DESC limit 1 )
        $value = DB::select("SELECT *, DATEDIFF(`DAT_RRTN`, NOW()) AS DATE_GAP
        FROM `mes_mfrlist`
        WHERE ($saleListSql)
        GROUP BY `NAM_EMP`
        ");
        return $value;
    }

    public function getMfrOverdueCC($EMP_BROW)
    {
        //獲得收件者跟CC收件人列表
        $ccList = DB::select("SELECT *
        FROM `mes_mfrlist_mail`
        WHERE `employee_id` = '$EMP_BROW'");
        if ($ccList) {
            //獲得收件者
            $recipients = [
                $ccList[0]->email
            ];
            $ccRecipients = [];
            // 資料庫中的CC收件人
            $ccRecipientsFromDatabase = json_decode($ccList[0]->cc, true);
            // 合併CC收件人列表
            $combinedRecipients = array_merge($ccRecipients, $ccRecipientsFromDatabase);
            $result['recipients'] = $recipients;
            $result['combinedRecipients'] = $combinedRecipients;
            return $result;
        }
       
    }
}
