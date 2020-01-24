<?php
	
	$result = array(
                        'id'=>"",
                        'company_name'=>"",
                        'street_address'=>"",
                        'city'=>"",
                        'state'=>"",
                        'country'=>"",
                        'currency_code'=>"",
                        'zipcode'=>"",
                        'phone'=>"",
                        'fax'=>"",
                        'other_phone'=>"",
                        'email'=>"",
                        'website'=>"",
                        'company_type'=>"",
                        'company_grade'=>"",
                        'reg_no'=>"",
                        'logo'=>"",
                        'status'=>"",
                        'bank_details'=>"",


                        'bank_name'=>"",
                        'bank_code'=>"",
                        'swift_code'=>"",
                        'bank_account_number'=>"",
                        'bank_account_name'=>"",
                        'bank_account_branch'=>"",
                        'bank_account_branch_code'=>"",
                        'bank_account_branch_address'=>"",
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
            <div class="">
                 <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-search"></i>Search</a>':''; ?>
                <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'.base_url($this->router->fetch_class().'/delete/'.$result['id']).'" class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>':''; ?>
                <!--<a class="btn btn-app "><i class="fa fa-trash"></i>Delete</a>-->
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
              
             <?php echo form_open_multipart("company/validate"); ?> 
   
                    <div class="box-body fl_scroll">
                              
                        <div class="row"> 
                                  <div class="col-md-6">
                                            <h4>Company Information</h4>
                                            <hr>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Company Name<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('company_name', set_value('company_name',$result['company_name']), 'id="company_name" class="form-control" placeholder="Enter Company Name"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('company_name');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Street Address<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('street_address', set_value('street_address',$result['street_address']), 'id="street_address" class="form-control" placeholder="Enter Street Address"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('street_address');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">City<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('city', set_value('city',$result['city']), 'id="city" class="form-control" placeholder="Enter city"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('city');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">State</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('state', set_value('state',$result['state']), 'id="state" class="form-control" placeholder="Enter State"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('state');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                              <div class="form-group">
                                                  <label class="col-md-3 control-label">Country<span style="color: red">*</span></label>
                                                  <div class="col-md-9">                                            
                                                      <div class="input-group">
                                                          <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                           <?php  echo form_dropdown('country',$country_list,set_value('country',$result['country']),' class="form-control select2" data-live-search="true" id="country"'.$o_dis.'');?>
                                                       </div>                                            
                                                      <span class="help-block"><?php echo form_error('country');?>&nbsp;</span>
                                                  </div>
                                              </div>
                                          </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Zip Code</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('zipcode', set_value('zipcode',$result['zipcode']), 'id="zipcode" class="form-control" placeholder="Enter Zip Code" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('zipcode');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Phone<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('phone', set_value('phone',$result['phone']), 'id="phone" class="form-control" placeholder="Enter Phone Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('phone');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Fax</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('fax', set_value('fax',$result['fax']), 'id="fax" class="form-control" placeholder="Enter Fax Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('fax');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Other Phone</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('other_phone', set_value('other_phone',$result['other_phone']), 'id="other_phone" class="form-control" placeholder="Enter Secendory Phone Number.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('other_phone');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Email</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('email', set_value('email',$result['email']), 'id="email" class="form-control" placeholder="Enter Company Email Address.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('email');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Web site</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('website', set_value('website',$result['website']), 'id="website" class="form-control" placeholder="Enter Website URL.." style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('website');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            
                                        <div class="col-md-6">
                                            <h4>Other Information</h4> 
                                                    <hr>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Company type<span style="color: red">*</span></label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('company_type', set_value('company_type',$result['company_type']), 'id="company_type" class="form-control" placeholder="Enter Company Type" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('company_type');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Gem License No</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('company_grade', set_value('company_grade',$result['company_grade']), 'id="company_grade" class="form-control" placeholder="Enter Gem License No" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('company_grade');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Registration No</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input('reg_no', set_value('reg_no',$result['reg_no']), 'id="reg_no" class="form-control" placeholder="Enter registraion Number" style="z-index: 1;"'.$dis.' '.$o_dis.' '); ?>

                                                        </div>                                            
                                                        <span class="help-block"><?php echo form_error('reg_no');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                        <label class="col-md-3 control-label">Bank details<span style="color: red"></span></label>
                                                        <div class="col-md-9">
                                                            <?php echo form_textarea(array('name'=>'bank_details','rows'=>'4','cols'=>'60', 'class'=>'form-control', 'placeholder'=>'Enter bank_details' ), set_value('bank_details',$result['bank_details']),$dis.' '.$o_dis.' '); ?>
                                                            <span class="help-block"><?php echo form_error('bank_details');?></span>
                                                        </div>
                                                    </div>
                                            </div>
                                             
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Company Logo</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                             <?php echo form_input(array('name'=>'logo', 'id'=>'logo', 'class'=>'form-control', 'type'=>'file'));?>
								
                                                        </div>    
                                                        <div><img style="size: 100%; width:100px;"  src="<?php echo base_url().COMPANY_LOGO.$result['logo'];?>"></div>
                                                        <span class="help-block"><?php echo form_error('logo');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12"> 
                                                <div class="col-md-12">
                                                  <div class="form-group">
                                                      <label class="col-md-3 control-label">Default Currency<span style="color: red">*</span></label>
                                                      <div class="col-md-9">                                            
                                                          <div class="input-group">
                                                              <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                               <?php  echo form_dropdown('currency_code',$currency_list,set_value('currency_code',$result['currency_code']),' class="form-control select2" data-live-search="true" id="currency_code"'.$o_dis.'');?>
                                                           </div>                                            
                                                          <span class="help-block"><?php echo form_error('currency_code');?>&nbsp;</span>
                                                      </div>
                                                  </div>
                                              </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Company Active</label>
                                                    <div class="col-md-9">                                            
                                                        <div class="input-group">
                                                             <label class="switch  switch-small">
                                                                <!--<input type="checkbox"  value="0">-->
                                                                <?php echo form_checkbox('status', set_value('status','1'),$result['status'], 'id="status" placeholder=""'.$dis.' '.$o_dis.' '); ?>
                                                                <span></span>
                                                            </label>
                                                         </div>                                            
                                                        <span class="help-block"><?php echo form_error('status');?>&nbsp;</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                        </div>
                           
                        <div class="col-md-6 hide" >
                                       <h5>Company bank account </h5>
                                       <hr>          
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank Name</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_name', set_value('bank_name',$result['bank_name']), 'id="bank_name" class="form-control" placeholder="Enter Bank Name"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('bank_name');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank Code</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_code', set_value('bank_code',$result['bank_code']), 'id="bank_code" class="form-control" placeholder="Enter Bank Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('bank_code');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Swift Code</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('swift_code', set_value('swift_code',$result['swift_code']), 'id="swift_code" class="form-control" placeholder="Enter Bank Swift Code"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('swift_code');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C No</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_number', set_value('bank_account_number',$result['bank_account_number']), 'id="bank_account_number" class="form-control" placeholder="Enter Bank Account No"'.$dis.' '.$o_dis.' '); ?>
                                                        <?php echo form_error('bank_account_number');?>&nbsp;
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Name</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_name', set_value('bank_account_name',$result['bank_account_name']), 'id="bank_account_name" class="form-control" placeholder="Enter Bank Account name"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_name');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Bank A/C Branch</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_branch', set_value('bank_account_branch',$result['bank_account_branch']), 'id="bank_account_name" class="form-control" placeholder="Enter Bank Account Branch"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_branch');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Branch Code</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_branch_code', set_value('bank_account_branch_code',$result['bank_account_branch_code']), 'id="bank_account_branch_code" class="form-control" placeholder="Enter Bank Account Branch code"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_branch_code');?>&nbsp; 
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                    <label class="col-md-3 control-label">Branch Address</label>
                                                    <div class="col-md-9">    
                                                         <?php echo form_input('bank_account_branch_address', set_value('bank_account_branch_address',$result['bank_account_branch_address']), 'id="bank_account_branch_address" class="form-control" placeholder="Enter Bank Account Branch address"'.$dis.' '.$o_dis.' '); ?>
                                                         <?php echo form_error('bank_account_branch_address');?>&nbsp; 
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
                                    <?php echo form_submit('submit',$action ,'class="btn btn-primary"'); ?>&nbsp;

                                    <?php echo anchor(site_url($this->router->fetch_class()),'Back','class="btn btn-info"');?>&nbsp;
                                    <?php echo form_reset('reset','Reset','class = "btn btn-default"'); ?>

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
 
<script>
    
$(document).ready(function(){  
    
        $("form").submit(function(){ 
            if(!confirm("Click Ok to Confirm form Submition.")){
                   return false;
            }
        });
    });
    </script>