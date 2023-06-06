<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;


class FileModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public static function fwindexInsert($data)
    {
        $value = DB::table('fw_index')->insert([
            'fw_id' => '',
            'version' =>  $data['lilinVersion'],
            'ai_ver' => $data['AI_Version'],
            'pantilt_ver' => '',
            'lens_ver' => $data['lensMCU'],
            'lens_parameter' => $data['lensISP'],
            'ipcam_lens_mcu' => '',
            'ipcam_lens_isp' => '',
            'p_ver' => '',
            'recovery_ver' => $data['rescueVersion'],
            'customer' => $data['searchClientType'],
            'customer_oem' => $data['customerName'],
            'model_customer' => $data['customerType'],
            'model_no' => $data['MOD'],
            'model_name' => $data['productName'],
            'product_type' => $data['searChproductType'],
            'file_kernel' => 'V',
            'file_kernel_url' => $data['file_kernel_url'],
            'file_app' => 'V',
            'file_app_url' => $data['file_app_url'],
            'file_note_text' => '',
            'file_note_text_url' => '',
            'file_note_pdf' => '',
            'file_note_pdf_url' => '',
            'file_other' => 'V',
            'file_other_url' => $data['file_other_url'],
            'file_report' => 'V',
            'file_report_url' => $data['file_report_url'],
            'ow_url' => '',
            'url' => 'upload/' .$data['dbInserturl'] . '/' .$data['dbInserturl'] . '.zip',
            'checksum' => '',
            'upload_date' => $data['upload_date'],
            'Remark' => $data['inspectionForm'],
            'upload_man' => $data['username'],
            'upload_man2' => '',
            'upload_date2' => '',
            'fw_status' => 0
        ]);
        return $value;
    }
}
