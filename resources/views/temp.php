<DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>
    
    @include('layouts/head')


</head>


<style>
    .chartdiv {
        width: 100%;
        height: 500px;
    }
</style>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div class="row">
            <div class="col-lg-4" style="padding: 2px;">
                        <div class="card">
                            <div class="card-body" style="padding: 0rem;">
                                <h4 class="header-title" style="text-align: center;margin: 10px 0;">過去12個月銷數量</h4>
                                <div id="amlinechart4"></div>
                                <div style="font-size: 12px;">AHD 攝影機|IPCAM|OEM/ODM攝影機|NVR|DHDDVR|OEM/ODM NVR/DVR|NAV
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
          
        </div>
        @include('layouts/footer')
    </div>
    @include('layouts/settings')
</body>
@include('layouts/footerjs')
<script src="assets/js/line-chart.js"></script>



</html>