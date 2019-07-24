<?php
//echo '<pre>';print_r($inv_data); die;
$inv_dets = $inv_data['invoice_dets'];
$inv_desc = $inv_data['invoice_desc'];
$inv_trans = $inv_data['inv_transection'];

//echo '<pre>';print_r($inv_data['invoice_desc']); die;

?>
<style>
    .colored_bg{
        background-color:#E0E0E0;
    }
    .table-line th, .table-line td {
        padding-bottom: 2px;
        border-bottom: 1px solid #ddd;
        text-align:center; 
        padding-left: 10px;
        padding-right: 10px;
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
            <a href="<?php echo base_url('Sales_orders/view/'.((isset($inv_dets['so_id'])?$inv_dets['so_id']:"")));?>" class="btn btn-app  <?php echo (($inv_dets['so_id']>0)?"":"hide");?>"><i class="fa fa-backward"></i>Back to Order</a>
            <a href="<?php echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], 'Payments', 'add'))?'<a id="add_payment_inv" href="#" class="btn btn-app "><i class="fa fa-money"></i>Payments</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$inv_dets['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete Invoice</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'sales_invoice_print'))?'<a id="inv_print_btn"  class="btn btn-app "><i class="fa fa-print"></i>Print Invoice</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'send_mail'))?'<a  id="send_mail_btn" class="btn btn-app "><i class="fa fa-envelope"></i>Send Invoice</a>':''; ?>

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
            <?php echo form_hidden('so_id',(($inv_dets['so_id']>0)?$inv_dets['so_id']:''));?>
              <!-- general form elements -->
              <div class="box box-primary"> 
                  <div class="box-body">
                <!-- /.box-header -->
                <!-- form start -->
               <div class="row header_form_sales"> 
                            <div class="col-md-12">
                                Invoice  Print Options: 
                                <!--<label><input type="checkbox" name="item_cat_slct[]" value="bank"> Include Bank info</label> &nbsp;&nbsp;&nbsp;-->
                                <label><input type="checkbox" name="item_cat_slct[]" value="cert">Include Certificates</label>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customer <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('customer_id',array($inv_dets['customer_name']),set_value('customer_id'),' class="form-control select2" data-live-search="true" id="customer_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Invoice# <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_no',set_value('invoice_no',$inv_dets['invoice_no']),' class="form-control " readonly id="invoice_no"');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    
                                    <label class="col-md-3 control-label">Payments<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',array($inv_dets['payement_term_id']=>$payment_term_list[$inv_dets['payement_term_id']]),set_value('payment_term_id',$inv_dets['payement_term_id']),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    
                                    <label class="col-md-3 control-label">Currency<span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',array($inv_dets['currency_code']=>$currency_list[$inv_dets['currency_code']]),set_value('currency_code',$inv_dets['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                            </div>
                            
                            <div class="col-md-4"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Reference <span style="color: red"></span></label>
                                        <div class="col-md-9">    
                                             <?php  echo form_input('reference',set_value('reference',$inv_dets['reference']),' class="form-control"  readonly id="reference"');?>
                                             <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                        </div> 
                                    </div>
                                <div hidden class="form-group">
                                    <label class="col-md-3 control-label">Sale Type <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('sales_type_id',$sales_type_list,set_value('sales_type_id',$inv_dets['sales_type_id']),' class="form-control select2" data-live-search="true" id="sales_type_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red"></span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('invoice_date',set_value('invoice_date',date('m/d/Y',$inv_dets['invoice_date'])),' class="form-control " readonly id="invoice_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('invoice_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <br>
                            </div>
                        </div>
             
                    <div class="box-body fl_scrollable_x">
                    <div class="col-md-12 col-md-offset-0">
                        <table width="100%" border="1">
                            <tr><td>
                    <?php
                          
                    foreach ($inv_desc as $inv_itms){ 
//                        echo '<pre>';                        print_r($inv_itms); 
                         echo '<table width="100%" id="example1" class="table-line" border="0">
                                    <thead>
                                        <tr class="colored_bg" style="background-color:#E0E0E0;">
                                             <th colspan="8">'.$inv_data['item_cats'][$inv_itms[0]['item_category']].'</th> 
                                         </tr>
                                        <tr style="">
                                             <th width="8%" style="text-align: center;"><u><b>Code</b></u></th>  
                                             <th width="20%" style="text-align: left;"><u><b>Description</b></u></th>
                                             <th  width="8%"><u><b>Treatment</b></u></th>   
                                             <th  width="8%"><u><b>Shape</b></u></th>   
                                             <th  width="8%"><u><b>Color</b></u></th>   
                                             <th  width="15%"><u><b>Units</b></u></th>   
                                             <th width="15%" style="text-align: right;"><u><b>Rate</b></u></th>    
                                             <th width="15%" style="text-align: right;"><u><b>Subtotal</b></u></th> 
                                         </tr>
                                    </thead>
                                <tbody>';

                     foreach ($inv_itms as $inv_itm){
//            echo '<pre>';            print_r($inv_itm); 
                         
                         echo     '<tr>
                                        <td width="8%" style="text-align: center;">'.$inv_itm['item_code'].'</td>  
                                        <td width="20%" style="text-align: left;">'.$inv_itm['item_description'].'</td>  
                                        <td width="8%" style="text-align: left;">'.$inv_itm['treatment_name'].'</td>  
                                        <td width="8%" style="text-align: left;">'.$inv_itm['shape_name'].'</td>  
                                        <td width="8%" style="text-align: left;">'.$inv_itm['color_name'].'</td>  
                                        <td width="15%">'.$inv_itm['item_quantity'].' '.$inv_itm['unit_abbreviation'].(($inv_itm['item_quantity_uom_id_2']>0)?' | '.$inv_itm['item_quantity_2'].' '.$inv_itm['unit_abbreviation_2']:'').'</td> 
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['unit_price'],2).'</td> 
                                        <td width="15%" style="text-align: right;">'. number_format($inv_itm['sub_total'],2).'</td> 
                                       
                                    </tr> ';
                     }
                     echo       ' <tr><td  colspan="8"> </td></tr></tbody></table>'; 
            }
            echo '
                    <table id="example1" width="100%" class="table-line" border="0">
                        
                       <tbody>
                                <tr><td  colspan="8"><br> </td></tr>
                                <tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b>Subtotal</b></td> 
                                    <td  width="19%"  style="text-align: right;"><b>'. number_format($inv_data['invoice_desc_total'],2).'</b></td> 
                                </tr>'; 
                                
                            $sub_total = $inv_data['invoice_desc_total'];
                             if(!empty($inv_data['invoice_addons'])){
                                    foreach ($inv_data['invoice_addons'] as $inv_addon){
                                        $sub_total += $inv_addon['addon_amount'];
                                        $addon_info = json_decode($inv_addon['addon_info'],true)[0];
                                        $percent = '';
                                        if($addon_info['calculation_type']==2){
                                            $percent = '('.$addon_info['addon_value'].' %)';
                                        }
//                                        echo '<pre>';         print_r($addon_info); die;
                                        
                                        echo '<tr>
                                                    <td  style="text-align: right;" colspan="4">'.$addon_info['addon_name'].' '.$percent.'</td> 
                                                    <td  width="19%"  style="text-align: right;">'. number_format($inv_addon['addon_amount'],2).'</td> 
                                                    
                                                </tr> '; 
                                    } 
                                        echo '<tr>
                                                    <td  style="text-align: right;" colspan="4">Total</td> 
                                                    <td  width="19%"  style="text-align: right;">'. number_format($sub_total,2).'</td> 
                                                    
                                                </tr> '; 
                                }
            
            
                        foreach ($inv_trans as $inv_tran){
                            echo '<tr>
                                        <td  style="text-align: right;" colspan="4">'.$inv_tran['trans_type_name'].(($inv_tran['payment_method']!='')?' ['.$inv_tran['payment_method'].']':'').'</td> 
                                        <td  width="19%"  style="text-align: right;">'. number_format($inv_tran['transection_ref_amount'],2).'</td> 
                                        
                                    </tr> ';

                        }
                        echo '<tr class="td_ht">
                                    <td style="text-align: right;" colspan="4"><b>Due Amount</b></td> 
                                    <td  width="19%"  style="text-align: right;"><input hidden id="due_amount" value="'.$inv_data['invoice_total'].'"><b>'. number_format($inv_data['invoice_total'],2).'</b></td> 
                                     
                                </tr></tbody>
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
                                    
                                    <?php echo form_hidden('id', $user_data['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php if($action != 'View'){?>
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor($this->router->fetch_class(),'Back','class="btn btn-info"');?>&nbsp;
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
    
<?php $this->load->view('sales_invoices/inv_modals/inv_checkout_cash_modal'); ?>
   
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 80) {//80 for shit+p (print invoice)
           window.open('<?php echo base_url($this->router->fetch_class().'/sales_invoice_print/'.$inv_dets['id']);?>');
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
        
        $('#send_mail_btn').click(function(){
            if(confirm("Please click ok button to confirm send."))
                send_mail_func();
        });
        
        $('#inv_print_btn').click(function(){
            var selected_cats = new Array(); 
            $.each($("input[name='item_cat_slct[]']:checked"), function() {
                selected_cats.push($(this).val());
            });
            var get_var = JSON.stringify(selected_cats)  
           window.open("<?php echo base_url($this->router->fetch_class().'/sales_invoice_print/'.$user_data['id']).'?prnt_optn=';?>"+get_var);
           return false;
        });
        
	function send_mail_func(){
            $(".content").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Sending...'); 
            $.ajax({
                            url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/sales_invoice_print/'.$user_data['id'].'/1');?>", 
                            type: 'post', 
                            success: function(result){ 
                                location.reload();
            }
                    });
	}
});
</script>