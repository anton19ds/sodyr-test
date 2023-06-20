/*!
 * Ajax Crud
 * =================================
 * Use for johnitvn/yii2-ajaxcrud extension
 * @author John Martin john.itvn@gmail.com
 */
var tableToExcel = (function() {
    var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/html; charset=UTF-8"/></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { 
            return s.replace(/{(\w+)}/g, function(m, p) { 
                return c[p]; 
            })
        }
    , downloadURI = function(uri, name) {
        var link = document.createElement("a");
        link.download = name;
        link.href = uri;
        link.click();
    }

    return function(table, name, fileName) {
        if (!table.nodeType) {
            table = document.getElementById(table);
        } 
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML};
        var resuri = uri + base64(format(template, ctx));
        downloadURI(resuri, fileName);
    }
})();

$(document).ready(function () {

    // Create instance of Modal Remote
    // This instance will be the controller of all business logic of modal
    // Backwards compatible lookup of old ajaxCrubModal ID
    if ($('#ajaxCrubModal').length > 0 && $('#ajaxCrudModal').length == 0) {
        modal = new ModalRemote('#ajaxCrubModal');
    } else {
        modal = new ModalRemote('#ajaxCrudModal');
    }

    modalOperator = new ModalRemote('#ajaxOperatorModal');

    // Catch click event on all buttons that want to open a modal
    $(document).on('click', '[role="modal-remote"]', function (event) {
        event.preventDefault();

        // Open modal
        modal.open(this, null);
    });

    // Catch click event on all buttons that want to open a modal
    // with bulk action
    $(document).on('click', '[role="modal-remote-bulk"]', function (event) {
        event.preventDefault();

        // Collect all selected ID's
        var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });

        if (selectedIds.length == 0) {
            // If no selected ID's show warning
            modal.show();
            modal.setTitle('Нет выбора');
            modal.setContent('Вы должны выбрать элемент (ы), чтобы использовать это действие');
            modal.addFooterButton("Закрыть", 'button','btn btn-default', function (button, event) {
                this.hide();
            });
        } else {
            // Open modal
            modal.open(this, selectedIds);
        }
    });

    $(document).on('click', '[role="modal-operator-bulk"]', function (event) {
        event.preventDefault();

        // Collect all selected ID's
        var selectedIds = [];
        $('input:checkbox[name="selection[]"]').each(function () {
            if (this.checked)
                selectedIds.push($(this).val());
        });

        if (selectedIds.length == 0) {
            // If no selected ID's show warning
            modal.show();
            modal.setTitle('Нет выбора');
            modal.setContent('Вы должны выбрать элемент (ы), чтобы использовать это действие');
            modal.addFooterButton("Закрыть", 'button', 'btn btn-default', function (button, event) {
              this.hide();
            });
        } else if($('[name="operatorSelected"]').val() == ''){
            modal.show();
            modal.setTitle('Нет выбора');
            modal.setContent('Вы должны выбрать оператора');
            modal.addFooterButton("Закрыть", 'btn btn-default', function (button, event) {
                this.hide();
            });
        }else {
            // Open modal
            modalOperator.open(this, selectedIds, $('[name="operatorSelected"]').val());
        }
    });
});


function ExportToExcel (type, table, fn, dl) {
    var ta = document.getElementById(table);
    var wb = XLSX.utils.table_to_book(ta, { sheet: "sheet1" });
    return dl ?
        XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }) :
        XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
}
