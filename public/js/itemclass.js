let manageItemClassTable;
let token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    
    manageItemClassTable = $('#manage-item-class-table').DataTable({
        'ajax': "itemclass/fetchitemclassesdata",
        'order': [],
        'columns': [
            { data: 'name' },
            { data: 'active' },
            { data: 'action' }
        ]
    });
    
    $("#create-item-class-form").on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                manageItemClassTable.ajax.reload(null, false); 

                if (response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                    '</div>');

                    // hide the modal
                    $("#add-item-class-modal").modal('hide');

                    // reset the form
                    $("#create-item-class-form")[0].reset();
                } 
            }
        });
    });
});

function editItemClass(id) {
    $.ajax({
        url: "itemclass/" + id + "/fetchitemclassdatabyid",
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#edit-name').val(data.name);
            $('#edit-active').val(data.active);

            $('#update-item-class-form').unbind('submit').bind('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                
                $.ajax({
                    url: form.attr('action') + '/' + id,
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        manageItemClassTable.ajax.reload(null, false); 

                        $("#edit-item-class-modal").modal('hide');

                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                            '</div>');

                            // hide the modal
                            $("#edit-item-class-modal").modal('hide');
                        } 
                    }
                });
            });
        }
    });
}

// remove functions 
function removeItemClass(id)
{
    $("#remove-item-class-form").unbind('submit').bind('submit', function(e) {
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
            manageItemClassTable.ajax.reload(null, false); 

            if(response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                '</div>');

                $("#remove-item-class-modal").modal('hide');
            
            }
        }
      });
    });
}