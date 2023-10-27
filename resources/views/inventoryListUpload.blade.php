<!DOCTYPE html>


<head>

    @include('layouts/head')
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div>



            </div>
            <div class="main5">
                <div class="row">
                    <div class="col-12 mt-1">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">{{ $langArray->分公司庫存上傳 }}</h4>
                                <div class="form-row">
                                    <div class="col-5" style="padding:0, 1rem;">
                                        <span class="ti-upload">{{ $langArray->庫存CSV }}</span>
                    
                                        <input id="firmwareOS_Name" style="display: none;">
                                        <form action="{{ route('importCsv') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-group mb-3">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="csv_file" accept=".csv" onchange="updateFileName(this,'csvname')">
                                                    <label class="custom-file-label" id="csvname">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <select id="country" class="form-control" name="country" style="padding: 0;height: calc(2.25rem + 8px);">
                                                        <option value="country">{{ $langArray->國家 }}</option>
                                                        <option value="US">{{ $langArray->美國 }}</option>
                                                        <option value="UK">{{ $langArray->英國 }}</option>
                                                        <option value="AUS">{{ $langArray->澳洲 }}</option>
                                                        <option value="IT">{{ $langArray->義大利 }}</option>
                                                        <option value="MY">{{ $langArray->馬來西亞 }}</option>
                                                    </select>
                                                </div>
                                                <div class="input-group-append">
                                                    <button id="submitBtn" class="input-group-text" type="submit" style="font-size:0.75rem">{{ $langArray->上傳CSV }}</button>
                                                </div>
                                            </div>

                                        </form>

                                    </div>

                                    <div class="col-md-1" style="padding:0, 1rem;margin-left: 5%;">
                                        <label style="display: inline;">{{ $langArray->範例 }}</label>
                                        <div class="col" style="text-align: center;">
                                            <a href="{{ asset('ex.csv') }}" download>
                                                <button type="button" class="btn btn-success mb-3">{{ $langArray->下載 }}</button>
                                            </a>
                                        </div>
                                    </div>

                                </div>

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

<script>
    $(document).ready(function() {
        // 預設禁用按鈕
        $('#submitBtn').prop('disabled', true);

        // 監聽 select 元素的改變事件
        $('#country').change(function() {
            const selectedValue = $(this).val();

            // 根據選擇的值啟用或禁用按鈕
            if (selectedValue === '' || selectedValue === 'country') {
                $('#submitBtn').prop('disabled', true);
            } else {
                $('#submitBtn').prop('disabled', false);
            }
        });
    });

    function updateFileName(input, labelId) {
        var fileName = input.files[0].name;
        var label = document.getElementById(labelId);
        label.innerHTML = "<span style='color: red;'>" + fileName + " (尚未上傳)</span>";
    }
</script>

</html>