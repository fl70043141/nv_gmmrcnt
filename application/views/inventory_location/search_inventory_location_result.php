<table id="example1" class="table dataTable table-bordered table-striped">
         <thead>
            <tr>
                <th>#</th>
                <th>Location Name</th> 
                <th>Code</th> 
                <th>Address</th> 
                <th>Contact Person</th>
                <th>Contact  No</th>
               <th>Action</th>
            </tr>
        </thead>
        <tbody>
              <?php
                  $i = 0;
                   foreach ($search_list as $search){ 
//            echo '<pre>';            print_r($search); die; 
                       echo '
                           <tr>
                               <td>'.($i+1).'</td>
                               <td>'.$search['location_name'].'</td>  
                               <td>'.$search['location_code'].'</td>
                               <td>'.$search['address'].'</td>
                               <td>'.$search['contact_person'].'</td>
                               <td>'.$search['phone'].'</td>
                               <td>';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'view'))?'<a href="'. base_url($this->router->fetch_class().'/view/'.$search['id']).'" title="View" class="btn btn-primary btn-xs"><span class="fa fa-eye"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'edit'))?'<a href="'. base_url($this->router->fetch_class().'/edit/'.$search['id']).'" title="Edit" class="btn btn-success btn-xs"><span class="fa fa-edit"></span></a> ':'';
                                    echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'delete'))?'<a href="'. base_url($this->router->fetch_class().'/delete/'.$search['id']).'" title="Delete" class="btn btn-danger btn-xs"><span class="fa fa-remove"></span></a> ':'';
                                   
                                echo '</td>  ';
                       $i++;
                   }
              ?>   
        </tbody>
           <tfoot>
           <tr>
                <th>#</th>
                <th>Location Name</th> 
                <th>Code</th> 
                <th>Address</th> 
                <th>Contact Person</th>
                <th>Contact  No</th>
               <th>Action</th>
           </tr>
           </tfoot>
         </table>