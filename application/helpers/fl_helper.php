<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_dropdown_data'))
{
      // generate serial
	function get_dropdown_data($table='', $name='', $id='',$first_null_option="", $where='',$where_del = 0,$limit='',$order_by=''){
		$CI =& get_instance();
                
                $name_select = (is_array($name))?$name[1]:$name;
		$CI->db->select("".$name_select.",".$id."");	
		$CI->db->from($table);	 
                if($where_del == 0){
                    $CI->db->where('deleted',0);
                    $CI->db->where('status',1);
                }
                
                
                if($where != ''){
                    if(is_array($where) && isset($where['col']) && isset($where['val'])){
                        $CI->db->where($where['col'],$where['val']);
                    }else{
                        $CI->db->where($where);
                    }
                } 
                if($limit!='') $CI->db->limit($limit);
                if($order_by!='') $CI->db->order_by($order_by);
                
		$res = $CI->db->get()->result_array();
//                echo $CI->db->last_query(); die;
                $dropdown_data=array();
                
                if($first_null_option != ""){
                    $dropdown_data['']='Select '.$first_null_option;
                }
                foreach ($res as $res1){
                    $name_key = (is_array($name))?$name[0]:$name;
                    $dropdown_data[$res1[$id]] = $res1[$name_key];
                }
		return $dropdown_data;
	}
}

function get_dropdown_value($dp_id){
    $CI =& get_instance();
    $CI->db->select("dropdown_value");	
    $CI->db->from(DROPDOWN_LIST);	
    $CI->db->where('id',$dp_id);
    $res = $CI->db->get()->result_array();
    if(isset($res[0]['dropdown_value'])){
        return $res[0]['dropdown_value'];
    }
    return 0;
    
}

function get_value_for_id($table, $id,$name='*'){
    $CI =& get_instance();
    $CI->db->select($name);	
    $CI->db->from($table);	
    $CI->db->where('id',$id);
    $res = $CI->db->get()->result_array();
    if(isset($res[0][$name])){
        return $res[0][$name];
    }
    return 0;
    
}

function deletion_check($table, $check_col,$val='',$where_str=''){
    $CI =& get_instance();
    $CI->db->select($check_col);	
    $CI->db->from($table);	
    $CI->db->where('deleted',0);
    if($where_str!=''){
        $CI->db->where($where_str);
    }else{
        $CI->db->where($check_col,$val);
    }
    $res = $CI->db->get()->result_array();
//    echo $CI->db->last_query();die;
    if(isset($res[0][$check_col])){
        return $res[0][$check_col];
    }
    return 0;
    
}

if ( ! function_exists('get_autoincrement_no'))
{
      // generate serial
	function get_autoincrement_no($table=''){
		$CI =& get_instance();
                $query = $CI->db->query("SHOW TABLE STATUS LIKE '$table'");
                $row = $query->result();
                return $row[0]->Auto_increment;
		
	}
}


// generate serial
    function generate_serial($table='', $column=''){
            $CI =& get_instance();
            $CI->db->select('IFNULL(MAX('.$column.'),0) AS max_no',FALSE);	
            $res_serial = $CI->db->get($table)->row();	
            $serial = $res_serial->max_no;
            $serial = ($serial == 0) ? 1 : $serial+1;
            return $serial;
    }
    
// single row
    function get_single_row_helper($table='', $where='', $order_by=''){
            $CI =& get_instance();
            $CI->db->select("*");	
            $CI->db->from($table);
            if($where!='')$CI->db->where($where);
            if($order_by!='')$CI->db->order_by('id','desc');
                    
            $res = $CI->db->get()->result_array();	
            
            if(!empty($res)) return $res[0];
            
            return $res;
    }
    
if ( ! function_exists('gen_id'))
{
// generate id
    function gen_id($prefix='', $table='', $column='', $pad_amount=7, $pad_sym='0')
    {
        return $id = $prefix.str_pad(get_autoincrement_no($table), $pad_amount, $pad_sym, STR_PAD_LEFT);
    }
}
if ( ! function_exists('gen_id_for_no'))
{
// generate id
    function gen_id_for_no($prefix='', $no='', $column='', $pad_amount=7, $pad_sym='0')
    {
        return $id = $prefix.str_pad($no, $pad_amount, $pad_sym, STR_PAD_LEFT);
    }
}


// Encrypt Function
 function mc_encrypt($string,$secret_key) {//support php 7
    $output = false;
    $encrypt_method = "AES-256-CBC"; 
    $secret_iv = 'zone_venture_fl';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    $output = base64_encode($output);
    
    return $output;
}

//function mc_encrypt($encrypt, $key){ //support php 5.5
//    $encrypt = serialize($encrypt);
//    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
//    $key = pack('H*', $key);
//    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
//    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
//    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
//    return $encoded;
//}
// Decrypt Function
 
 function mc_decrypt($string,$secret_key) { //support php 7
    $output = false;
    $encrypt_method = "AES-256-CBC"; 
    $secret_iv = 'zone_venture_fl';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
    $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv); 
    
    return $output; 
}
//function mc_decrypt($decrypt, $key){ //support php 5.5
//    $decrypt = explode('|', $decrypt.'|');
//    $decoded = base64_decode($decrypt[0]);
//    $iv = base64_decode($decrypt[1]);
//    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
//    $key = pack('H*', $key);
//    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
//    $mac = substr($decrypted, -64);
//    $decrypted = substr($decrypted, 0, -64);
//    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
//    if($calcmac!==$mac){ return false; }
//    $decrypted = unserialize($decrypted);
//    return $decrypted;
//}

//Systeg Log adding

        function add_system_log($table,$module,$action,$old_data='',$new_data=''){
//            echo '<pre>';            print_r($log_arr); die;
            if(SYSTEM_LOG_ENABLE==0){
                return FALSE;
            }
            $CI =& get_instance();
            $log_id = generate_serial(SYSTEM_LOG, 'id');
            $log_arr = array(
                                'id' => $log_id,
                                'user_id' => $_SESSION[SYSTEM_CODE]['ID'],
                                'module_id' => $module,
                                'action_id' => $action,
                                'ip' => $_SERVER['REMOTE_ADDR'],
                                'date' => time(),
                            );
            
//            echo '<pre>';            print_r($log_arr); die;
            $log_det_arr = array(
                                    'system_log_id' => $log_id,
                                    'table_name' => $table,
                                    'data_new' => serialize($new_data),
                                    'data_old' => serialize($old_data),
                                );
            
            $CI->db->trans_start();
                
            $CI->db->insert(SYSTEM_LOG, $log_arr);
            $CI->db->insert(SYSTEM_LOG_DETAIL, $log_det_arr);

            $status=$CI->db->trans_complete();
            return $status; 
        }

        function get_default_currency_amount($amount,$currency_code, $to_curcode=''){
            if($to_curcode==''){
                $to_curcode = $_SESSION[SYSTEM_CODE]['default_currency'];
            }
            
            $CI =& get_instance(); 
            $res_from = $CI->db->get_where(CURRENCY,array('code'=>$currency_code))->result()[0];
            $res_to = $CI->db->get_where(CURRENCY,array('code'=>$to_curcode))->result()[0];
            
            $res_to->amount = ($res_to->value/$res_from->value)*$amount; 
            
            return $res_to;
        }
        function get_currency_for_code($code='LKR',$where=''){ 
            $CI =& get_instance(); 
            $CI->db->select('*');
            $CI->db->from(CURRENCY);
            if($code!='')$CI->db->where('code',$code);
            if($where!='')$CI->db->where($where);
            $result = $CI->db->get()->result_array();  
//            echo  $this->db->last_query(); die;
//        echo '<pre>';        print_r($result);die;
            if(!empty($result))
                return $result[0];
            return $result;
	}
        
        /*
 * Matches each symbol of PHP date format standard
 * with jQuery equivalent codeword
 * @author Tristan Jahier
 */
function dateformat_PHP_to_jQueryUI($php_format)
{
    $SYMBOLS_MATCHING = array(
        // Day
        'd' => 'dd',
        'D' => 'D',
        'j' => 'd',
        'l' => 'DD',
        'N' => '',
        'S' => '',
        'w' => '',
        'z' => 'o',
        // Week
        'W' => '',
        // Month
        'F' => 'MM',
        'm' => 'mm',
        'M' => 'M',
        'n' => 'm',
        't' => '',
        // Year
        'L' => '',
        'o' => '',
        'Y' => 'yy',
        'y' => 'y',
        // Time
        'a' => '',
        'A' => '',
        'B' => '',
        'g' => '',
        'G' => '',
        'h' => '',
        'H' => '',
        'i' => '',
        's' => '',
        'u' => ''
    );
    $jqueryui_format = "";
    $escaping = false;
    for($i = 0; $i < strlen($php_format); $i++)
    {
        $char = $php_format[$i];
        if($char === '\\') // PHP date format escaping character
        {
            $i++;
            if($escaping) $jqueryui_format .= $php_format[$i];
            else $jqueryui_format .= '\'' . $php_format[$i];
            $escaping = true;
        }
        else
        {
            if($escaping) { $jqueryui_format .= "'"; $escaping = false; }
            if(isset($SYMBOLS_MATCHING[$char]))
                $jqueryui_format .= $SYMBOLS_MATCHING[$char];
            else
                $jqueryui_format .= $char;
        }
    }
    return $jqueryui_format;
}


function is_connected_internet($url='www.google.com'){
    $connected = @fsockopen($url, 80); 
                                        //website, port  (try 80 or 443)
    if ($connected){
        $is_conn = true; //action when connected
        fclose($connected);
    }else{
        $is_conn = false; //action in connection failure
    }
    return $is_conn;

}

function send_backup_helper(){
    
                $CI =& get_instance(); 
                
		$CI->load->database(); 
		$CI->load->dbutil(); 
		if(!$CI->dbutil->database_exists($CI->db->database)){
			 echo "Database does not exist..";
		}
		else{
                        $file_name='db_backup_'.$CI->db->database.'-'.date("YmdHis", time());

                        $prefs = array( 
                                        'ignore'      => array(),
                                        'format'      => 'zip',   
                                        'filename'    => 'db_backup.zip',  
                                        'add_drop'    => TRUE,            
                                        'add_insert'  => TRUE,        
                                        'newline'     => "\n"      
                                      );
 
                        $backup = $CI->dbutil->backup($prefs);
                        // Load the file helper and write the file to your server
                        $CI->load->helper('file');
                        if(write_file(DB_BACKUPS.$file_name.'.zip', $backup)){
                            add_system_log('', $CI->router->fetch_class(), __FUNCTION__, '');
                        }
                        
                       $attathments[0] =  './'.DB_BACKUPS.'/'.$file_name.'.zip';
                       
                        $CI->load->library('session');
                        
                        $company_info = get_single_row_helper(COMPANIES,'id = '.$CI->session->userdata(SYSTEM_CODE)['ID']);
//                        echo '<pre>';                        print_r($company_info); die;
                        
                        
                        $to         = 'fahrylafir@gmail.com'; // backups to 
                        $from 		= 'noreply@nveloop.com';
                        $from_name 	= SYSTEM_CODE.' | USER: '.$CI->session->userdata(SYSTEM_CODE)['user_name'];
                        $subject 	= 'NVELOOP MySQL Database Backup  Backup('.date('Y-m-d_H-i-s').')'; 

                        $message    = '<table width="100%" border="0">
                                                        <br>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Please find attached Database backup file and Folder backup file generated  at '.date('Y-m-d H:i').'</td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Destroyed Company Name :</td>
                                                            <td>'.$company_info['company_name'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contact :</td>
                                                            <td>'.$company_info['street_address'].', '.$company_info['city'].', '.$company_info['phone'].', '.$company_info['email'].' </td>
                                                        </tr>

                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Best Regards</td>
                                                        </tr>

                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold">Nveloop Admin</td>
                                                        </tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8; font-weight:bold"></td>
                                                        </tr>
                                                        <tr>
                                                        <td width="7%">&nbsp;</td>
                                                        <td colspan="2" style="font:Verdana; color:#A8A8A8;">Please note that this is an automatd email from the PAS.</td>
                                                        </tr>
                                </table>';
                                // echo $message; die;
                        
                        $CI->load->model('Sendmail_model'); 
                        if($CI->Sendmail_model->send_mail($to,$from,$from_name,$subject,$message,$attathments)){
        //			echo 'Database and Folder Backups Email Sent Successflly <br>';
                                return true;;
                        }else{
        //			echo "error sending backup email..<br>";
                                return false;
                        }
                }
}

function fl_image_resizer($file_name,$target_width,$target_height='',$resized_name='', $source_dir='',$destn_dir=''){
    $file = $source_dir.$file_name;
    $source_properties = getimagesize($file);
    
    $target_height = ($target_height=='')?(($source_properties[1]/$source_properties[0])*$target_width):$target_height;
    $destn_dir = ($destn_dir=='')?$source_dir:$destn_dir;
    $resized_name = ($resized_name=='')?$target_width.'X'.$target_height.'_'.$file_name:$resized_name;
    
    $image_type = $source_properties[2]; 
    $resized = false;
    
    switch($image_type){
        case IMAGETYPE_JPEG:  
            $image_resource_id = imagecreatefromjpeg($file);  
    //                            $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
            $target_layer = imagecreatetruecolor($target_width,$target_height);
            imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $source_properties[0],$source_properties[1]);
            $resized = imagejpeg($target_layer, $destn_dir.$resized_name);
            break;
        case IMAGETYPE_GIF:  
            $image_resource_id = imagecreatefromgif($file);  
    //                            $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
            $target_layer = imagecreatetruecolor($target_width,$target_height);
            imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $source_properties[0],$source_properties[1]);
            $resized = imagegif($target_layer, $destn_dir.$resized_name);
            break;
        case IMAGETYPE_PNG:  
            $image_resource_id = imagecreatefrompng($file);  
    //                            $target_layer = fn_resize($image_resource_id,$source_properties[0],$source_properties[1]);
            $target_layer = imagecreatetruecolor($target_width,$target_height);
            imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $source_properties[0],$source_properties[1]);
            $resized = imagepng($target_layer, $destn_dir.$resized_name);
            break;
    }
//    echo $file; 
    return $resized;
                        
}

//EG: 0.5 ==> 1/2
function float2rat($n, $tolerance = 1.e-6) {
    $h1=1; $h2=0;
    $k1=0; $k2=1;
    $b = 1/$n;
    do {
        $b = 1/$b;
        $a = floor($b);
        $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
        $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
        $b = $b-$a;
    } while (abs($n-$h1/$k1) > $n*$tolerance);

    return "$h1/$k1";
}

function calculate_string( $mathString ){ //EG: 1/2 ===>> 0.5 
        $mathString = trim($mathString);
        $mathString = str_replace ('[^0-9\+-\*\/\(\) ]', '', $mathString); 

        $compute = create_function("", "return (" . $mathString . ");" );
        return 0 + $compute();
    }

    
function numberTowords($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return strtoupper(implode(' ', $words));
}

// function numberTowords($num)
// {

//     $ones = array(
//         0 => "ZERO",
//         1 => "ONE",
//         2 => "TWO",
//         3 => "THREE",
//         4 => "FOUR",
//         5 => "FIVE",
//         6 => "SIX",
//         7 => "SEVEN",
//         8 => "EIGHT",
//         9 => "NINE",
//         10 => "TEN",
//         11 => "ELEVEN",
//         12 => "TWELVE",
//         13 => "THIRTEEN",
//         14 => "FOURTEEN",
//         15 => "FIFTEEN",
//         16 => "SIXTEEN",
//         17 => "SEVENTEEN",
//         18 => "EIGHTEEN",
//         19 => "NINETEEN",
//         "014" => "FOURTEEN"
//     );
//     $tens = array(
//         0 => "ZERO",
//         1 => "TEN",
//         2 => "TWENTY",
//         3 => "THIRTY",
//         4 => "FORTY",
//         5 => "FIFTY",
//         6 => "SIXTY",
//         7 => "SEVENTY",
//         8 => "EIGHTY",
//         9 => "NINETY"
//     );
//     $hundreds = array(
//         "HUNDRED",
//         "THOUSAND",
//         "MILLION",
//         "BILLION",
//         "TRILLION",
//         "QUARDRILLION"
//     ); /*limit t quadrillion */
//     $num = number_format($num, 2, ".", ",");
//     $num_arr = explode(".", $num);
//     $wholenum = $num_arr[0];
//     $decnum = $num_arr[1];
//     $whole_arr = array_reverse(explode(",", $wholenum));
//     krsort($whole_arr, 1);
//     $rettxt = "";
//     foreach ($whole_arr as $key => $i) {

//         while (substr($i, 0, 1) == "0")
//             $i = substr($i, 1, 5);
//         if ($i < 20) {
//             /* echo "getting:".$i; */
//             $rettxt .= $ones[$i];
//         } elseif ($i < 100) {
//             if (substr($i, 0, 1) != "0")  $rettxt .= $tens[substr($i, 0, 1)];
//             if (substr($i, 1, 1) != "0") $rettxt .= " " . $ones[substr($i, 1, 1)];
//         } else {
//             if (substr($i, 0, 1) != "0") $rettxt .= $ones[substr($i, 0, 1)] . " " . $hundreds[0];
//             if (substr($i, 1, 1) != "0") $rettxt .= " " . $tens[substr($i, 1, 1)];
//             if (substr($i, 2, 1) != "0") $rettxt .= " " . $ones[substr($i, 2, 1)];
//         }
//         if ($key > 0) {
//             $rettxt .= " " . $hundreds[$key] . " ";
//         }
//     }
//     if ($decnum > 0) {
//         $rettxt .= " and ";
//         if ($decnum < 20) {
//             $rettxt .= $ones[$decnum];
//         } elseif ($decnum < 100) {
//             $rettxt .= $tens[substr($decnum, 0, 1)];
//             $rettxt .= " " . $ones[substr($decnum, 1, 1)];
//         }
//     }
//     return $rettxt;
// }