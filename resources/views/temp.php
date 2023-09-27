columnDefs: [{
                    "targets": "_all",
                    "className": "dt-center"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 0,
                    "title": "BOM",
                },
                {
                    "data": "COD_ITEM",
                    "targets": 1,
                    "title": "產品照片"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 2,
                    "title": "產品型號"
                },
                {
                    "data": "COD_ITEM",
                    "targets": 3,
                    "title": "產品性質"
                },
                {
                    targets: [0, 1, 2, 3, 4], // 所在的 index（從 0 開始）
                    render: function(data, row, meta) {
                        switch (meta.col) {
                            case 0:
                                if (data.length > 0) {
                                    return '<a href="#" id="openModalButton" data-modal-value="' + data + '">' + bom_icon + '</a>';
                                    return button[0].outerHTML;
                                } else {
                                    return '';
                                }
                            case 1:
                                if (data.length > 0) {
                                    var imageUrl = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + row.model + '/' + row.model + '.jpg';
                                    var imageUrls = '{{ asset("/show-image/mesitempartlist/") }}' + '/' + row.model + '/' + row.model + '-s.jpg';
                                    return '<a href="' + imageUrl + '" target="_blank"><img style="max-width:100px;" src="' + imageUrls + '"></a>';
                                } else {
                                    return '';
                                }

                            case 2:
                                return data;
                            case 3:
                                return data;
                            case 4:
                                return '';
                            default:
                                return data;
                        }
                    }
                }
            ]