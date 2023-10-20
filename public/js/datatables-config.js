// 獲取Laravel的語言代碼
var laravelLocale = "{{ app()->getLocale() }}";

// 定義不同語言的語言設定
var languageConfig = {
    "en": {
        search: 'Search', // 英文
        lengthMenu: "Show _MENU_ entries",
        info: "Showing _START_ to _END_ of _TOTAL_ entries",
        paginate: {
            "first": "First",
            "last": "Last",
            "next": "Next",
            "previous": "Previous"
        },
    },
    "zh": {
        search: '篩選', // 中文
        lengthMenu: "顯示 _MENU_項結果",
        info: "顯示第 _START_ 至 _END_ 項結果，共<span style='color: blue;font-size: 1.25rem;'> _TOTAL_ </span>項",
        paginate: {
            "first": "第一頁",
            "last": "最後一頁",
            "next": "下一頁",
            "previous": "上一頁"
        },
    }
};
// 根據Laravel的語言代碼獲取對應的語言設定，如果未找到，則使用默認的英文
var dataTableLanguage = languageConfig[laravelLocale] || languageConfig["en"];

// 設置DataTable的語言設定
var tableConfig = {
    language: dataTableLanguage,
    dom: 'lBfrtip',
    buttons: ['csv', 'excel', 'copy', 'print'],
    lengthMenu: [
        [10, 25, 50, -1],
        [10, 25, 50, "All"]
    ],
    responsive: true,
    order:[0, "desc"],
};