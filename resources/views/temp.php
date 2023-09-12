Route::middleware(['web', 'auth:sanctum', 'verified'])->group(function () {
    //排行榜
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::any('/dashboardLeader', [DashboardController::class, 'dashboardLeader'])->name('dashboardLeader');
    //重新導向頁面
    Route::any('/redirect', [RedirectController::class, 'redirect'])->name('redirect');


    //MES
    Route::match(['get', 'post'], '/mesRepairProducts', [MesController::class, 'mesRepairProducts']);
    Route::match(['get', 'post'], '/mesModelList', [MesController::class, 'mesModelList']);
    Route::match(['get', 'post'], '/mesUploadList', [MesController::class, 'mesUploadList']);
    Route::match(['get', 'post'], '/mesUploadListAjax', [MesController::class, 'mesUploadListAjax']);
    Route::match(['get', 'post'], '/editFirmware', [MesController::class, 'editFirmware']);
    Route::match(['get', 'post'], '/delFirmwareAjax', [MesController::class, 'delFirmwareAjax']);
    Route::match(['get', 'post'], '/mesKickoffList', [MesController::class, 'mesKickoffList']);
    Route::match(['get', 'post'], '/mesCutsQuery', [MesController::class, 'mesCutsQuery']);
    Route::match(['get', 'post'], '/mesMonProductionList', [MesController::class, 'mesMonProductionList']);
    
    //設定
    Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');
    Route::post('/password/update', [PasswordController::class, 'showUpdateForm'])->name('password.update');
    Route::get('/password/update', [PasswordController::class, 'showUpdateForm'])->name('password.update');
    Route::match(['get', 'post'], '/userLoginLog', [SetupController::class, 'userLoginLog']);
    
});

