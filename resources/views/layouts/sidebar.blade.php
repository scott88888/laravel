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
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-palette"></i><span>{{ $sidebarLang->儀表板 }}</span></a>
                        <ul class="collapse">
                            <li id="dashboardLeaderBtn"><a href="dashboardLeader">{{ $sidebarLang->排行榜 }}</a></li>
                        </ul>
                    </li>
                    <li id="salesManagement">
                
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-grid3-alt"></i><span>{{ $sidebarLang->銷貨管理 }}</span></a>
                        <ul class="collapse">
                            <li id="mesMonProductionListBtn"><a href="mesMonProductionList">{{ $sidebarLang->訂單生產狀態查詢 }}</a></li>
                            <li id="mesShipmentListBtn"><a href="mesShipmentList">{{ $sidebarLang->出貨查詢 }}</a></li>
                            <li id="mesMfrListBtn"><a href="mesMfrList">{{ $sidebarLang->借品未歸還一覽表 }}</a></li>
                            <li id="shippingManagementBtn"><a href="shippingManagement">{{ $sidebarLang->運送管理 }}</a></li>
                            <li id="mesBOMBtn"><a href="mesBOM">{{ $sidebarLang->推估訂單BOM }}</a></li>
                        </ul>
                    </li>
                    <li id="documentSearch">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-layout-sidebar-left"></i><span>{{ $sidebarLang->生產管理 }}
                            </span></a>
                        <ul class="collapse">
                            <li id="mesUploadListBtn"><a href="mesUploadList">{{ $sidebarLang->韌體下載查詢 }}</a></li>
                            <li id="mesModelListBtn"><a href="mesModelList">{{ $sidebarLang->產品型號查詢 }}</a></li>
                            <li id="mesKickoffListBtn"><a href="mesKickoffList">{{ $sidebarLang->客製化申請單查詢 }}</a></li>
                            <li id="mesCutsQueryBtn"><a href="mesCutsQuery">{{ $sidebarLang->客戶代碼查詢 }}</a></li>
                            <li id="mesProductionResumeListBtn"><a href="mesProductionResumeList">{{ $sidebarLang->生產履歷查詢 }}</a></li>
                            <li id="mesHistoryProductionQuantityBtn"><a href="mesHistoryProductionQuantity">{{ $sidebarLang->歷史產品生產數量 }}</a></li>
                            <li id="mesRunCardListBtn"><a href="mesRunCardList">{{ $sidebarLang->生產流程卡查詢 }}</a></li>
                            <li id="mesRuncardListNotinBtn"><a href="mesRuncardListNotin">{{ $sidebarLang->未回報MES工單查詢 }}</a></li>
                            <li id="mesDefectiveListBtn"><a href="mesDefectiveList">{{ $sidebarLang->生產維修紀錄查詢 }}</a></li>
                            <li id="mesDefectiveRateBtn"><a href="mesDefectiveRate">{{ $sidebarLang->產品維修不良率分析 }}</a></li>
                            <li id="mesRepairNGListBtn"><a href="mesRepairNGList">{{ $sidebarLang->產線零件維修不良排行 }}</a></li>
                            <li id="mesBuyDelayBtn"><a href="mesBuyDelay">{{ $sidebarLang->入料逾期明細表 }}</a></li>
                            <li id="mesECNListBtn"><a href="mesECNList">{{ $sidebarLang->ECRECN查詢 }} </a></li> 
                        </ul>
                    </li>
                    <li id="RMA">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-wrench"></i><span>{{ $sidebarLang->RMA退貨管理 }}
                            </span></a>
                        <ul class="collapse">
                            <li id="RMAListBtn"><a href="RMAList">{{ $sidebarLang->RMA退貨授權查詢 }}</a></li>
                            <li id="RMAAnalysisBtn"><a href="RMAAnalysis">{{ $sidebarLang->RMA不良原因查詢 }}</a></li>
                        </ul>
                    </li>
                    <li id="fileCenter">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-folder"></i>
                            <span>{{ $sidebarLang->檔案管理 }}</span></a>
                        <ul class="collapse">
                            <li id="fileFirmwareUploadBtn"><a href="fileFirmwareUpload">{{ $sidebarLang->韌體上傳 }}</a></li>
                            <li id="fileECNEditBtn"><a href="fileECNEdit">{{ $sidebarLang->ECRECN新增 }}</a></li>
                        </ul>
                    </li>
                    <li id="inventoryList">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-file-excel-o"></i>
                            <span>{{ $sidebarLang->庫存管理 }}</span></a>
                        <ul class="collapse">
                            <li id="inventoryItemListBtn"><a href="inventoryItemList">{{ $sidebarLang->成品庫存查詢 }}</a></li>
                            <li id="inventoryItemPartListBtn"><a href="inventoryItemPartList">{{ $sidebarLang->料件庫存查詢 }}</a></li>
                            <li id="inventoryListUploadBtn"><a href="inventoryListUpload">{{ $sidebarLang->國外庫存上傳 }}</a></li>
                            <li id="inventoryListUS"><a href="inventoryList?country=US">{{ $sidebarLang->美國分公司庫存 }}</a></li>
                            <li id="inventoryListUK"><a href="inventoryList?country=UK">{{ $sidebarLang->英國分公司庫存 }}</a></li>
                            <li id="inventoryListAUS"><a href="inventoryList?country=AUS">{{ $sidebarLang->澳洲分公司庫存 }}</a></li>
                            <li id="inventoryListIT"><a href="inventoryList?country=IT">{{ $sidebarLang->義大利分公司庫存 }}</a></li>
                            <li id="inventoryListMY"><a href="inventoryList?country=MY">{{ $sidebarLang->馬來西亞分公司庫存 }}</a></li>
                        </ul>
                    </li>
                    <li id="setup">
                        <a href="javascript:void(0)" aria-expanded="true"><i class="ti-settings"></i>
                            <span>{{ $sidebarLang->使用者管理 }}</span></a>
                        <ul class="collapse">
                            <!-- <li id="updatePasswordBtn"><a href="showUpdateForm">{{ $sidebarLang->修改密碼 }}</a></li> -->
                            <li id="userLoginLogBtn"><a href="userLoginLog">{{ $sidebarLang->登入紀錄 }}</a></li>
                            <li id="userCheckPermissionBtn"><a href="userCheckPermission">{{ $sidebarLang->權限設定 }}</a></li>
                            <li id="userEditBtn"><a href="userEdit">{{ $sidebarLang->使用者列表刪除 }}</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>