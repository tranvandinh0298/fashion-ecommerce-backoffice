// Call the dataTables jQuery plugin
const DATATABLE = {
    filter: {},
    table: {},
    init: function (element, url, options) {
        element = $(element);
        if (element.length === 0) {
            console.log('Datatable not found');
            return false;
        }
        var limit = 10;
        var order = 1;
        options = typeof options === 'object' ? options : {};
        var options_default = {
            'ajax': {
                type: "GET",
                url: url,
                data: function (d) {
                    return $.extend({}, d, DATATABLE.filter);
                }
            },
            "language": {
                "oPaginate": {
                    "sFirst": '<i class="fa fa-chevron-double-left">',
                    "sPrevious": '<i class="fa fa-chevron-left">',
                    "sNext": '<i class="fa fa-chevron-right">',
                    "sLast": '<i class="fa fa-chevron-double-right">',
                }
            },
            "pageLength": limit,
            "fixedHeader": true,
            'bProcessing': true,
            'serverSide': true,
            "initComplete": function (settings, json) {
            },
            'order': [[order, 'desc']],

        };
        options_default.language["sInfo"] = "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ dòng";
        var options_table = Object.assign(options_default, options);
        DATATABLE.table = element.DataTable(options_table);

        return DATATABLE.table;
    },

    reload: function () {
        DATATABLE.table.ajax.reload(); //reload datatable ajax
    }
};
