$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const deleteBtn = $('.dltBtn');
    console.log(deleteBtn);
    if ($(deleteBtn).length > 0) {
        $(deleteBtn).each(function () {
            $(this).on("click", function () {
                console.log("click");
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        });
    }
});

// Call the dataTables jQuery plugin
const DATATABLE = {
    filter: {},
    searchTimer: null,
    table: {},
    init: function (element, url, options) {
        element = $(element);
        if (element.length === 0) {
            console.log('Datatable not found');
            return false;
        }
        var limit = 10;
        var order = 0;
        options = typeof options === 'object' ? options : {};
        var options_default = {
            ajax: {
                type: "GET",
                url: url,
                data: function (d) {
                    return $.extend({}, d, DATATABLE.filter);
                }
            },
            language: {
                oPaginate: {
                    sFirst: '<i class="fa fa-chevron-double-left">',
                    sPrevious: '<i class="fa fa-chevron-left">',
                    sNext: '<i class="fa fa-chevron-right">',
                    sLast: '<i class="fa fa-chevron-double-right">',
                }
            },
            pageLength: limit,
            processing: true,
            serverSide: true,
            paginate: true,
            bInfo: true,
            searching: true,
            bSort: true,
            bLengthChange: true,
            initComplete: function (settings, json) {
                
                initSearchBox();

                initDeleteBtn();
            },
            order: [[order, 'desc']],

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

function initSearchBox() {
    if ($('[data-toggle="search-box"]').length > 0) {
        // Event listener for form inputs
        $('[data-toggle="search-box"]').on('input', function () {
            var searchData = []; // Object to store search data

            clearTimeout(DATATABLE.searchTimer);

            DATATABLE.searchTimer = setTimeout(function () {
                // Loop through all search inputs
                $('[data-toggle="search-box"]').each(function () {
                    var filterData = filterDataFormat(this);
                    if (filterData != undefined && filterData != null) { // Check if input value is not empty
                        searchData.push(filterData);
                    }
                });

                // Perform DataTable search with searchData object
                DATATABLE.table.search(JSON.stringify(searchData)).draw();
            }, 500);

        });
    }
}

function initDeleteBtn() {
    const deleteBtns = $('.dltBtn');
    if (deleteBtns.length > 0) {
        $(deleteBtns).each(function () {
            $(this).on("click", function (e) {
                e.preventDefault();
                console.log("click");
                var form = $(this).closest('form');
                var dataID = $(this).data('id');

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        });
    }
}

function filterDataFormat(element) {
    let key = $(element).attr('data-column').trim();
    let value = $(element).val().trim();
    if (key !== '' && key !== undefined && value !== '' && value != undefined) {
        return {
            key: key,
            operator: $(element).attr('data-operator').toUpperCase() ?? 'EQUAL',
            fieldType: $(element).attr('data-fieldtype').toUpperCase() ?? "STRING",
            value: value
        }
    }
}


