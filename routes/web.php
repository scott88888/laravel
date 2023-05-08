<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MesController;
use App\Http\Controllers\DashboardController;

//login
Route::match(['get', 'post'], '/login2', [LoginController::class, 'login2']);


//Dashboard
Route::match(['get', 'post'], '/index', [DashboardController::class, 'dashboardLeader']);
Route::match(['get', 'post'], '/dashboardLeader', [DashboardController::class, 'dashboardLeader']);


//MES
Route::match(['get', 'post'], '/mesRepairProducts', [MesController::class, 'mesRepairProducts']);
Route::match(['get', 'post'], '/mesModelList', [MesController::class, 'mesModelList']);
Route::match(['get', 'post'], '/mesUploadList', [MesController::class, 'mesUploadList']);
Route::match(['get', 'post'], '/mesItemList', [MesController::class, 'mesItemList']);
Route::match(['get', 'post'], '/mesItemPartList', [MesController::class, 'mesItemPartList']);
Route::match(['get', 'post'], '/mesKickoffList', [MesController::class, 'mesKickoffList']);
Route::match(['get', 'post'], '/mesCutsQuery', [MesController::class, 'mesCutsQuery']);
Route::match(['get', 'post'], '/mesMonProductionList', [MesController::class, 'mesMonProductionList']);
Route::match(['get', 'post'], '/mesMonProductionListAjax', [MesController::class, 'mesMonProductionListAjax']);
Route::match(['get', 'post'], '/mesProductionResumeList', [MesController::class, 'mesProductionResumeList']);
Route::match(['get', 'post'], '/mesProductionResumeListAjax', [MesController::class, 'mesProductionResumeListAjax']);
Route::match(['get', 'post'], '/mesHistoryProductionQuantity', [MesController::class, 'mesHistoryProductionQuantity']);
Route::match(['get', 'post'], '/mesMfrList', [MesController::class, 'mesMfrList']);
Route::match(['get', 'post'], '/mesRunCardList', [MesController::class, 'mesRunCardList']);
Route::match(['get', 'post'], '/mesRunCardListAjax', [MesController::class, 'mesRunCardListAjax']);
Route::match(['get', 'post'], '/mesRuncardListNotin', [MesController::class, 'mesRuncardListNotin']);
Route::match(['get', 'post'], '/mesRuncardListNotinAjax', [MesController::class, 'mesRuncardListNotinAjax']);
Route::match(['get', 'post'], '/mesDefectiveList', [MesController::class, 'mesDefectiveList']);
Route::match(['get', 'post'], '/mesDefectiveListAjax', [MesController::class, 'mesDefectiveListAjax']);
Route::match(['get', 'post'], '/mesDefectiveRate', [MesController::class, 'mesDefectiveRate']);
Route::match(['get', 'post'], '/mesDefectiveRateAjax', [MesController::class, 'mesDefectiveRateAjax']);
Route::match(['get', 'post'], '/mesRepairNGList', [MesController::class, 'mesRepairNGList']);
Route::match(['get', 'post'], '/mesRepairNGListAjax', [MesController::class, 'mesRepairNGListAjax']);
Route::match(['get', 'post'], '/mesBuyDelay', [MesController::class, 'mesBuyDelay']);
Route::match(['get', 'post'], '/mesBuyDelayAjax', [MesController::class, 'mesBuyDelayAjax']);
Route::match(['get', 'post'], '/mesECNList', [MesController::class, 'mesECNList']);
Route::match(['get', 'post'], '/mesRMAList', [MesController::class, 'mesRMAList']);
Route::match(['get', 'post'], '/mesRMAListAjax', [MesController::class, 'mesRMAListAjax']);
Route::match(['get', 'post'], '/mesRMAAnalysis', [MesController::class, 'mesRMAAnalysis']);
Route::match(['get', 'post'], '/mesRMAAnalysisAjax', [MesController::class, 'mesRMAAnalysisAjax']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');