<!DOCTYPE html>
<html lang={{ app()->getLocale() }}>

<head>

    @include('layouts/head')
</head>

<script>
    $(document).ready(function() {
        $('#ListData').DataTable();
    });
</script>


<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div id="loading">
        <img src="{{ asset('images/icon/loading.gif') }}" alt="Loading...">
    </div>
    <div class="page-container">
        @include('layouts/sidebar')
        <div class="main-content">
            @include('layouts/headerarea')
            <div class="main5">

                <div class="row" style="margin: 0;">
                    <div class="col-12" style="padding: 8px;">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">運送管理</h4>
                                <div class="form-row">
                                    <div class="col-md-2 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">運送方式</label>
                                        <select id="searchtype" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="select">select</option>
                                            <option value="air">空運</option>
                                            <option value="sea">海運</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label class="col-form-label" style="padding-top: 0;">棧板</label>
                                        <select id="pallet" class="form-control" style="padding: 0;height: calc(2.25rem + 10px);">
                                            <option value="select">select</option>
                                            <option value="W1200D1000">W1200D1000</option>
                                            <option value="W1200D800">W1200D800</option>
                                            <option value="W1100D1100">W1100D1100</option>
                                            <option value="W1100D1000">W1100D1000</option>
                                            <option value="W1220D1100">W1220D1100</option>
                                            <option value="W1140D1140">W1140D1140</option>
                                            <option value="W1103D800">W1103D800</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>運算</label>
                                        <div class="col">
                                            <button id="checkButton" class="btn btn-primary">結果</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                </div>
                            </div>
                            <div class="data-tables datatable-dark">
                                <table id="ListData" class="display text-center" style="width:100%">
                                    <thead class="text-capitalize" style=" background: darkgrey;">
                                        <th style="text-align: center;">選擇</th>
                                        <th style="text-align: center;">料號</th>
                                        <th style="text-align: center;">品名</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($shippingManagement as $item)
                                        <tr>
                                            <td> <input type="checkbox" class="form-check-input">
                                            <td>{{ $item->COD_ITEM}}</td>
                                            <td>{{ $item->NAM_ITEM}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="col-lg-6 mt-5">
        <div class="card">
            <div class="card-body">
                <!-- Modal -->
                <div class="modal fade" id="palletImg">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pallet Modal </h5>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                            </div>
                            <div class="modal-body">
                                <img id='palletImage' src="" alt="">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    var table;
    $(document).ready(function() {
        $('#loading').hide();
        var table = $('#ListData').DataTable({
            ...tableConfig,
            "pageLength": -1,
        });
        var selectedData = [];
        $('input[type="checkbox"]').change(function() {
            if ($(this).is(":checked")) {
                var codItem = $(this).closest("tr").find("td:nth-child(2)").text();
                var namItem = $(this).closest("tr").find("td:nth-child(3)").text();
                selectedData.push({
                    codItem: codItem,
                    namItem: namItem
                });
            } else {
                var codItem = $(this).closest("tr").find("td:nth-child(2)").text();
                var namItem = $(this).closest("tr").find("td:nth-child(3)").text();
                var indexToRemove = selectedData.findIndex(function(item) {
                    return item.codItem === codItem && item.namItem === namItem;
                });
                if (indexToRemove !== -1) {
                    selectedData.splice(indexToRemove, 1);
                }
            }
        });
        $('#checkButton').click(function() {
            var checkboxes = $('input[type="checkbox"]');
            var checkedCount = 0;
            var searchtype = $('#searchtype').val();
            var pallet = $('#pallet').val();
            checkboxes.each(function() {
                if ($(this).prop('checked')) {
                    checkedCount++;
                }
            });
            if (checkedCount > 0 && checkedCount <= 6 && checkedCount <= 6 && searchtype != 'select' && pallet != 'select') {
                $('#loading').show();
                sendAjax(selectedData, searchtype, pallet);
            } else {
                alert('選擇異常，請重新確認');
            }
        });

        function sendAjax(selectedData, searchtype, pallet) {
            $.ajax({
                type: "GET",
                url: "shippingManagementAjax",
                dataType: 'json',
                data: {
                    selectedData: selectedData,
                    searchtype: searchtype,
                    pallet: pallet
                },
                success: function(response) {
                    $('#loading').hide();
                    var imageUrl = "{{ asset('pallet') }}/" + response;
                    $('#palletImage').attr('src', imageUrl);
                    $('#palletImg').modal('show');
                },
                error: function(xhr, status, error) {
                    $('#loading').hide();
                    console.log('no data');

                }
            });
        }
    });
</script>

</html>