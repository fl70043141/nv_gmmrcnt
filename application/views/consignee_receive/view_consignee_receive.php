<?php
//echo '<pre>';print_r($inv_data); die;
$cs_data = $user_data; 
//echo '<pre>';print_r($cs_data); 

?>
<style>
    .colored_bg{
        background-color:#E0E0E0;
    }
    .table-line th, .table-line td {
        padding-bottom: 2px;
        border-bottom: 1px solid #ddd;
        text-align:center; 
    }
    .text-right,.table-line.text-right{
        text-align:right;
    }
    .table-line tr{
        line-height: 30px;
    }
    </style>
<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    
    
        <div class="">
            <a href="<?php echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>
            <?php // echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], 'Customer_payments', 'add_customer_payment'))?'<a href="'.base_url('Customer_payments/add_customer_payment/'.$cs_data['id'].'/20').'" class="btn btn-app "><i class="fa fa-money"></i>Payments</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$cs_data['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete Invoice</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'sales_invoice_print'))?'<a target="_blank" href="'.base_url($this->router->fetch_class().'/sales_invoice_print/'.$cs_data['id']).'" class="btn btn-app "><i class="fa fa-print"></i>Print Invoice</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], "Sales_invoices", 'add'))?'<a target="_blank" href="'.base_url('Sales_invoices/add?cr_id='.$cs_data['id']).'" class="btn btn-app "><i class="fa fa-list"></i>Gen. Invoice</a>':''; ?>

        </div>
    </div>
    
 <br><hr>
    <section  class="content"> 
        <!--Flash Error Msg-->
        <?php  if($this->session->flashdata('error') != ''){ ?>
        <div class='alert alert-danger ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>

        <?php  if($this->session->flashdata('warn') != ''){ ?>
        <div class='alert alert-success ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>  
        
        <div class="">
            
            <?php echo form_open($this->router->fetch_class()."/validate", 'id="form_search" class="form-horizontal"')?>  
              <!-- general form elements -->
              <div class="box box-primary"> 
                  <div class="box-body">
                <!-- /.box-header -->
                <!-- form start -->
               <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('consignee_id',array($cs_data['consignee_name']),set_value('consignee_id'),' class="form-control select2" data-live-search="true" id="consignee_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Cons. Receive # <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('cr_no',set_value('cr_no',$cs_data['cr_no']),' class="form-control " readonly id="cr_no"');?>
                                         <!--<span class="help-block"><?php // echo form_error('recieve_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Reference <span style="color: red"></span></label>
                                        <div class="col-md-9">    
                                             <?php  echo form_input('reference',set_value('reference',$cs_data['reference']),' class="form-control"  readonly id="reference"');?>
                                             <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                        </div> 
                                    </div>
                                    <label class="col-md-3 control-label">Payments<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',array('payment_term_name'),set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            
                            <div class="col-md-4">  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('recieve_date',set_value('recieve_date',date('m/d/Y',$cs_data['recieve_date'])),' class="form-control datepicker" readonly id="recieve_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('recieve_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                            </div>
                        </div>
             
                    <div class="box-body fl_scrollable_x">
                    <div class="col-md-10 col-md-offset-1">
                        <table width="100%" border="1">
                            <tr><td>
                    <?php
                          
                    foreach ($cr_desc_data['invoice_desc'] as $inv_itms){ 
//                        echo '<pre>';                        print_r($inv_itms); 
                        
                         echo '<table width="100%" id="example1" class="table-line" border="0">
                                    <thead>
                                        <tr class="colored_bg" style="background-color:#E0E0E0;">
                                             <th colspan="6">'.$cr_desc_data['item_cats'][$inv_itms[0]['item_category']].'</th> 
                                         </tr>
                                        <tr style="">
                                             <th width="15%" style="text-align: center;"><u><b>Code</b></u></th>  
                                             <th width="22%" style="text-align: left;"><u><b>Description</b></u></th>
                                             <th  width="10%"><u><b>Qty</b></u></th>   
                                             <th width="10%" style="text-align: right;"><u><b>Rate</b></u></th>  
                                             <th width="20%" style="text-align: right;"><u><b>Cons. Amount</b></u></th>  
                                             <th width="23%" style="text-align: right;"><u><b>Subtotal</b></u></th> 
                                            <td width="4%" style="text-align: right;"></td> 
                                         </tr>
                                    </thead>
                                <tbody>';

                     foreach ($inv_itms as $inv_itm){
                         
                         echo     '<tr>
                                        <td width="15%" style="text-align: center;">'.$inv_itm['item_code'].'</td>  
                                        <td width="22%" style="text-align: left;">'.$inv_itm['item_desc'].'</td>  
                                        <td width="10%">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['item_quantity_uom_id_2']>0)?' | '.$inv_itm['item_quantity_2'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                        <td width="10%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
                                        <td width="10%" style="text-align: right;">'. number_format($inv_itm['consignment_amount'],2).' '.(($inv_itm['consignment_type_id']==1 || $inv_itm['consignment_type_id']==2)?'('. $inv_itm['consignment_rate'].'%)':'').'</td> 
                                        <td width="23%" style="text-align: right;">'. number_format($inv_itm['sub_total'],2).'</td> 
                                        <td width="4%" style="text-align: right;"></td> 
                                    </tr> ';
                     }
                     echo       ' <tr><td  colspan="6"> </td></tr></tbody></table>'; 
            }
            echo '
                    <table id="example1" width="100%" class="table-line" border="0">
                        
                       <tbody>
                                <tr><td  colspan="6"><br> </td></tr>
                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b> Total</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($cr_desc_data['invoice_desc_total'],2).'</b></td> 
                                    <td width="1%" style="text-align: right;"></td> 
                                </tr>';  
                        echo '</tbody>
                    </table>
                                                               
                '; 
//             echo $html;
                       ?>
                                    </td></tr>
                        </table>
                    </div>
                    </div>
              </div>
                   <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $user_data['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url('Invoice_list'),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
              </div>
              <?php echo form_close();?>
        </div>
    </section>
</div>
</div>
    
   
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 80) {//80 for shit+p (print invoice)
           window.open('<?php echo base_url($this->router->fetch_class().'/sales_invoice_print/'.$cs_data['id']);?>');
        }
        if(e.keyCode == 78) {//80 for shit+p (print invoice)
           window.location.replace('<?php echo base_url('Invoices/add/');?>');
        }
        
    });
    
        
$(document).ready(function(){ 
        $("input[name = 'submit']").click(function(){
            if(confirm("Click Ok to confirmation for Cancel or Remove this Invoice")){
                return true;
            }else{
                return false;
            }
        });
});
</script>