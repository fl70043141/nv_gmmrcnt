<style>
.btn-huge{
    height: 60px;
    padding-top:18px; 
}     
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
} 
.btn-circle.btn-xl {
  width: 60px;
  height: 60px;
  padding: 15px 16px;
  font-size: 24px;
  line-height: 1.33;
  border-radius: 35px;
}

</style>
 <!-- Modal Checkout-->
   <?php echo form_open("", 'id="form_add_cost" class="form-horizontal"')?>  
   
<div class="modal fade" id="add_cost_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Cost<span class="name_title"></span>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h5>

      </div> 
      <div class="modal-body form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <div class="col-sm-6">
                      <?php  echo form_dropdown('os_cost_type_id',$osr_cost_list,set_value('os_cost_type_id'),' class="form-control input-lg checkout_input" data-live-search="true" id="os_cost_type_id"');?>
                                        
                </div>
                <div class="col-sm-6">
                    <input type="text" name="os_cost_amount" class="form-control input-lg checkout_input" id="os_cost_amount" placeholder="Enter Cost Amount">
                </div>
              </div>    
              <div  hidden class="form-group">
                <label for="or_item_id" class="col-sm-3 control-label">Name<span style="color: red">*</span></label>
                <div class="col-sm-9">
                    <input type="or_item_id" name="or_item_id" class="form-control input-lg checkout_input" id="or_item_id" placeholder="Supplier Name">
                </div>
              </div>    
                <div id="res_op_mod2"></div>
                
            </div> 
      </div>
      <div class="modal-footer"> 
          <div class="row">
              <div class="col-md-6"><a id="back_add_cost"  class="col-md-6 btn btn-block btn-primary btn-lg">Back </a></div>
              <div class="col-md-6"><a id="confirm_add_cost"  class="col-md-6 btn btn-block btn-primary btn-lg">Add New</a></div>
          </div>
      </div> 
    </div>
  </div>
</div>  
<?php echo form_close();?>
<script>
    $(document).ready(function(){  
        
        $("#confirm_add_cost").one('click', function (event) {   //disable Double Click
           event.preventDefault();
           //do something
           $(this).prop('disabled', true);
        });
        
        $('#add_cost_modal').on('shown.bs.modal', function () {
            $('#dropdown_value').focus();
        })  
 
        
        $('#back_add_cost').click(function(){
            $('#add_cost_modal').modal('toggle'); 
        }); 
        $('#confirm_add_cost').click(function(){  
            
            if($('#dropdown_value').val()==''){
                fl_alert('info',"Input Name Invalid!");
                $('#dropdown_value').focus().select();
                return false;
            }
            
            var td_id = $('#'+$('#or_item_id').val()).closest('td').attr('id');
            var row_id = td_id.split('_')[1]; 
            
            var type_name = $('#os_cost_type_id option:selected').text();
            var cost_amnt = parseFloat($('#os_cost_amount').val());
//            alert(type_name); 
            var td_prp_td = '<div class="cost_entries">'+type_name+': '+cost_amnt.toFixed(2)+' <input hidden class="'+row_id+'_cost_inputs"  style="width:80px;" id="'+row_id+'-'+$('#os_cost_type_id').val()+'__cost" value="'+cost_amnt+'"> <span class="rm_cost fa fa-trash"></span><div>';
//             
//                                        var ids = td_id.split('-');
            $('#'+td_id).prepend(td_prp_td);
            $('.rm_cost').click(function() {
                    $(this).closest('div').remove();
            });
            $('#add_cost_modal').modal('toggle'); 
        });
        
            
    });
     
</script>