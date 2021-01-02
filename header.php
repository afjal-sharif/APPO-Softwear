<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title><?=$global['site_name']?></title>
    <script type="text/javascript" src="datetimepicker_css.js"></script>
    <link rel="stylesheet" href="css/datepicker.css" type="text/css" />
    <link type="text/css" href="menu.css" rel="stylesheet" />
    <link type="text/css" href="skin.css" rel="stylesheet" />
    
    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" src="menu.js"></script>
</head>
<body>
<?php 
 date_default_timezone_set('Asia/Dacca');
 set_time_limit(0);
?>
<style type="text/css">
* { margin:0;
    padding:0;
}
body {
     background:#171717;
     background: url(images/bg-cs.jpg) center top #FFFFFF repeat-y; 
   }
div#menu {
    margin:00px 00px 2px 10px;
    width:90%;
}
div#copyright {
    margin:0 auto;
    width:80%;
    font:00px 'Trebuchet MS';
    color:#851300;
    text-indent:20px;
    padding:00px 0 0 0;
}
div#copyright a { color:#ff0000; }
div#copyright a:hover { color:#851300; }
</style>
<table align="center" width="100%" >
<tr align="center">
<td>



<table width="960px" align="center"  bgcolor="#FFFFFF" background="images/bg.png" border="0" bordercolor="#FFFFFF" cellspacing="5" cellpadding="5" style="border-collapse:collapse;">
 <!--
  <tr> 
    <td align="center"><IMG  alt="<?=$global['site_name']?>" src="<?=$global[logo];?>" width="65px" height="50px"  border="0"></td>
  </tr>
  <tr align="center" ><td> 
     <p style="font-family: Tangerine,verdana,Palatino Linotype; font-size:13px;color:#C3311A;">
     <b><?=$global['site_name']?></b></p>
  </td>
  </tr>
 -->
<?php
    if(date("Y-m-d")>'2023-12-31')
    {
     echo "<td colspan='2'>Software Licence is Expired, Pls contact with Service Provider.</td>";
     exit;
    }
    else
    {
?>
  
  <tr>
   <td align="center">
    <div id="menu">
    <ul class="menu">
        <li><a href="welcome.php"><span>Home</span></a></li>
        
        
       <li><a href="#" class="parent"><span>Today</span></a>
            <div><ul>
                 <li><a href="todaysum.php" title="Day Transection Summary"><span>Day Summary</span></a></li>
		             <li><a href="today.php" title="Day Details"><span>Day Details</span></a></li>
                 <li><hr></li>
                 <li><a href="cash_bank.php"><span>Cash & Bank Position</span></a></li>
                 <!--<li><a href="cash_bank_pos.php"><span>Cash & Bank Position</span></a></li>-->
                 <!--
                 <li><a href="rptdiscussion.php"><span>View Discussion</span></a></li>
                 <li><hr></li>-->
                 
                <li><a href="notes.php"><span>Notes Entry</span></a></li>
                <li><a href="rpt_notes.php"><span>View Notes</span></a></li>        
            </ul></div>
        </li>
        
        
        <li><a href="#" class="parent"><span>Purchase</span></a>
              <div><ul>
                	<li><a href="order.php"><span>Goods Purchase</span></a></li>
                	<li><a href="pur_receive.php?id=pur_receive"><span>Receive Goods</span></a></li>
                	<li><hr></li>
                	<li><a href="holcim_order.php?id=1"><span>Holcim Order</span></a></li>
                	<li><a href="holcim_receive.php?id=1"><span>Holcim Receive</span></a></li>
                	<li><hr></li>
               	  <li><a href="pur_order_bal.php?id=pur_receive"><span>Order Balance</span></a></li>
                  <li><hr></li>
                  <li><a href="rpt_supplier.php"><span>Supplier List</span></a></li>
                  <li><a href="pur_order.php"><span>Purchase Order</span></a></li>
                  <li><a href="receivedetails.php"><span>Purchase Details</span></a></li>
             </ul></div>        
        </li>  
        <li><a href="#" class="parent"><span>Sales</span></a>
            <div><ul>
                
                <li><a href="salesbalmul.php"><span>Goods Sales</span></a></li>
                <li><a href="invoiceprint.php?id=dosales"><span>DO Sales</span></a></li>
                <li><a href="rec_cement_sales.php?id=1"><span>Cement Sales</span></a></li>
                <li><a href="sales_cash.php?id=1"><span>Cash Sales</span></a></li>
                
                <li><hr></li>
                <li><a href="invoiceprint.php?id=invoice"><span>Print Invoice</span></a></li>
                <li><a href="invoiceprint.php?id=challan"><span>Print Challan</span></a></li>
                <li><a href="invoiceprint.php?id=mr"><span>Print MR</span></a></li>
                <li><hr></li>
                <li><a href="stock.php"><span>Stock Balance</span></a></li>
                <li><hr></li>
                <li><a href="customer.php"><span>New Customer</span></a></li>
                <li><a href="rpt_cust_list.php"><span>Customer List</span></a></li>
                <li><hr></li>
                <li><a href="#"><span>Sales Report >></span></a>
                    <div>
                        <ul>
                            <li><a href="monthliftingall.php"><span>Monthly Lifting</span></a></li>
                            <li><a href="rpt_sales_summary.php"><span>Sales Summary</span></a></li>
                            <li><a href="salesdetails.php"><span>Sales Report</span></a></li>
                            <li><a href="rpt_sales_sp_cust.php"><span>Sales SP & Customer</span></a></li>
                            <li><a href="rpt_sp_status.php"><span>SP Status</span></a></li>
                            <li><a href="rpt_secon_sales.php"><span>Secondary Sales</span></a></li>  
                            <li><hr></li>
                            <li><a href="rpt_sales_cash.php"><span>Daily Cash Sales</span></a></li>        
                        </ul>
                    </div>   
                </li>      
                
             </div>
        </li>
        <li><a href="#" class="parent"><span>Accounts</span></a>
            <div><ul>
                    <li><a href="#"><span>Payable >></span></a>
                       <div>
                        <ul>
                         <li><a href="autopaybalcom.php"><span>Payment To Supplier</span></a></li> 
                         <li><a href="paybankclear.php"><span>Payment Bank Clear</span></a></li> 
                         <li><a href="comstatement.php"><span>Supplier Statements</span></a></li>
                         <li><a href="rptpaybalcomrec.php"><span>Supplier Balance</span></a></li>
                         
                         <li><a href="paymentdetails.php"><span>Payment Details</span></a></li>
                         
                        </ul>
                       </div>   
                   </li>  
                   <li><a href="#"><span>Receiveable >></span></a>
                       <div>
                        <ul>
                                 <li><a href="autorecbalcust.php"><span>Receive From Customer</span></a></li> 
                                 <li><a href="rec_cash_bulk.php?id=1"><span>Daily Collection</span></a></li>                                
                                 <li><a href="bankclear.php"><span>Receive Bank Clear</span></a></li> 
                                 <li><hr></li>
                                 <li><a href="cust2com.php"><span>Customer 2 Supplier</span></a></li>
                                 <li><hr></li>
                                 <li><a href="custstatement.php"><span>Customer Statement</span></a></li>
                                 
                                 <li><a href="rpt_sp_stat.php"><span>SP Statement</span></a></li>
                                 
                                 <li><a href="rpt_cust_stat_receive.php"><span>Customer Stat Status</span></a></li>
                                 <li><a href="rptrecbaldirsum.php"><span>Customer Balance</span></a></li>
                                 
                                 <li><hr></li>
                                 <li><a href="chqpaymentreceive.php"><span>Receive Details</span></a></li>
                                 <li><hr></li>
                                 <li><a href="age_analysis.php"><span>Age Wise Analysis</span></a></li>
                                 
                                 <!--<li><a href="directcustomer.php"><span>Customer Ledger</span></a></li>
                                 
                                 
                                 <li><a href="#"><span>Reports >></span> </a>
                                    <div><ul>
                                        <li><a href="paymentreceive.php"><span>Cash Receive</span></a></li>
                                        <li><a href="chqpaymentreceive.php"><span>Cheque Receive</span></a></li>
                                    </ul></div>
                                </li>
                                -->   
                        </ul>
                       </div>  
                    </li>
                    <li><a href="#"><span>Expense >></span></a>
                       <div>
                        <ul>
                         <li><a href="exp_expense.php"><span>Expense Entry</span></a></li>
                         <?
                         if($_SESSION[super_admin]=='1')
                          {
                         ?>  
                         <li><a href="exp_rpt_expensedetails.php"><span>Expense Report</span></a></li>
                         <?
                          }
                         ?>
                         <li><hr></li>
                         <li><a href="exp_probition.php"><span>Expense Probition</span></a></li>      
                         <li><a href="exp_pro_payment.php"><span>Probition Payment</span></a></li>
                         <li><a href="rpt_exp_pro.php"><span>Probition Report</span></a></li>
                        </ul>
                       </div>  
                    </li>
                    <li><a href="#"><span>Cash & Banking >></span></a>
                       <div>
                        <ul>
                         <li><a href="cashtobank.php"><span>Cash To Bank</span></a></li>
                         <li><a href="banktocash.php"><span>Bank To Cash</span></a></li>
                         <li><a href="banktobank.php"><span>Bank To Bank</span></a></li>
                         <li><hr></li>
                         
                         <li><a href="bankdetails.php"><span>Bank Details.</span></a></li>
                         <li><a href="cashdetails.php"><span>Cash Details.</span></a></li>
                         <!--
                         <li><a href="#"><span>Reports >></span> </a>
                                    <div><ul>
                                        <li><a href="bankdetails.php"><span>Bank Details.</span></a></li>
                                        <li><a href="cashdetails.php"><span>Cash Details.</span></a></li>
                                    </ul></div>
                         </li>
                         --> 
                        </ul>
                       </div>  
                    </li>
                    
                    
                    <li><a href="#"><span>HRMS >></span></a>
                       <div>
                        <ul>
                         <li><a href="hrms_main.php"><span>Employee Master</span></a></li>
                         <li><a href="hrms_rpt_emp_list.php"><span>View Employee</span></a></li>
                         <li><a href="hrms_leave.php"><span>Leave Database</span></a></li> 
                        </ul>
                       </div>  
                    </li>
                    
                    
                    
                    <li><a href="#"><span>Adjustment >></span></a>
                       <div>
                        <ul>
                         <li><a href="adjustment.php?todo=viewin"><span>Stock Increase</span></a></li>
                         <li><a href="adjustment.php?todo=viewde"><span>Stock Decrease</span></a></li>
                         <li><hr></li>
                         <li><a href="directcompany.php"><span>Supplier Adjustment</span></a></li>
                         <li><a href="directcustomer.php"><span>Customer Adjustment</span></a></li>
                         <li><hr></li>                         
                         <li><a href="rpt_adj_stock_in.php"><span>Stock Increase Report</span></a></li>
                         <li><a href="rpt_adj_stock_out.php"><span>Stock Decrease Report</span></a></li>
                         <li><a href="rptadj_supplier.php"><span>Supplier Adj Report</span></a></li>
                         <li><a href="rptadj_customer.php"><span>Customer Adj Report</span></a></li>
                           
                        </ul>
                      </div>  
                    </li>
                    <li><a href="#"><span>Incentive Receive >></span></a>
                        <div>
                        <ul>
                         <li><a href="incentive.php"><span>Incentive Receive</span></a></li>
                         
                         <li><a href="incentive_receive.php"><span>Incentive Adjust</span></a></li>
                         <li><a href="rptincentive.php"><span>Incentive Report</span></a></li>
                         <li><a href="rptincentive_sum.php"><span>Incentive Summery</span></a></li>
                         <li><hr></li>
                         <li><a href="incentive_gift.php"><span>Gift Receive</span></a></li>
                         <li><a href="rpt_incentive_gift.php"><span>Gift Receive Stat</span></a></li>
                         <!--
                         <li><hr></li>
                         <li><a href="rpt_inc_statement.php"><span>Incentive Statements</span></a></li>
                         -->  
                        </ul>
                      </div>   
                     </li>                    
                    
                                        
                    <li><a href="#"><span>INCENTIVE >></span></a>
                       <div>
                        <ul>
                                 <li><a href="calincentive.php"><span>PAY INCENTIVE</span></a></li> 
                                 <li><a href="post_incentive.php"><span>POST INCENTIVE</span></a></li>  
                                 <li><hr></li>
                                 <li><a href="addincentive.php"><span>Incentive Payment</span></a></li>
                                 <li><a href="rptprocess.php"><span>Incentive Report</span></a></li>                              
                                 
                        </ul>
                       </div>  
                    </li>
                    
                    
                    <li><a href="#"><span>Landing & Borrowing >></span></a>
                       <div>
                        <ul>
                         <li><a href="LB_Receive.php"><span>Receive</span></a></li>
                         <li><a href="LB_Payment.php"><span>Payment</span></a></li>
                         
                         <!--
                         <li><a href="cash.php"><span>Receive</span></a></li>
                         <li><a href="banktran.php"><span>Bank Transection</span></a></li>
                         -->
                         <li><hr></li>
                         <li><a href="LBStatement.php"><span>Statements</span></a></li>
                         <li><a href="balance.php"><span>Balance Report</span></a></li>
                        </ul>
                       </div>  
                    </li>
                    <li><a href="#"><span>Others >></span></a>
                       <div>
                        <ul>
                         <li><a href="acc_journal.php"><span>Journal Entry</span></a></li>          
                         
                         <li><a href="assets_equity.php"><span> Others Investment</span></a></li>
                         <li><a href="assets_add.php"><span> Fixed Assets</span></a></li>
                         <li><a href="othersincome.php"><span>Others Income</span></a></li> 
                         
                         <li><hr></li>
                         <li><a href="admin_account.php"><span>Account Info</span></a></li>
                         <li><a href="admin_security.php"><span>Security Info</span></a></li>
                        </ul>
                       </div>  
                    </li>
                </ul>
             </div>
        </li>
         
         
         
              
                
        <?
        if($_SESSION[userType]=='A')
         {
        ?>    
        
        <li><a href="#" class="parent"><span>Admin</span></a>
            <div><ul>
                <li><a href="sys_date.php"><span>Date Setup</span></a></li>
                <li><a href="change.php"><span>Change Password</span></a></li>
                <li><a href="manage-users.php"><span>New User</span></a></li>
                <li><a href="admin_menu_list.php"><span>User Access Control</span></a></li>
                <li><hr></li>
                <li><a href="#"><span>Purchase>></span></a>
                   <div>
                       <ul>
                           <li><a href="company.php"><span>Supplier Setup</span></a></li>
                           <li><a href="category.php"><span>Product Category</span></a></li>
                           <li><a href="product.php"><span>Product Setup</span></a></li>
                       </ul>
                   </div>   
                </li>
                
                <li><a href="#"><span>Sales>></span></a>
                   <div>
                       <ul>
                           <li><a href="customer.php"><span>New Customer</span></a></li>
                           <li><a href="price_entry.php?id=1"><span>New Price</span></a></li>
                           <li><a href="sp.php"><span>New SP</span></a></li>
                           <li><a href="area.php"><span>New Salaes</span></a></li>
                           <!--<li><a href="admin_sp_target.php"><span>SP Target</span></a></li> -->
                           <li><a href="admin_retailer_target.php"><span>Retailer Target</span></a></li>
                           <li><a href="admin_ret_tar_edit.php"><span>Target EDIT</span></a></li>
                           <li><a href="secon_customer.php"><span>Secondary Customer</span></a></li>
                       </ul>
                   </div>   
                </li>
                
                <li><a href="#"><span>Accounts>></span></a>
                   <div>
                       <ul>
                            <li><a href="admin_coa.php"><span>Chart Of Accounts</span></a></li>
                            <li><hr></li>
                                                      
                            <li><a href="lb_add_person.php"><span>New LB Person</span></a></li>
                            <li><hr></li>
                            <li><a href="bank.php"><span>Bank Account</span></a></li>
                            <li><hr></li>
                            <li><a href="addexpense_cat.php"><span>Expense Head</span></a></li>
                            <li><a href="addexpense.php"><span>Expense Sub Head</span></a></li>
                            <li><hr></li>
                            <li><a href="income_head.php"><span>Others Income Head</span></a></li>
                            
                      </ul>
                   </div>   
                </li>
                <li><a href="#"><span>Error Correction>></span></a>
                   <div>
                       <ul>
                            <li><a href="edit_order.php?id=order"><span>Order Delete</span></a></li>
                            <li><hr></li>
                            <li><a href="edit_order.php?id=invoice"><span>Invoice Delete</span></a></li>
                            <li><hr></li>
                            <li><a href="edit_order.php?id=money"><span>Receive Payment Delete</span></a></li>
                            <li><hr></li>                           
                            <li><a href="edit_order.php?id=moneypay"><span>Supplier Payment Delete</span></a></li>
                            <li><hr></li>                           
                            <li><a href="edit_order.php?id=expense"><span>Expense Edit</span></a></li>
                            <li><hr></li>
                            <li><a href="runsql.php"><span>RUN SQL</span></a></li>
                      </ul>
                   </div>   
                </li>
                <!--<li><a href="admin.php?type=2">Empty Database</a></li>-->                
            </ul></div>
        </li>
          <?
          }
          else
          {
           echo "<li><a href='#' class='parent'><span>Admin</span></a>";
           echo "<div><ul>";
           echo "<li><a href='change.php'><span>Change Password</span></a></li>";
           echo "</ul></div></li>";
          } 
         ?>
        <?
        if($_SESSION[super_admin]=='1')
         {
        ?>    
        <li><a href="#"><span>Report</span></a>
                       <div>
                        <ul>
                         <li><a href="profit_invoice.php"><span>Invoice Wise Profit</span></a></li>
                         <li><a href="profit_product.php"><span>Product Wise Profit</span></a></li>
                         <li><hr></li>
                         <li><a href="pl.php"><span>Income Statement</span></a></li>
                         <li><a href="balancesheet.php"><span>Balance Sheet</span></a></li>
                         <li><a href="cash_bank_pos.php"><span>Cash & Bank Position</span></a></li>
                         <li><a href="rpt_sales_collection.php"><span>Sales & Collection</span></a></li>
                         <li><a href="dto.php"><span>Sales DSO</span></a></li>
                         <li><a href="rpttarget.php"><span>Target vs Actual</span></a></li>
                         <li><hr></li>
                         <li><a href="rpt_others_income.php"><span>Others Income</span></a></li>
                         <li><a href="rpt_investment.php"><span>Investment Report</span></a></li>
                         <li><a href="rpt_assets.php"><span>Assets List</span></a></li>
                         
                         <li><hr></li>
                         <li><a href="rpt_account.php"><span>Account Info</span></a></li>
                         <li><a href="rpt_security.php"><span>Security Info</span></a></li>
                         <li><hr></li>
                         <li><a href="oldbanlancesheet.php"><span>Old Balance Sheet</span></a></li>
                         <li><a href="rptprofit.php"><span>Profit Statement</span></a></li>
                        </ul>
                       </div>  
       </li>  
       <?
       }
       else
       {
        echo "<li><a href='#' class='parent'><span>Report</span></a></li>";
       }
       ?>
        <li class="last"><a href="servey.php?mode=logout"><span>Sign Out</span></a></li>
    </ul>
  </div>
 </td>
 </tr>
 <?php
  }
 ?>
 
<tr>
<td align="center">

