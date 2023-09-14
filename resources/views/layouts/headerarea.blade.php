            <!-- header area start -->
            <div class="header-area">
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="refresh-view"><i class="fa fa-refresh"  style="font-size: 32px;"></i></li>
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <!-- <li class="settings-btn">
                                <i class="ti-settings"></i>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left">Dashboard</h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="index.html">Home</a></li>
                                <li><span>Datatable</span></li>
                                <span id="timeNow" style="font-size: large;">time</span>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                            <img class="avatar user-thumb" src="{{asset('images/author/avatar.png')}}" alt="avatar">
                            <h4 class="user-name dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }} <i class="fa fa-angle-down"></i></h4>
                            <div class="dropdown-menu">
                                <form method="POST" class="dropdown-item" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" class="btn btn-rounded btn-primary mb-3">{{ __('Log Out') }}</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
            <script>
                // 獲取要更新的元素
                var dateSpan = document.getElementById('timeNow');

                // 獲取當前日期
                var today = new Date();

                // 更新日期到元素內容
                dateSpan.textContent = '' + today.toLocaleDateString();
                $('#refresh-view').click(function() {
                    location.reload();
                });
            </script>