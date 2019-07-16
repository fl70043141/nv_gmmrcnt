<?php
	
	$result = array(
                        'id'=>"",
                        'consignee_id'=>"",  
                        'reference'=> 'G-'.date('Ymd-Hi'),
                        'return_date'=>date('m/d/Y'),
                        'item_discount'=>0,
                        'currency_code'=>$this->session->userdata(SYSTEM_CODE)['default_currency'],
                        'item_quantity'=>1,
                        'item_quantity_2'=>1,
                        );   		
	
	 
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Edit':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Edit';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
	break;
	
	case 'Delete':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'Delete';
		$dis		= 'readonly';
		$view		= '';
		$o_dis		= ''; 
		$check_bx_dis		= 'disabled'; 
	break;
      
	case 'View':
		if(!empty($user_data[0])){$result= $user_data[0];} 
		$heading	= 'View';
		$view		= 'hidden';
		$dis        = 'readonly';
		$o_dis		= 'disabled'; 
	break;
endswitch;	 

//var_dump($result);
?> 
<!-- Main content -->


<?php // echo '<pre>'; print_r($facility_list); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    
<!--    
        <div class="">
            <a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>
            <a href="<?php // echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>-->
    </div>
    
 <!--<br><hr>-->
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
              <!-- general form elements -->
              <div class="box box-primary"> 
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open($this->router->fetch_class()."/validate", 'id="form_search" class="form-horizontal"')?>  
            <?php echo form_hidden('form_action','receive','id="form_action"');?>
                    <div class="box-body">
                        
                        <div class="row header_form_sales"> 
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Consignee<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('consignee_id',$consignee_list,set_value('consignee_id'),' class="form-control select2" data-live-search="true" id="consignee_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('reference',set_value('reference',$result['reference']),' class="form-control" id="reference"');?>
                                         <!--<span class="help-block"><?php // echo form_error('reference');?>&nbsp;</span>-->
                                    </div> 
                                </div> 
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Payments<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('payment_term_id',$payment_term_list,set_value('payment_term_id'),' class="form-control select2" data-live-search="true" id="payment_term_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Currency<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date <span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_input('return_date',set_value('return_date',$result['return_date']),' class="form-control datepicker" readonly id="return_date"');?>
                                         <!--<span class="help-block"><?php // echo form_error('return_date');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Return_To<span style="color: red">*</span></label>
                                    <div class="col-md-9">    
                                         <?php  echo form_dropdown('location_id',$location_list,set_value('location_id'),' class="form-control select2" data-live-search="true" id="location_id"');?>
                                         <!--<span class="help-block"><?php // echo form_error('customer_type_id');?>&nbsp;</span>-->
                                    </div> 
                                </div>
                            </div> 
                        </div>
                        <div class="row"> 
                            <div id="result_search"></div>
                            <hr>
                            <div class="">
                                <div id='add_item_form' class="col-md-12 fl_scrollable_x bg-light-blue-gradient">
                                    
                                    <h4 class="">Search for Purchase return Return</h4> 
                                    <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-3 col-md-offset-1">  
                                                <div class="form-group pad">
                                                    <label for="cs_no">Submission No</label>
                                                    <?php  echo form_input('cs_no',set_value('cs_no'),' class="form-control" id="cs_no" placeholder="Search by Invoice Number"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="submit_from_date">Submit from</label>
                                                    <?php  echo form_input('submit_from_date',set_value('submit_from_date',date('m/d/Y',strtotime("-1 month"))),' class="form-control datepicker" readonly  id="submit_from_date"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="cs_no">Submit To</label>
                                                    <?php  echo form_input('submit_to_date',set_value('submit_to_date',date('m/d/Y')),' class="form-control datepicker" readonly  id="submit_to_date"');?>
                                                </div> 
                                        </div>   
                                        <div class="col-md-1">
                                            <div class="form-group pad"><br>
                                                <span id="add_item_btn" class="btn-default btn add_item_inpt pad"><span class="fa fa-search"></span> Search
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="box-body fl_scrollable_x_y"> 
                                    <table id="invoice_list_tbl" class="table table-bordered table-striped fl_scrollable">
                                        <thead>
                                           <tr> 
                                               <th width="10%"  style="text-align: center;">Submission Info</th> 
                                               <th width="30%"  style="text-align: center;">Item Info</th> 
                                               <th width="10%" style="text-align: center;">Cons. Type</th> 
                                               <th width="10%" style="text-align: center;">Cons. Rate</th> 
                                               <th width="10%" style="text-align: center;" colspan="2">Qty to Credit</th> 
                                               <th width="10%" style="text-align: center;">price/Unit</th> 
                                               <th width="15%" style="text-align: right;">Total</th> 
                                               <th width="5%" style="text-align: center;">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody id="top_rows_restbl">.
                                       </tbody>
                                       <tbody id="bottom_rows_restbl" >
                                           
                                       </tbody>
                                       <tfoot>  
                                            <tr>
                                                <th colspan="3"></th>
                                                <th colspan="1" style="text-align: right;"><span id="tot_con_amount"></span></th>
                                                <th colspan="2"></th>
                                                <th  style="text-align: right;">Total</th>
                                                <th  style="text-align: right;"><input hidden value="0" name="invoice_total" id="invoice_total"><span id="inv_total">0</span></th>
                                            </tr> 
                                       </tfoot>
                                        </table>
                                </div>
                                <div id="search_result_1"></div>
                            </div>    
                        </div>
                        <div class="row" id="footer_sales_form">
                            <hr>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="memo" class="col-sm-4 control-label">Memo</label>

                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="memo"></textarea>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-sm-8">
                                <button id="place_receive" class="btn btn-app pull-right  primary"><i class="fa fa-check"></i>Receive</button>
                                <button id="place_invoice" class="btn btn-app pull-right  primary"><i class="fa fa-file-text-o"></i>Create Invoice</button>
                
                            </div>
                        </div>
                    </div>
                
              </div>
    </section>      
                            
                            <?php echo form_hidden('id', $result['id']); ?>
                            <?php echo form_hidden('action',$action); ?>
                            <?php echo form_close(); ?>               
                                
                         
                            
    </div>
        <div class="col-md-12">
            <div class="box">
               <!-- /.box-header -->
               <!-- /.box-body -->
             </div>

        </div>
</div>
    
<script>
    
$(document).keypress(function(e) {
//    fl_alert('info',e.keyCode)
        if(e.keyCode == 13) {//13 for enter
//            if ($(".add_item_inpt").is(":focus")) {
                    $('#add_item_btn').trigger('click');
//                fl_alert('info',)
//              }
            $('#item_code').focus();
            return false;

        }
        if(e.keyCode == 10) {//submit for  ctr+ enter
            $('#place_invoice').trigger('click');
        }
    });
$(document).ready(function(){ 
    $('#add_item_btn').click(function(){ 
        get_inv_items_res()
    });
    
     $("#place_invoice").click(function(){
         $('[name="form_action"]').val('invoice'); 
            if(!confirm("click ok to Confirm the Form Submission.")){
                  return false;
              }else{
                  if($('input[name^="inv_items_btm"]').length<=0){
                      fl_alert('info',"Atleast one item need to create an Credit Note!")
                      return false;
                  }
              }
    });
     $("#place_receive").click(function(){
         $('[name="form_action"]').val('receive'); 
          if(!confirm("click ok to Confirm the Form Submission.")){
                return false;
            }else{
                if($('input[name^="inv_items_btm"]').length<=0){
                    fl_alert('info',"Atleast one item need to create an Credit Note!")
                    return false;
                }
            }
            
    });
});

function get_inv_items_res(){ 
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'get_search_res_ret_items'});
    
        $.ajax({
                url: "<?php echo site_url('Consignee_receive/fl_ajax');?>",
                type: 'post',
                data : post_data,
                success: function(result){ 
//                                $("#result_search").html(result);
                                var res2 = JSON.parse(result); 
                                $('#bottom_rows_restbl tr').remove();
                                var rowCount = $('#bottom_rows_restbl tr').length;
                                var rowCount = rowCount+1;     
                                var total = 0;

                                $(res2).each(function (index, elment) {
//                                    console.log(elment); 
                                    
//                                    fl_alert('info',elment.item_quantity)
                                    var submitted_date = timeConverter(elment.submitted_date);
                                    elment.unit_price = parseFloat(elment.unit_price)*(100-parseFloat(elment.discount_persent))*0.01 ;
                                    var sub_tot = parseFloat(elment.item_quantity)* parseFloat(elment.unit_price);
                                    
                                    var cons_typ= ''; var cons_rate = '';
                                    switch(elment.consignment_type_id){
                                        case '1': cons_typ = '(Percentage)'; cons_rate = (sub_tot*parseFloat(elment.consignment_rate)*0.01)+"("+parseFloat(elment.consignment_rate)+'%)'; break;
                                        case '2': cons_typ = '(Percentage Included)'; cons_rate = (sub_tot*parseFloat(elment.consignment_rate)*0.01)+"("+parseFloat(elment.consignment_rate)+'%)';break;
                                        case '3': cons_typ = '(Fixed Amount)'; cons_rate = parseFloat(elment.consignment_rate).toFixed(2);break;
                                        case '4': cons_typ = '(Fixed Amount Included)';cons_rate = parseFloat(elment.consignment_rate).toFixed(2); break;
                                    }
                                    
                                    var newRow = '<tr class="row_btm_cls" id="rowb_'+elment.sd_id+'">'+
                                                        '<td style="text-align: center;"><ul>'+
                                                                                            '<li>'+elment.cs_no+'<input hidden id="'+elment.sd_id+'_cs_no" value="'+elment.cs_no+'"></li>'+
                                                                                            '<li>Date: '+submitted_date+'<input hidden id="'+elment.sd_id+'_cs_date" value="'+elment.submitted_date+'"></li>'+
                                                        '</ul></td>'+
                                                        '<td style="text-align: left;"><ul>'+
                                                                '<li>Code: '+elment.item_code+'</li>'+
                                                                '<li>Desc: '+elment.item_description+'<input hidden id="'+elment.sd_id+'_item_description" value="'+elment.item_description+'"></li>'+
                                                                '<li>Units: '+elment.item_quantity+' '+elment.unit_abbreviation+((elment.item_quantity_uom_id_2>0)?(' | '+elment.item_quantity_2+' '+elment.unit_abbreviation_2):'')+'<input hidden  id="'+elment.sd_id+'_item_quantity" value="'+elment.item_quantity+'"></li>'+
                                                            '</ul><input hidden id="'+elment.sd_id+'_item_code" value="'+elment.item_code+'"><input hidden id="'+elment.sd_id+'_item_id" value="'+elment.item_id+'"></td>'+
                                                    '<td style="text-align: left;" class="cons_type_td"><span class="cons_type_text">'+cons_typ+'</span><select class="cons_type_input" hidden id="'+elment.sd_id+'_cons_type_id">'+
                                                        '<option '+((elment.consignment_type_id==2)?'selected':'')+' value="2">Percentage (Included Rate)</option>'+
                                                        '<option '+((elment.consignment_type_id==4)?'selected':'')+' value="4">Fixed Amount (Included)</option>'+
                                                    '</select></td>'+
                                                    '<td class="cons_rate_td" style="text-align: left;"><span class="cons_rate_text">'+cons_rate+'</span><input class="cons_rate_inpt" hidden step="1" type="number" id="'+elment.sd_id+'_cons_rate"  value="'+elment.consignment_rate+'"></td>';
                                        if(elment.item_quantity_uom_id_2>0){
                                            newRow +=   '<td style="text-align: left;">'+elment.unit_abbreviation+'<input  step="0.01" max="'+elment.item_quantity+'" type="number" id="'+elment.sd_id+'_unit_to_credit" class="unit1_cls" value="'+elment.item_quantity+'"><input hidden  id="'+elment.sd_id+'_uom_abr" value="'+elment.unit_abbreviation+'"><input hidden  id="'+elment.sd_id+'_uom_id" value="'+elment.item_quantity_uom_id+'"></td>'+
                                                        '<td style="text-align: left;">'+elment.unit_abbreviation_2+'<input step="1" max="'+elment.item_quantity_2+'" type="number" id="'+elment.sd_id+'_unit_to_credit_2" class="unit2_cls" value="'+elment.item_quantity_2+'"><input hidden  id="'+elment.sd_id+'_uom_abr_2" value="'+elment.unit_abbreviation_2+'"><input hidden  id="'+elment.sd_id+'_uom_id_2" value="'+elment.item_quantity_uom_id_2+'"></td>';
                                        }else{
                                             newRow +=   '<td style="text-align: left;" colspan="2">'+elment.unit_abbreviation+'<br><input  step="0.01" max="'+elment.item_quantity+'" type="number" min="0" max="'+elment.item_quantity_1+'" class="unit1_cls" id="'+elment.sd_id+'_unit_to_credit"  value="'+elment.item_quantity+'"><input hidden  id="'+elment.sd_id+'_uom_abr" value="'+elment.unit_abbreviation+'"><input hidden  id="'+elment.sd_id+'_uom_id" value="'+elment.item_quantity_uom_id+'"></td>';
                                        }
                                            newRow +=  '<td style="text-align: left;">'+elment.currency_code+((parseFloat(elment.discount_persent)>0)?'['+elment.discount_persent+'% Discount inc]':'')+'<input step="1" type="number" id="'+elment.sd_id+'_unit_price" class="" value="'+parseFloat(elment.unit_price).toFixed(4)+'"><input hidden type="number" id="'+elment.sd_id+'_unit_price_floted" class="price_cls" value="'+parseFloat(elment.unit_price)+'"></td>'+
                                                       '<td style="text-align: right;"><b><span class="subtot_cls">'+sub_tot.toFixed(2)+'</span><input hidden class="subtot_cls_inpt" id="'+elment.sd_id+'_sub_tot" value="'+sub_tot+'"></b></td>'+
                                                       '<td><span  id="'+elment.sd_id+'" class="btn btn-success fa fa-plus add_res_row"></span></td>'+
                                                  '</tr>';
                                    jQuery('#bottom_rows_restbl').append(newRow); 
                                    recalculate_totals();
                                    
                                    $('.cons_rate_td').click(function(){  
                                        var tr_id = $(this).closest('tr').attr('id'); 
                                        $('#'+tr_id+' #'+elment.sd_id+'_cons_rate').addClass("form-control");
                                        $('#'+tr_id+' #'+elment.sd_id+'_cons_rate').show().focus().select();  
                                    });
                                    $('.cons_rate_inpt').focusout(function(){    
                                        var tr_id = $(this).closest('tr').attr('id'); 
                                        $('#'+tr_id+' .cons_rate_td .cons_rate_text').text(parseFloat($(this).val()).toFixed(2));
                                        $(this).removeClass('form-control');
                                        recalculate_totals();
                                    });
                                    
                                    $('.cons_type_td').click(function(){  
                                        var tr_id = $(this).closest('tr').attr('id'); 
                                        $('#'+tr_id+' #'+elment.sd_id+'_cons_type_id').addClass("form-control");
                                        $('#'+tr_id+' #'+elment.sd_id+'_cons_type_id').show().focus().select();  
                                    });
                                    $('.cons_type_input').focusout(function(){     
                                        var tr_id = $(this).closest('tr').attr('id'); 
                                        $('#'+tr_id+' .cons_type_text').text($("#"+this.id+" option:selected").text());
                                        $(this).removeClass('form-control');
                                        recalculate_totals();
                                    });
                             });
                             
                                    $('.add_res_row').click(function(){
                                        
                                        var add_id = this.id;
                                        var add_cons_type_id = $("#"+add_id+"_cons_type_id").val();
                                        var add_cons_type_name = $("#"+add_id+"_cons_type_id option:selected").text();
                                        var add_cons_rate = $("#"+add_id+"_cons_rate").val();
                                        var add_cons_rate_text = $("#rowb_"+add_id+" .cons_rate_text").text();
                                        var add_cs_no = $("#"+add_id+"_cs_no").val()
                                        var add_cs_date = $("#"+add_id+"_cs_date").val()
                                        var add_item_code = $("#"+add_id+"_item_code").val()
                                        var add_item_id = $("#"+add_id+"_item_id").val()
                                        var add_item_description = $("#"+add_id+"_item_description").val()
                                        var add_unit_price = $("#"+add_id+"_unit_price").val()
                                        var add_item_quantity = $("#"+add_id+"_item_quantity").val()
                                        var add_unit_to_credit = $("#"+add_id+"_unit_to_credit").val();
                                        var add_unit_to_credit_2 =(typeof $("#"+add_id+"_unit_to_credit_2").val()!== 'undefined')?$("#"+add_id+"_unit_to_credit_2").val():0;
                                        var add_cs_date =  timeConverter($("#"+add_id+"_cs_date").val());

                                        var add_uom_id = $("#"+add_id+"_uom_id").val();
                                        var add_uom_id_2 = (typeof $("#"+add_id+"_uom_id_2").val()!== 'undefined')?$("#"+add_id+"_uom_id_2").val():0;

                                        var add_uom_abr =  $("#"+add_id+"_uom_abr").val();
                                        var add_uom_abr_2 =  (typeof $("#"+add_id+"_uom_abr_2").val()!== 'undefined')?$("#"+add_id+"_uom_abr_2").val():0;
//                                       fl_alert('info',add_uom_abr_2)
                                        var add_sub_tot = parseFloat(add_unit_to_credit)* parseFloat(add_unit_price);
//                                     
                                        var newRow = '<tr class="row_top_cls" id="rowt_'+add_id+'">'+
                                                        '<td style="text-align: center;"><ul><li>'+add_cs_no+'<input hidden name="inv_items_btm['+add_id+'][cs_no]" value="'+add_cs_no+'"></li>'+
                                                        '<li>'+add_cs_date+'<input hidden name="inv_items_btm['+add_id+'][cs_date]" value="'+add_cs_date+'"></li></ul></td>'+
                                                        '<td style="text-align: left;">'+
                                                            '<ul>'+
                                                                '<li>Code: '+add_item_code+'<input hidden name="inv_items_btm['+add_id+'][item_code]" value="'+add_item_code+'"><input hidden name="inv_items_btm['+add_id+'][item_id]" value="'+add_item_id+'"></li>'+
                                                                '<li>Desc: '+add_item_description+'<input hidden name="inv_items_btm['+add_id+'][item_description]" value="'+add_item_description+'"></li>'+
                                                                '<li>Units: '+add_item_quantity+' '+add_uom_abr+'<input hidden name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_item_quantity+'"></li>'+
                                                            '</ul>'+
                                                        '</td>'+
                                                        '<td style="text-align: center;">'+add_cons_type_name+'<input hidden name="inv_items_btm['+add_id+'][cons_type_id]" value="'+add_cons_type_id+'"></td>'+
                                                        '<td style="text-align: center;">'+add_cons_rate_text+'<input hidden name="inv_items_btm['+add_id+'][cons_rate]" value="'+add_cons_rate+'"></td>'+
                                                        '<td style="text-align: center;" colspan="2">'+parseFloat(add_unit_to_credit).toFixed(2)+' '+add_uom_abr+((add_uom_abr_2!=0)?'| '+add_unit_to_credit_2+' '+add_uom_abr_2:'')+'<input hidden name="inv_items_btm['+add_id+'][item_quantity]" value="'+add_unit_to_credit+'"><input hidden name="inv_items_btm['+add_id+'][item_quantity_2]" value="'+add_unit_to_credit_2+'"><input hidden name="inv_items_btm['+add_id+'][uom_id]" value="'+add_uom_id+'"><input hidden name="inv_items_btm['+add_id+'][uom_id_2]" value="'+add_uom_id_2+'"></td>'+
                                                        '<td style="text-align: right;">'+parseFloat(add_unit_price).toFixed(2)+'<input hidden name="inv_items_btm['+add_id+'][unit_price]" value="'+parseFloat(add_unit_price)+'"></td>'+
                                                        '<td style="text-align: right;"><b><span class="subtot_cls_top">'+add_sub_tot.toFixed(2)+ '</span><input hidden class="subtot_cls_top_inpt" name="inv_items_btm['+add_id+'][sub_tot]" id="remove_subtot_'+add_id+'" value="'+add_sub_tot+'"></b></td>'+
                                                        '<td><span  id="add_'+add_id+'" class="btn btn-danger fa fa-trash remove_res_row"></span>'+'<input hidden id="add_'+add_id+'_remove" value="'+add_id+'"></td>'+
                                                  '</tr>';
                                            jQuery('#top_rows_restbl').append(newRow); 
                                            
                                            var add_total = parseFloat($("#invoice_total").val()) + add_sub_tot; 
//                                            $('#invoice_total').val(add_total);
//                                            $('#inv_total').text(add_total.toFixed(2));
                                            
                                            $('#rowb_'+add_id).hide();
                                              
                                            $('.remove_res_row').click(function(){
                                                var rmv_id = $('#'+this.id+"_remove").val();
                                                $('#rowt_'+rmv_id).remove();
                                                $('#rowb_'+rmv_id).show();
                                                recalculate_totals();
                                            });
                                               recalculate_totals();
                                    });
                    }
        });
}

    function recalculate_totals(){
        var tot_cons = 0; var totl="";
        $('.row_btm_cls').each(function() {  
            var cons_amount=0;
            var ds_id = this.id;
            var cons_type_id = $("#"+ds_id+" .cons_type_input").val();
            var unit1 =  parseFloat($("#"+ds_id+" .unit1_cls").val());
            var prc =  parseFloat($("#"+ds_id+" .price_cls").val());
            var cons_rate =  parseFloat($("#"+ds_id+" .cons_rate_inpt").val());
            var sub_totl =  prc*unit1;
            switch(cons_type_id){
                case '1': cons_amount = (unit1*prc*cons_rate)*0.01 ; tot_cons += cons_amount; sub_totl+= cons_amount; 
                          $('#'+ds_id+' .cons_rate_td .cons_rate_text').text(cons_amount.toFixed(2)+" ("+cons_rate.toFixed(2)+")%");
                          break;
                case '2': cons_amount = (unit1*prc*cons_rate)*0.01 ; tot_cons += cons_amount;
                          $('#'+ds_id+' .cons_rate_td .cons_rate_text').text(cons_amount.toFixed(2)+" ("+cons_rate.toFixed(2)+")%");
                          break;
                case '3': cons_amount = cons_rate ; tot_cons += cons_amount; sub_totl+= cons_amount; 
                          $('#'+ds_id+' .cons_rate_td .cons_rate_text').text(cons_rate.toFixed(2));
                          break;
                case '4': cons_amount = cons_rate ; tot_cons += cons_amount; 
                          $('#'+ds_id+' .cons_rate_td .cons_rate_text').text(cons_rate.toFixed(2));
                          break;
            }
            
            totl +=  sub_totl;
            $('#'+ds_id+" .subtot_cls").text(sub_totl.toFixed(2));
            $('#'+ds_id+" .subtot_cls_inpt").val(sub_totl);
        });
        
        
        var tot_cons_top = 0; var totl_top=0;
        $('.row_top_cls').each(function() {  
            var cons_amount_top=0;
            var ds_id = this.id;
            var row_id = parseFloat(ds_id.split("_")[1]);
            var cons_type_id = $("[name='inv_items_btm["+row_id+"][cons_type_id]'").val();
            var unit1 =  parseFloat($("[name='inv_items_btm["+row_id+"][item_quantity]'").val());
            var prc =  parseFloat($("[name='inv_items_btm["+row_id+"][unit_price]'").val());
            var cons_rate =   parseFloat($("[name='inv_items_btm["+row_id+"][cons_rate]'").val());
            
//            alert(unit1+'--'+prc+"--"+cons_rate)
            var sub_totl =  prc*unit1;
            switch(cons_type_id){
                case '1': cons_amount_top = (unit1*prc*cons_rate)*0.01 ; tot_cons_top += cons_amount_top; sub_totl+= cons_amount_top; 
                          break;
                case '2': cons_amount_top = (unit1*prc*cons_rate)*0.01 ; tot_cons_top += cons_amount_top;
                          break;
                case '3': cons_amount_top = cons_rate ; tot_cons_top += cons_amount_top; sub_totl+= cons_amount_top; 
                          break;
                case '4': cons_amount_top = cons_rate ; tot_cons_top += cons_amount_top; 
                          break;
            }
            
            totl_top +=  sub_totl;
            $('#'+ds_id+" .subtot_cls_top").text(sub_totl.toFixed(2));
            $('#'+ds_id+" .subtot_cls_top_inpt").val(sub_totl.toFixed(2));
        });
        $('#invoice_total').val(totl_top)
        $('#inv_total').text(totl_top.toFixed(2))
        $('#tot_con_amount').text(tot_cons_top.toFixed(2))
    }
function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp * 1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes();
  var sec = a.getSeconds();
  var time = date + ' ' + month + ' ' + year ;
  return time;
}
</script>
 