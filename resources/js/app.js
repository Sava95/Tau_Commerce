require('./bootstrap');

$(function() {
    // ########## Add New Product Page  ##########

    // Create custom URL dropdown menu
    $("#custom_url_dropDown").on('change',function() {
        if ($(this).val() == "yes") {
            $('#custom_url').show();
            $('#product_custom_url').attr('required', '');
            $('#product_custom_url').attr('data-error', 'This field is required.');
        } else {
            $('#custom_url').hide();
            $('#product_custom_url').removeAttr('required');
            $('#product_custom_url').removeAttr('data-error');
        }});

     // Create store select dropdown menu
     $("#store_dropDown").on('change',function() {
        if ($(this).val() == "yes") {
            $('#store').show();
            $('#store_select').attr('required', '');
            $('#store_select').attr('data-error', 'This field is required.');
        } else {
            $('#store').hide();
            $('#store_select').removeAttr('required');
            $('#store_select').removeAttr('data-error');
        }});

    // Creating an AJAX call
    $("#create_product_form").on('submit', function(e){ 
        e.preventDefault();  

        // Form input values 
        let prod_name = document.getElementById('product_name').value;
        let sku = $('input[name="sku"]').attr('value');
        let product_custom_url = document.getElementById('product_custom_url').value;
        let stores_string = document.getElementsByClassName("btn dropdown-toggle btn-light")[0].title;  // returns a string of selected store names
        let stores = stores_string.split(', ');
        let product_price = document.getElementById('product_price').value;
        let product_description = document.getElementById('product_description').value;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); 

        $.ajax({
            type: "POST",
            url: "/add_product/create",
            data: {
                prod_name: prod_name,
                sku: sku,
                product_custom_url: product_custom_url,
                product_price: product_price,
                stores: stores,
                product_description: product_description,
                is_deleted: 0,
            },
            dataType : 'json',

            success: function($response) {
                console.log($response);
                if ($response.prod_name && $response.product_price){ 
                    $("#error_message_prod_name").show();
                    setTimeout(function() { $("#error_message_prod_name").fadeOut("slow"); }, 3000);
                    document.getElementById('error_message_prod_name').innerHTML = $response.prod_name

                    $("#error_message_prod_price").show();
                    setTimeout(function() { $("#error_message_prod_price").fadeOut("slow"); }, 3000);
                    document.getElementById('error_message_prod_price').innerHTML = $response.product_price;
                    document.getElementById('error_message_prod_price').style.marginTop = '80px';

                } else if ($response.prod_name || $response.product_price) {
                    if($response.prod_name) {
                        $("#error_message_prod_name").show();
                        setTimeout(function() { $("#error_message_prod_name").fadeOut("slow"); }, 3000);
                        document.getElementById('error_message_prod_name').innerHTML = $response.prod_name;
                    } 

                    if ($response.product_price) {
                        $("#error_message_prod_price").show();
                        setTimeout(function() { $("#error_message_prod_price").fadeOut("slow"); }, 3000);
                        document.getElementById('error_message_prod_price').innerHTML = $response.product_price;
                        document.getElementById('error_message_prod_price').style.marginTop = '10px';
                    }
                } else {
                    // Resets the form to initial state
                    $("#create_product_form").trigger("reset");  
                    $('#custom_url').hide();
                    $('#store').hide();
                    
                    $("#success_message").show();
                    setTimeout(function() { $("#success_message").fadeOut("slow"); }, 3000);

                    let uniqueCode = document.getElementById('sku');
                    uniqueCode.value = $response;
                }
           },
        });

    });

});

