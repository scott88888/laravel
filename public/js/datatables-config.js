// datatables-config.js

var tableConfig = {
    language: {
        search: 'Filter' // 將搜尋文字改為中文
    },
    dom: 'lBfrtip',
    buttons: ['csv', 'excel', 'copy', 'print','pdf'],
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true
};
