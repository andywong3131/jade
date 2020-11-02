let manageSupplierTable;
let token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    manageSupplierTable = $('#manage-supplier-table').DataTable({
        'ajax': "supplier/fetchsuppliersdata",
        'order': [],
        'columns': [
            { data: 'name' },
            { data: 'address' },
			{ data: 'contact_number' },
            { data: 'active' },
            { data: 'action' }
        ]
    });
    
    $("#create-supplier-form").on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                manageSupplierTable.ajax.reload(null, false); 

                if (response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                    '</div>');

                    // hide the modal
                    $("#add-supplier-modal").modal('hide');

                    // reset the form
                    $("#create-supplier-form")[0].reset();
                } 
            }
        });
    });
});

function editSupplier(id) {
    $.ajax({
        url: "supplier/" + id + "/fetchsupplierdatabyid",
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#edit-name').val(data.name);
            $('#edit-address').val(data.address);
            $('#edit-contact-number').val(data.contact_number);
            $('#edit-active').val(data.active);

            $('#update-supplier-form').unbind('submit').bind('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                
                $.ajax({
                    url: form.attr('action') + '/' + id,
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        manageSupplierTable.ajax.reload(null, false); 

                        $("#edit-supplier-modal").modal('hide');
                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                            '</div>');

                            // hide the modal
                            $("#edit-supplier-modal").modal('hide');
                        } 
                    }
                });
            });
        }
    });
}

// remove functions 
function removeSupplier(id)
{
    $("#remove-supplier-form").unbind('submit').bind('submit', function(e) {
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
            manageSupplierTable.ajax.reload(null, false); 

            if(response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                '</div>');

                $("#remove-supplier-modal").modal('hide');
            
            }
        }
      });
    });
}