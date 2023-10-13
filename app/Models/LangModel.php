<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use DB;


class LangModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    public static function getLangData($page)
    {

        $value = DB::select("SELECT * FROM mes_lang WHERE page = '$page'");

        return $value;
    }


   
}
