let manageBranchTable;
let token = $('meta[name="csrf-token"]').attr('content');
$(document).ready(function() {
    
    manageBranchTable = $('#manage-branch-table').DataTable({
        'ajax': "branch/fetchbranchesdata",
        'order': [],
        'columns': [
            { data: 'address' },
			{ data: 'contact_number' },
            { data: 'active' },
            { data: 'action' }
        ]
    });
    
    $("#create-branch-form").on('submit', function(e) {
        e.preventDefault();
        
        let form = $(this);
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                manageBranchTable.ajax.reload(null, false); 

                if (response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                    '</div>');

                    // hide the modal
                    $("#add-branch-modal").modal('hide');

                    // reset the form
                    $("#create-branch-form")[0].reset();
                } 
            }
        });
    });
});

function editBranch(id) {
    $.ajax({
        url: "branch/" + id + "/fetchbranchdatabyid",
        type: "GET",
        dataType: 'json',
        success: function(data) {
            $('#edit-address').val(data.address);
            $('#edit-contact-number').val(data.contact_number);
            $('#edit-active').val(data.active);

            $('#update-branch-form').unbind('submit').bind('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                
                $.ajax({
                    url: form.attr('action') + '/' + id,
                    type: form.attr('method'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        manageBranchTable.ajax.reload(null, false); 

                        $("#edit-branch-modal").modal('hide');
                        if (response.success === true) {
                            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                            '</div>');

                            // hide the modal
                            $("#edit-branch-modal").modal('hide');
                        } 
                    }
                });
            });
        }
    });
}

// remove functions 
function removeBranch(id)
{
    $("#remove-branch-form").unbind('submit').bind('submit', function(e) {
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
            manageBranchTable.ajax.reload(null, false); 

            if(response.success === true) {
                $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                    '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                '</div>');

                $("#remove-branch-modal").modal('hide');
            
            }
        }
      });
    });
}