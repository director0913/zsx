function getBaseUrl() {
    var currentUrl = window.location.toString().split('/');
    var baseUrl = currentUrl[0];
    for (i = 1; i < currentUrl.length - 2; ++i) {
        baseUrl += '/' + currentUrl[i];
    }
    return baseUrl;
}
var TableDatatablesAjax = function() {
  var datatableAjax = function(){
    dt = $('.dataTablesAjax');
		ajax_datatable = dt.DataTable({
			"processing": true,
      "serverSide": true,
      "searching" : true,
      "searchDelay": 800,
      "search": {
        "regex": true
      },
      "ajax": {
        'url' : getBaseUrl() + '/admin/templates/ajaxIndex',
      },
      "pagingType": "full_numbers",
      "orderCellsTop": true,
      "dom" : '<"html5buttons"B>lTfgitp',
      "buttons": [
        {extend: 'copy',title: 'user'},
        {extend: 'csv',title: 'user'},
        {extend: 'excel', title: 'user'},
        {extend: 'pdf', title: 'user'},
        {extend: 'print',
         customize: function (win){
            $(win.document.body).addClass('white-bg');
            $(win.document.body).css('font-size', '10px');
            $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
          }
        }
      ],
      "columns": [
        {
        	"data": "thumbnail_varchar",
        	"name" : "thumbnail_varchar",
      	},
        {
        	"data": "sceneid_bigint",
        	"name" : "sceneid_bigint",
        	"orderable" : false,
        },
        {
        	"data": "publishTime",
        	"name": "publishTime",
        	"orderable" : false,
        },
        {
        	"data": "is_show",
        	"name": "is_show",
        	"orderable" : true,
        },
        {
          "data": "actionButton",
          "name": "actionButton",
          "type": "html",
          "orderable" : false,
        },
    	],
      "drawCallback": function( settings ) {
        ajax_datatable.$('.tooltips').tooltip( {
          placement : 'top',
          html : true
        });
      },
      "language": {
        url: getBaseUrl() + '/admin/i18n'
      }
    });
  };
	return {
		init : datatableAjax
	}
}();
$(function () {
  TableDatatablesAjax.init();
});
