$(document).ready(function() {

    // Basic example
    var basicEditableTable = new BSTable("basicEditable");
    basicEditableTable.init();

    // New row edit-table example
    var addRowDataTable = new BSTable("addRowDataTable", {
        $addButton: $('#addRowButton'),
        onEdit:function() {
            // console.log("EDITED");
        },
    });
    addRowDataTable.init();

    // Example only some columns editable & removed actions column label
    var customizeEditTable = new BSTable("customEditableTable", {
        editableColumns:"1,2,4",
        advanced: {
            columnLabel: ''
        }
    });
    customizeEditTable.init();

   
} );