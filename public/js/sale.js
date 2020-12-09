$(document).ready(function() {
    let branchId = 1;
        
    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD',
        defaultDate: moment().format("YYYY-MM-DD"),
    });

    $('#search-item').select2({
        theme: 'bootstrap4',
        placeholder: "Select an item",
        focus: true
        // closeOnSelect: false
    });

    $('#search-item').select2('focus');
    
    let items = [];
    let rowCount;

    $('#search-item').on('select2:select', function(e) {
        rowCount = $('#sales-table tbody tr').length;
        let id = e.params.data.id;

        if (!items.includes(id)) {
            items.push(id);
            let name = "<td>" + $(e.params.data.element).data('name') + "</td>";
            // let upc = "<td>" + $(e.params.data.element).data('upc') + "</td>";
            let options;
            let serialNumber;
            let onHand;
            let qty;
            let costPrice;
            let sellingPrice;
            let amount;
            let deleteButton;

            if ($(e.params.data.element).data('with-serial-number')) {
                $.ajax({
                    url: base_url + '/sale/fetchserialnumbers/' + id + '/' + branchId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log($(e.params.data.element).data('total-qty'));
                        $.each(data, function(i) {
                            options += "<option value='" + data[i].serial_number + "'>" + data[i].serial_number + "</option>";
                        });
                        
                        serialNumber = "<td><select class='form-control serial-numbers with-serial-numbers' name='item[" + rowCount + "][serial-numbers][]' style='min-width:210px;' multiple='multiple' required>" + options + "</select></td>";
                        onHand = "<td><input type='text' class='form-control-plaintext qty' readonly required tabindex='-1' value='" + $(e.params.data.element).data('total-qty') + "'></td>";
                        qty = "<td><input type='text' class='form-control qty' name='item[" + rowCount + "][qty]' readonly required tabindex='-1'></td>";
                        costPrice = "<td><input type='number' class='form-control-plaintext cost-price' name='item[" + rowCount + "][cost-price]' value='" + $(e.params.data.element).data('cost-price') + "' tabindex='-1'></td>";
                        sellingPrice = "<td><input type='number' class='form-control selling-price' name='item[" + rowCount + "][selling-price]'  value='" + $(e.params.data.element).data('selling-price') + "' tabindex='-1'></td>";
                        amount = "<td><input type='number' class='form-control-plaintext amount' name='item[" + rowCount + "][amount]' tabindex='-1'></td>";
                        deleteButton = "<td><button type='button' class='btn btn-default remove-item-button' id='" + $(e.params.data.element).data('id') + "' tabindex='-1'><i class='fa fa-times'></i></button><input type='hidden' class='id' name='item[" + rowCount + "][id]' value='" + $(e.params.data.element).data('id') + "'><input type='hidden' class='with-serial-number' name='item[" + rowCount + "][with-serial-number]' value='" + $(e.params.data.element).data('with-serial-number') + "'></td>";
                        
                        
                        $('#sales-table').attr('hidden', false);
                        $('#sales-table tbody').append('<tr id="'+ rowCount + '">' + name + onHand + serialNumber + qty + costPrice + sellingPrice + amount + deleteButton + '</tr>');
                        
                        $('.with-serial-numbers').select2({
                            theme: 'bootstrap4',
                            language:{
                                "noResults" : function () { 
                                    return '';
                                }
                            }
                        });
                    }
                });
            }
            else {
                serialNumber = "<td><input type='text' class='form-control serial-numbers without-serial-numbers' name='item[" + rowCount + "][serial-numbers][]' value='' readonly tabindex='-1'></td>";
                onHand = "<td><input type='text' class='form-control-plaintext qty' readonly required tabindex='-1' value='" + $(e.params.data.element).data('total-qty') + "'></td>";
                qty = "<td><input type='text' class='form-control qty' name='item[" + rowCount + "][qty]' id='qty-" + rowCount + "' required></td>";
                costPrice = "<td><input type='number' class='form-control-plaintext cost-price' name='item[" + rowCount + "][cost-price]' value='" + $(e.params.data.element).data('cost-price') + "' tabindex='-1'></td>";
                sellingPrice = "<td><input type='number' class='form-control selling-price' name='item[" + rowCount + "][selling-price]'  value='" + $(e.params.data.element).data('selling-price') + "' tabindex='-1'></td>";
                amount = "<td><input type='number' class='form-control-plaintext amount' name='item[" + rowCount + "][amount]' tabindex='-1'></td>";
                deleteButton = "<td><button type='button' class='btn btn-default remove-item-button' id='" + $(e.params.data.element).data('id') + "' tabindex='-1'><i class='fa fa-times'></i></button><input type='hidden' class='id' name='item[" + rowCount + "][id]' value='" + $(e.params.data.element).data('id') + "'><input type='hidden' class='with-serial-number' name='item[" + rowCount + "][with-serial-number]' value='" + $(e.params.data.element).data('with-serial-number') + "'></td>";
                
                $('#sales-table').attr('hidden', false);
                $('#sales-table tbody').append('<tr id="'+ rowCount + '">' + name + onHand + serialNumber + qty + costPrice + sellingPrice + amount + deleteButton + '</tr>');
            }utton = "<td><button type='button' class='btn btn-default remove-item-button' id='" + $(e.params.data.element).data('id') + "' tabindex='-1'><i class='fa fa-times'></i></button><input type='hidden' class='id' name='item[" + rowCount + "][id]' value='" + $(e.params.data.element).data('id') + "'><input type='hidden' class='with-serial-number' name='item[" + rowCount + "][with-serial-number]' value='" + $(e.params.data.element).data('with-serial-number') + "'></td>";
        }
        else {
            alert('Item already selected');
        }
    });

    $(document).on('select2:select select2:unselect', '.serial-numbers', function() {
        let totalAmount = 0;
        let rowId = $(this).closest('tr').attr('id');
        let qty = $(this).select2('data').length;
        let sellingPrice = $('input[name="item[' + rowId + '][selling-price]"]').val();
        let amount = qty * sellingPrice;
        $('input[name="item[' + rowId + '][qty]"]').val(qty);
        $('input[name="item[' + rowId + '][amount]"]').val(amount);

        $('#sales-table tbody tr').each(function(i) {
            if ($(this).find('.amount').val() == '') {
                $(this).find('.amount').val(0);
            }

            totalAmount += parseFloat($(this).find('.amount').val());
        });

        $('#gross-total').val(totalAmount);
        
    });

    $(document).on('keyup', '.selling-price, .qty', function() {
        let totalAmount = 0;
        let rowId = $(this).closest('tr').attr('id');
        let qty = $('input[name="item[' + rowId + '][qty]"]').val();
        let sellingPrice = $('input[name="item[' + rowId + '][selling-price]"]').val();
        let amount = qty * sellingPrice;
        $('input[name="item[' + rowId + '][amount]"]').val(amount);

        $('#sales-table tbody tr').each(function(i) {
            if ($(this).find('.amount').val() == '') {
                $(this).find('.amount').val(0);
            }

            totalAmount += parseFloat($(this).find('.amount').val());
        });

        $('#gross-total').val(totalAmount);
    });

    $('#sales-table').on('click', 'button.remove-item-button', function(e){
        let totalAmount = 0;
        let id = $(this).attr('id');
        let index = items.indexOf(id);
        items.splice(index, 1);
        $(this).closest('tr').remove();

        $('#sales-table tbody tr').each(function(i) {
            $(this).attr('id', i);
            $(this).find('.serial-numbers').attr('name', 'item[' + i + '][serial-numbers][]');
            $(this).find('.qty').attr('name', 'item[' + i + '][qty]');
            $(this).find('.cost-price').attr('name', 'item[' + i + '][cost-price]');
            $(this).find('.with-serial-number').attr('name', 'item[' + i + '][with-serial-number]');
            $(this).find('.id').attr('name', 'item[' + i + '][id]');

            if ($(this).find('.amount').val() == '') {
                $(this).find('.amount').val(0);
            }

            totalAmount += parseFloat($(this).find('.amount').val());
        });

        $('#gross-total').val(totalAmount);
        
        if ($('#sales-table tbody tr').length < 1) {
            $('#sales-table').attr('hidden', true);
        }
    });

    $("#create-itemin-form").on('submit', function(e) {
        e.preventDefault();
        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success === true) {
                    $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                        '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.message+
                    '</div>');

                    $("#add-itemin-modal").modal('hide');
                    $("#create-itemin-form")[0].reset();
                } 
            }
        });
    });
}); // /document

// function getTotal(row = null) {
//   if(row) {
//     var total = Number($("#rate_value_"+row).val()) * Number($("#qty_"+row).val());
//     total = total.toFixed(2);
//     $("#amount_"+row).val(total);
//     $("#amount_value_"+row).val(total);
    
//     subAmount();

//   } else {
//     alert('no row !! please refresh the page');
//   }
// }

// // get the product information from the server
// function getProductData(row_id)
// {
//   var product_id = $("#product_"+row_id).val();    
//   if(product_id == "") {
//     $("#rate_"+row_id).val("");
//     $("#rate_value_"+row_id).val("");

//     $("#qty_"+row_id).val("");           

//     $("#amount_"+row_id).val("");
//     $("#amount_value_"+row_id).val("");

//   } else {
//     $.ajax({
//       url: base_url + 'orders/getProductValueById',
//       type: 'post',
//       data: {product_id : product_id},
//       dataType: 'json',
//       success:function(response) {
//         // setting the rate value into the rate input field
        
//         $("#rate_"+row_id).val(response.price);
//         $("#rate_value_"+row_id).val(response.price);

//         $("#qty_"+row_id).val(1);
//         $("#qty_value_"+row_id).val(1);

//         var total = Number(response.price) * 1;
//         total = total.toFixed(2);
//         $("#amount_"+row_id).val(total);
//         $("#amount_value_"+row_id).val(total);
        
//         subAmount();
//       } // /success
//     }); // /ajax function to fetch the product data 
//   }
// }

// // calculate the total amount of the order
// function subAmount() {
//   var service_charge = <?php echo ($company_data['service_charge_value'] > 0) ? $company_data['service_charge_value']:0; ?>;
//   var vat_charge = <?php echo ($company_data['vat_charge_value'] > 0) ? $company_data['vat_charge_value']:0; ?>;

//   var tableProductLength = $("#product_info_table tbody tr").length;
//   var totalSubAmount = 0;
//   for(x = 0; x < tableProductLength; x++) {
//     var tr = $("#product_info_table tbody tr")[x];
//     var count = $(tr).attr('id');
//     count = count.substring(4);

//     totalSubAmount = Number(totalSubAmount) + Number($("#amount_"+count).val());
//   } // /for

//   totalSubAmount = totalSubAmount.toFixed(2);

//   // sub total
//   $("#gross_amount").val(totalSubAmount);
//   $("#gross_amount_value").val(totalSubAmount);

//   // vat
//   var vat = (Number($("#gross_amount").val())/100) * vat_charge;
//   vat = vat.toFixed(2);
//   $("#vat_charge").val(vat);
//   $("#vat_charge_value").val(vat);

//   // service
//   var service = (Number($("#gross_amount").val())/100) * service_charge;
//   service = service.toFixed(2);
//   $("#service_charge").val(service);
//   $("#service_charge_value").val(service);
  
//   // total amount
//   var totalAmount = (Number(totalSubAmount) + Number(vat) + Number(service));
//   totalAmount = totalAmount.toFixed(2);
//   // $("#net_amount").val(totalAmount);
//   // $("#totalAmountValue").val(totalAmount);

//   var discount = $("#discount").val();
//   if(discount) {
//     var grandTotal = Number(totalAmount) - Number(discount);
//     grandTotal = grandTotal.toFixed(2);
//     $("#net_amount").val(grandTotal);
//     $("#net_amount_value").val(grandTotal);
//   } else {
//     $("#net_amount").val(totalAmount);
//     $("#net_amount_value").val(totalAmount);
    
//   } // /else discount 

// } // /sub total amount

// function removeRow(tr_id)
// {
//   $("#product_info_table tbody tr#row_"+tr_id).remove();
//   subAmount();
// }