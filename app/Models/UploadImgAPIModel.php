<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;



class UploadImgAPIModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public static function getJpgLog($target, $model)
    {

        $value = DB::table('mes_' . $target . '_uploadimg')
            ->where('first', '=', '1')
            ->where('model', '=', $model)
            ->get();

        return $value;
    }
}
