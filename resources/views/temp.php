$lang = app()->getLocale();
$page ='mesModelList';
$langArray = $this->langService->getLang($lang,$page);
$page ='sidebar';
$sidebarLang = $this->langService->getLang($lang,$page);
return view('mesModelList', compact('MesModelList','langArray','sidebarLang'));




protected $langService;

public function __construct(LangService $langService)
{
$this->langService = $langService;
}

use App\Services\LangService;