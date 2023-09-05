<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href=""><img src="{{ asset('images/icon/Logo_40x280.png') }}" alt="logo"></a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">
                    <li id="dashBoard">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-palette"></i><span>儀表板</span></a>
                        <ul class="collapse">
                            <!-- <li><a href="">戰情室</a></li> -->
                            <li id="dashboardLeaderBtn"><a href="dashboardLeader">排行榜</a></li>
                        </ul>
                    </li>
                    <li id="documentSearch">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>文件查詢/下載
                            </span></a>
                        <ul class="collapse">
                            <!-- <li id="mesRepairProductsBtn"><a href="mesRepairProducts">維修不良查詢</a></li> -->
                            <li id="mesUploadListBtn"><a href="mesUploadList">韌體下載查詢</a></li>
                            <li id="mesModelListBtn"><a href="mesModelList">產品型號查詢</a></li>
                            <!-- <li id="mesItemListBtn"><a href="mesItemList">成品庫存查詢</a></li>
                            <li id="mesItemPartListBtn"><a href="mesItemPartList">料件庫存查詢</a></li> -->
                            <li id="mesKickoffListBtn"><a href="mesKickoffList">客製化申請單查詢</a></li>
                            <li id="mesCutsQueryBtn"><a href="mesCutsQuery">客戶代碼查詢</a></li>
                            <li id="mesMonProductionListBtn"><a href="mesMonProductionList">訂單生產狀態查詢</a></li>
                            <li id="mesProductionResumeListBtn"><a href="mesProductionResumeList">生產履歷查詢</a></li>
                            <li id="mesHistoryProductionQuantityBtn"><a href="mesHistoryProductionQuantity">歷史產品生產數量</a></li>
                            <li id="mesMfrListBtn"><a href="mesMfrList">借品未歸還一覽表</a></li>
                            <li id="mesRunCardListBtn"><a href="mesRunCardList">生產流程卡查詢</a></li>
                            <li id="mesRuncardListNotinBtn"><a href="mesRuncardListNotin">未回報MES工單查詢</a></li>
                            <li id="mesDefectiveListBtn"><a href="mesDefectiveList">生產維修紀錄查詢</a></li>
                            <li id="mesDefectiveRateBtn"><a href="mesDefectiveRate">產品維修不良率分析</a></li>
                            <li id="mesRepairNGListBtn"><a href="mesRepairNGList">產線零件維修不良排行</a></li>
                            <li id="mesBuyDelayBtn"><a href="mesBuyDelay">入料逾期明細表</a></li>
                            <li id="mesECNListBtn"><a href="mesECNList">ECR/ECN查詢</a></li>

                            <li id="mesShipmentListBtn"><a href="mesShipmentList">出貨查詢</a></li>
                        </ul>
                    </li>
                    <li id="RMA">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-wrench"></i><span>RMA
                            </span></a>
                        <ul class="collapse">
                            <li id="RMAListBtn"><a href="RMAList">RMA退貨授權查詢</a></li>
                            <li id="RMAAnalysisBtn"><a href="RMAAnalysis">RMA不良原因查詢</a></li>
                        </ul>
                    </li>
                    <!-- <li id="aiQuery">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-comments-smiley"></i><span>AI 權重查詢</span></a>
                        <ul class="collapse">
                            <li id="aiQuerySearch"><a href="fontawesome.html">AI 權重查詢</a></li>
                        </ul>
                    </li> -->
                    <!-- <li id="fileCenter">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-folder"></i>
                            <span>RMA管理</span></a>
                        <ul class="collapse">
                            <li id="mesECNListBtn"><a href="mesECNList">ECR/ECN查詢</a></li>
                            <li id="mesRMAListBtn"><a href="mesRMAList">RMA退貨授權查詢</a></li>
                        </ul>
                    </li> -->

                    <li id="fileCenter">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-folder"></i>
                            <span>檔案管理</span></a>
                        <ul class="collapse">
                            <li id="fileFirmwareUploadBtn"><a href="fileFirmwareUpload">韌體上傳</a></li>
                            <li id="fileECNEditBtn"><a href="fileECNEdit">ECR/ECN新增</a></li>
                        </ul>
                    </li>
                    <li id="inventoryList">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-file-excel-o"></i>
                            <span>庫存表</span></a>
                        <ul class="collapse">
                            <li id="inventoryItemListBtn"><a href="inventoryItemList">成品庫存查詢</a></li>
                            <li id="inventoryItemPartListBtn"><a href="inventoryItemPartList">料件庫存查詢</a></li>
                            <li id="inventoryListUpload"><a href="inventoryListUpload">國外庫存上傳</a></li>
                            <li id="inventoryListUS"><a href="inventoryList?country=US">美國分公司庫存</a></li>
                            <li id="inventoryListUK"><a href="inventoryList?country=UK">英國分公司庫存</a></li>
                            <li id="inventoryListAUS"><a href="inventoryList?country=AUS">澳洲分公司庫存</a></li>
                            <li id="inventoryListIT"><a href="inventoryList?country=IT">義大利分公司庫存</a></li>
                            <li id="inventoryListMY"><a href="inventoryList?country=MY">馬來西亞分公司庫存</a></li>
                        </ul>
                    </li>
                    <li id="setup">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>設定</span></a>
                        <ul class="collapse">
                            <li id="updatePasswordBtn"><a href="{{ route('password.update') }}">修改密碼</a></li>
                            <li id="userLoginLogBtn"><a href="userLoginLog">登入紀錄</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>