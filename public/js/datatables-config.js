// datatables-config.js

var tableConfig = {
    language: {
        search: '篩選', // 將搜尋文字改為中文
        Show:'顯示',
        entries:'條目',
        Showing :'條',
    },
    dom: 'lBfrtip',
    buttons: ['csv'],
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true
};
