// datatables-config.js

var tableConfig = {
    language: {
        search: '篩選', // 將搜尋文字改為中文
        lengthMenu: "顯示 _MENU_項結果",
        info: "顯示第 _START_ 至 _END_ 項結果，共<span style='color: blue;font-size: 1.25rem;'> _TOTAL_ </span>項",
        paginate: {
            "first": "第一頁",
            "last": "最後一頁",
            "next": "下一頁",
            "previous": "上一頁"
        },
    },
    dom: 'lBfrtip',
    buttons: ['csv', 'excel', 'copy', 'print'],
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true
};
