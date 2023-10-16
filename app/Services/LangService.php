<?php
namespace App\Services;

use App\Models\LangModel;

class LangService
{
    public function getLang($lang,$page)
    {
       
        $getLangData = LangModel::getLangData($lang,$page);
      
        
        
        $langArray = (object)[];
        foreach ($getLangData as $item) {
            $langArray->{$item->name} = $item->lang;
        }
       
       
        return $langArray;
    }

}
?>