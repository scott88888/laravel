<!DOCTYPE html>
<html>

<body>

    <p>您好，提醒您的借品單 <span style="color: red;">{{$msg}}</span> ，請盡快處理。詳細規範內容請參照<span style="color: blue;">｢利凌企業股份有限公司設備借用辦法｣</span> 。</p>
    <table style="border-collapse: collapse; border: 1px solid black;">
        <tr>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">借品單號</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">業務員</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">客戶</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">產品</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">借出數量</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">實際歸還數量</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">借出日期</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">預計歸還日</th>
            <th style="border: 1px solid black;padding: 1rem;text-align: center;">逾期天數</th>
        </tr>
        @foreach ($dueNumlist as $data)
        <tr>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NUM_BROW }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NAM_EMP }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NAM_CUSTS }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->COD_ITEM }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->QTY_BROW }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->CNT_ARTN }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->DAT_BROW }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->DAT_RRTN }}</td>
            <td style="border: 1px solid black;padding: 1rem;text-align: center;">
                @if ($data->DATE_GAP < 8 && $data->DATE_GAP > 0 )
                    <p style="color:red">即將逾期</p>
                    @elseif ($data->DATE_GAP >= 8 )
                    <p style="color:blue">未逾期</p>
                    @else
                    <p style="color:red">{{abs($data->DATE_GAP)}}</p>
                    @endif
            </td>   
        </tr>
        @endforeach
    </table>


</body>

</html>