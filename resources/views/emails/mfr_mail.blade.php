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
        <th style="border: 1px solid black;padding: 1rem;text-align: center;">借出日期</th>
        <th style="border: 1px solid black;padding: 1rem;text-align: center;">預計歸還日</th>
        <th style="border: 1px solid black;padding: 1rem;text-align: center;">{{$msg}}</th>
    </tr>
    @foreach ($dueNumlist as $data)
    <tr>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NUM_BROW }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NAM_EMP }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->NAM_FACTS }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->COD_ITEM }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->QTY_BROW }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->DAT_BROW }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ $data->DAT_RRTN }}</td>
        <td style="border: 1px solid black;padding: 1rem;text-align: center;">{{ abs($data->DATE_GAP) }}</td>
    </tr>
    @endforeach
</table>


</body>

</html>