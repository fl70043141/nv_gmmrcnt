<?php
	
	$result = array(
                        'id'=>"",
                        'consignee_name'=>"",
                        'consignee_short_name'=>"",
                        'description'=>"",
                        'address'=>"", 
                        'phone'=>"",
                        'phone2'=>"",
                        'email'=>"",
                        'bank_acc_number'=>"",
                        'bank_acc_name'=>"",
                        'bank_name'=>"",
                        'bank_acc_branch'=>"",
                        'commission_plan'=>"",
                        'commission_amount'=>"",
                        'status'=>1
                        );   		
	
	 
	 $add_hide ='';
	switch($action):
	case 'Add':
		$heading	= 'Add';
		$dis		= '';
		$view		= '';
		$o_dis		= ''; 
		$add_hide       = 'hidden'; 
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
 <br>
        <div class="col-md-12">
            
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
            <div class="top_links">
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-backward"></i>Back</a>':''; ?>
               <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="'.$add_hide.' btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?> 
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'.base_url($this->router->fetch_class().'/edit/'.$result['id']).'" class="'.$add_hide.' btn btn-app "><i class="fa fa-pencil"></i>Edit</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="'.$add_hide.' btn btn-app  '.(($action=='Delete')?'hide ':'').' "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                 
            </div>
        </div>
 <br><hr>
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title"><?php echo $action;?> </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
             <?php echo form_open_multipart($this->router->fetch_class()."/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                            <div class="col-md-6">
                                        
                                         <h5>Consignee Information</h5>
                                         <hr> 
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Consignee Name<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('consignee_name', set_value('consignee_name',$result['consignee_name']), 'id="consignee_name" class="form-control" placeholder="Enter Consignee Name"'.$dis.' '.$o_dis.' '); ?>
                                                   <?php echo form_error('consignee_name');?>&nbsp;
                                                </div> 
                                            </div>
                                            
                                         
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Short Name<span style="color: red"></span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('consignee_short_name', set_value('consignee_short_name',$result['consignee_short_name']), 'id="consignee_short_name" class="form-control" placeholder="Enter short name"'.$dis.' '.$o_dis.' '); ?>
                                                   <?php echo form_error('consignee_short_name');?>&nbsp;
                                                </div> 
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Description</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group"> 
                                                        
                                                         <?php echo form_textarea(array('name'=>'description','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter description' ), set_value('description', $result['description']),$dis.' '.$o_dis.' '); ?>

                                                    </div>                                            
                                                   <?php echo form_error('description');?><br>
                                                </div>
                                            </div> 
                                            
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Active</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                         <label class="switch  switch-small">
                                                            <!--<input type="checkbox"  value="0">-->
                                                            <?php echo form_checkbox('status', set_value('status','1'),$result['status'], 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                            <span></span>
                                                        </label>
                                                     </div>                                            
                                                    <?php echo form_error('status');?>&nbsp;
                                                </div>
                                            </div> 
                                        
                                         <h5>Consignee Payments Info </h5>
                                       <hr>          
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C No</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_acc_number', set_value('bank_acc_number',$result['bank_acc_number']), 'id="bank_acc_number" class="form-control" placeholder="Enter Bank Account No"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('bank_acc_number');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Name</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_acc_name', set_value('bank_acc_name',$result['bank_acc_name']), 'id="bank_acc_name" class="form-control" placeholder="Enter Bank Account name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_acc_name');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank </label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_name', set_value('bank_name',$result['bank_name']), 'id="bank_name" class="form-control" placeholder="Enter Bank Name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_name');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Branch</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_acc_branch', set_value('bank_acc_branch',$result['bank_acc_branch']), 'id="bank_acc_branch" class="form-control" placeholder="Enter Bank Account Branch"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_acc_branch');?>&nbsp; 
                                                    </div>
                                            </div>
                                       
                                    </div>
                            
                                    <div class="col-md-6 ">
                                        <h5>Contact Information</h5>
                                         <hr> 
                                         
                                           <div class="form-group">
                                                <label class="col-md-3 control-label">Street Address<span style="color: red"> </span></label>
                                                <div class="col-md-9">    
                                                     <?php echo form_input('address', set_value('address',$result['address']), 'id="address" class="form-control" placeholder="Enter Address info"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('address');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Phone<span style="color: red">*</span></label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('phone', set_value('phone',$result['phone']), 'id="phone" class="form-control" placeholder="Enter Phone Number"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('phone');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Other Phone</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('phone2', set_value('phone2',$result['phone2']), 'id="phone2" class="form-control" placeholder="Enter other number [Whatsapp..]"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('phone2');?>&nbsp;
                                                </div> 
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">    
                                                    <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Email Address"'.$dis.' '.$o_dis.' '); ?>
                                                    <?php echo form_error('email');?>&nbsp;
                                                </div> 
                                            </div>  

                                       <h5>Consignee Commission Info </h5>
                                       <hr>          
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Commission Plan</label>
                                                    <div class="col-md-9">    
                                                        <?php  echo form_dropdown('commission_plan',array(1=>'Percentage(%)',2=>'Fixed Amount'),set_value('commission_plan',$result['commission_plan']),' class="form-control select2" data-live-search="true" id="commission_plan"');?>
                                                        <?php echo form_error('commission_plan');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Commish. Amount</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('commission_amount', set_value('commission_amount',$result['commission_amount']), 'id="commission_amount" class="form-control" placeholder="Enter Commission Amount"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('commission_amount');?>&nbsp; 
                                                    </div>
                                            </div>   
                                    </div> 
                                            
                                       
                                        
                        </div>
                    </div>
                          <!-- /.box-body -->

                    <div class="box-footer">
                          <!--<butto style="z-index:1" n class="btn btn-default">Clear Form</button>-->                                    
                                    <!--<button class="btn btn-primary pull-right">Add</button>-->  
                                    <?php if($action != 'View'){?>
                                    <?php echo form_hidden('id', $result['id']); ?>
                                    <?php echo form_hidden('action',$action); ?>
                                    <?php echo form_submit('submit', constant($action) ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php // echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

                                 <?php }else{ 
                                        echo form_hidden('action',$action);
                                        echo anchor(site_url($this->router->fetch_class()),'OK','class="btn btn-primary"');
                                    } ?>
                      <!--<button type="submit" class="btn btn-primary">Submit</button>-->
                    </div>
                  </form>
                </div>
                <!-- /.box -->
          </div> 
    </section> 
 
 
<!--     //image Lightbox-->
     <div tabindex="-1" class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
            <div class="modal-content"> 
                  <div align="" class="modal-body">
                      <div><center><img class="model_img"   src=""></center> </div>
                  </div>
                  <div class="modal-footer">
                          <button class="btn btn-default" data-dismiss="modal">Close</button>
                  </div>
             </div>
            </div>
          </div>
 <style>
    .modal-dialog {width:800px;}
    .thumbnail {margin-bottom:6px;}
    .modal-body {width:800px; align:center;}
    .model_img {width: 500px;}
</style>
<script>
    
$(document).ready(function(){ 
    $("form").submit(function(){ 
        if(!confirm("Click Ok to Confirm form Submition.")){
               return false;
        }
    });
 
    $(".top_links a").click(function(){ 
        if($('input[name=action]').val()=='Add' || $('input[name=action]').val()=='Edit'){
            if(!confirm("Click Ok to Confirm leave from here. This form may have unsaved data.")){
                   return false;
            }
        }
    });
    
    $('#icon_view').addClass($('#icon').val());
    $("#icon").keyup(function(){ 
//		fl_alert('info',);
                $('#icon_view').removeClass();
                $('#icon_view').addClass($('#icon').val());
    });
     $('.thumbnail').click(function(){ 
                      var title = $(this).parent('a').attr("src");
                      $(".model_img").attr("src",this.src); 
                      $('#myModal').modal({show:true});
                      
              }); 
});
</script>