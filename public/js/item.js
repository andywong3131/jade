let manageItemTable;
let token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    
    manageItemTable = $('#manage-item-table').DataTable({
        'ajax': "item/fetchitemsdata",
        'order': [],
        'columns': [
            { data: 'name' },
            { data: 'upc' },
            { data: 'price' },
            { data: 'active' },
            { data: 'action' }
        ]
    });
    
    $("#create-item-form").on('submit', function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                manageItemTable.ajax.reload(null, false); 

                if (response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                    '</div>');

                    // hide the modal
                    $("#add-item-modal").modal('hide');

                    // reset the form
                    $("#create-item-form")[0].reset();
                } 
            }
        });
    });
});

function editItem(id) {
    $.ajax({
        url: "item/" + id + "/fetchitemdatabyid",
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#edit-name').val(data.name);
            $('#edit-upc').val(data.upc);
            $('#edit-price').val(data.price);
            $('#edit-with-serial-number').val(data.with_serial_number);
            $('#edit-active').val(data.active);

            $('#update-item-form').unbind('submit').bind('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                
                $.ajax({
                    url: form.attr('action') + '/' + id,
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        manageItemTable.ajax.reload(null, false); 

                        $("#edit-item-modal").modal('hide');
                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                            '</div>');

                            // hide the modal
                            $("#edit-item-modal").modal('hide');
                        } 
                    }
                });
            });
        }
    });
}

// remove functions 
function removeItem(id)
{
    $("#remove-item-form").unbind('submit').bind('submit', function(e) {
        e.preventDefault();
      let form = $(this);
        // alert(form.attr('action') + '/' + id);
      $.ajax({
        url: form.attr('action') + '/' + id,
        type: 'DELETE',
        data: {
            _token: token
        },
        dataType: 'JSON',
        success:function(response) {
            manageItemTable.ajax.reload(null, false); 

            if(response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                '</div>');

                $("#remove-item-modal").modal('hide');
            
            }
        }
      });
    });
}