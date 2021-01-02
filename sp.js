$('#expense').change(function () {

	var val = $('#expense').val();
  	//alert ('http://localhost/ss/sp_updateJS.php?ctype=' + val);
  	//var url = $('#url').val(); 
  	$.post('http://localhost/appollow/admin_expense_sub.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#divexpense').html(result);
  	    }
  		}
  	);
});

$('#category').change(function () {

	var val = $('#category').val();
  	//alert ('http://localhost/ss/sp_updateJS.php?ctype=' + val);
  	//var url = $('#url').val(); 
  	$.post('http://localhost/appollow/admin_category_sub.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#divcategory').html(result);
  	    }
  		}
  	);
});


$('#category_stock').change(function () {

	var val = $('#category_stock').val();
  	//alert ('http://localhost/ss/sp_updateJS.php?ctype=' + val);
  	//var url = $('#url').val(); 
  	$.post('http://localhost/appollow/admin_category_sub_stock.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#divcategory_stock').html(result);
  	    }
  		}
  	);
});


$('#main_category').change(function () {

	var val = $('#main_category').val();
  	//alert ('http://localhost/ss/sp_updateJS.php?ctype=' + val);
  	//var url = $('#url').val(); 
  	$.post('http://localhost/appollow/admin_product_list.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#div_product').html(result);
  	    }
  		}
  	);
});
  	
  	
 $('#sec_type').change(function () {
	var val = $('#sec_type').val();
  	
  	//alert ('http://localhost/appollow/cust_security_sub.php?ctype=' + val);
  	$.post('http://localhost/appollow/cust_security_sub.php?ctype='+val,
  		function(result) {        
  	
  	    if (result) {   
  			   $('#div_sec_info').html(result);
  	    }
  		}
  	); 	
});




  	
 $('#company_name').change(function () {
	var val = $('#company_name').val();
  	
  	//alert ('http://localhost/appollow/cust_security_sub.php?ctype=' + val);
  	$.post('http://localhost/appollow/company_do.php?ctype='+val,
  		function(result) {        
  	
  	    if (result) {   
  			   $('#div_do_number').html(result);
  	    }
  		}
  	); 	
});


$('#pay_head').change(function () {

	 var val = $('#pay_head').val(); 
  	
  	//alert ('http://localhost/appollow/cust_security_sub.php?ctype=' + val);
    $.post('http://localhost/appollow/acc_payable_list.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#div_pay_head').html(result);
  	    }
  		}
  	);
});
  	

$('#sp_target').change(function () {

	 var val = $('#sp_target').val(); 
  	
  	//alert ('http://localhost/appollow/cust_security_sub.php?ctype=' + val);
    $.post('http://localhost/appollow/admin_sp_target_list.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#divsptarget').html(result);
  	    }
  		}
  	);
});


$('#customer_sec').change(function () {

	 var val = $('#customer_sec').val(); 
  	
  	//alert ('http://localhost/appollow/admin_secon_cust_list.php?ctype=' + val);
    $.post('http://localhost/appollow/admin_secon_cust_list.php?ctype='+val,
  		function(result) {        
  	    // if the result is TRUE write a message return by the request
  	    if (result) {   
  	       //alert($('#divcategory').html(result));
  			   $('#div_secondary_cust').html(result);
  	    }
  		}
  	);
});
