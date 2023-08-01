<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\MesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\AutoUpdateController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\MailController;
//API
use App\Http\Controllers\uploadImgAPIController;


Route::match(['get', 'post'], '/uploadImg', [uploadImgAPIController::class, 'upload']);
Route::match(['get', 'post'], '/showImg', [uploadImgAPIController::class, 'show']);


Route::get('/', [LogoutController::class, 'perform'])->name('logout.perform');
Route::fallback([LogoutController::class, 'perform']);
// Route::view('/temp', 'temp');
Route::match(['get', 'post'], '/temp', [MailController::class, 'mail']);

Route::match(['get', 'post'], '/mesAutoUpdate', [AutoUpdateController::class, 'mesAutoUpdate']);

Route::middleware(['web', 'auth:sanctum', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::any('/dashboardLeader', [DashboardController::class, 'dashboardLeader'])->name('dashboardLeader');
    Route::any('/redirect', [RedirectController::class, 'redirect'])->name('redirect');
    //MES
    Route::match(['get', 'post'], '/mesRepairProducts', [MesController::class, 'mesRepairProducts']);
    Route::match(['get', 'post'], '/mesModelList', [MesController::class, 'mesModelList']);
    Route::match(['get', 'post'], '/mesUploadList', [MesController::class, 'mesUploadList']);
    Route::match(['get', 'post'], '/mesUploadListAjax', [MesController::class, 'mesUploadListAjax']);
    Route::match(['get', 'post'], '/editFirmware', [MesController::class, 'editFirmware']);
    Route::match(['get', 'post'], '/delFirmwareAjax', [MesController::class, 'delFirmwareAjax']);
    Route::match(['get', 'post'], '/mesItemList', [MesController::class, 'mesItemList']);
    Route::match(['get', 'post'], '/mesItemPartList', [MesController::class, 'mesItemPartList']);
    Route::match(['get', 'post'], '/mesKickoffList', [MesController::class, 'mesKickoffList']);
    Route::match(['get', 'post'], '/mesCutsQuery', [MesController::class, 'mesCutsQuery']);
    Route::match(['get', 'post'], '/mesMonProductionList', [MesController::class, 'mesMonProductionList']);
    Route::match(['get', 'post'], '/mesMonProductionListAjax', [MesController::class, 'mesMonProductionListAjax']);
    Route::match(['get', 'post'], '/mesProductionResumeList', [MesController::class, 'mesProductionResumeList']);
    Route::match(['get', 'post'], '/mesProductionResumeListAjax', [MesController::class, 'mesProductionResumeListAjax']);
    Route::match(['get', 'post'], '/mesProductionResumeListDayAjax', [MesController::class, 'mesProductionResumeListDayAjax']);
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
    Route::match(['get', 'post'], '/mesRMAList', [MesController::class, 'mesRMAList']);
    Route::match(['get', 'post'], '/mesRMAListAjax', [MesController::class, 'mesRMAListAjax']);
    Route::match(['get', 'post'], '/mesRMAAnalysis', [MesController::class, 'mesRMAAnalysis']);
    Route::match(['get', 'post'], '/mesRMAAnalysisAjax', [MesController::class, 'mesRMAAnalysisAjax']);
    Route::match(['get', 'post'], '/mesRMAbadPartAjax', [MesController::class, 'mesRMAbadPartAjax']);
    Route::match(['get', 'post'], '/mesShipmentList', [MesController::class, 'mesShipmentList']);
    Route::match(['get', 'post'], '/mesShipmentListAjax', [MesController::class, 'mesShipmentListAjax']);

    //ECRECN
    Route::match(['get', 'post'], '/mesECNList', [MesController::class, 'mesECNList']);
    Route::match(['get', 'post'], '/editECRN', [MesController::class, 'editECRN']);
    Route::match(['get', 'post'], '/delECRNAjax', [MesController::class, 'delECRNAjax']);
    Route::match(['get', 'post'], '/fileECNEdit', [FileController::class, 'fileECNEdit']);
    Route::match(['get', 'post'], '/fileECRNEditAjax', [FileController::class, 'fileECRNEditAjax']);
    Route::match(['get', 'post'], '/fileECNCreateAjax', [FileController::class, 'fileECNCreateAjax']);
    Route::match(['get', 'post'], '/fileECRNEditPMAjax', [FileController::class, 'fileECRNEditPMAjax']);
    Route::post('/ECNuploadFile', [FileController::class, 'ECNuploadFile']);

    //檔案管理
    Route::match(['get', 'post'], '/fileFirmwareUpload', [FileController::class, 'fileFirmwareUpload']);
    Route::match(['get', 'post'], '/fileFirmwareUploadAjax', [FileController::class, 'fileFirmwareUploadAjax']);
    Route::get('/upload', [FileController::class, 'showUploadForm'])->name('upload.form');
    Route::post('/fileupload', [FileController::class, 'uploadFile']);
    
    //設定
    Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');
    Route::post('/password/update', [PasswordController::class, 'showUpdateForm'])->name('password.update');
    Route::get('/password/update', [PasswordController::class, 'showUpdateForm'])->name('password.update');
    Route::match(['get', 'post'], '/userLoginLog', [SetupController::class, 'userLoginLog']);

});
