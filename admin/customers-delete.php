<?php

require '../config/function.php';

$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $customerId = validate($paraResult);

    $customer = getById('customers', $customerId);
    if($customer['status'] == 200){

        $response = delete('customers', $customerId);
        if($response){
            redirect('customers.php', 'Customer berhasil dihapus!');
        }else{
            redirect('customers.php', 'Ada sesuatu yang salah!');
        }
        
    }else{
        redirect('customers.php', $customer['message']);
    }
    // echo $adminId;

}else{
    redirect('customers.php', 'Ada sesuatu yang salah!');
    
}

?>