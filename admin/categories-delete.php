<?php

require '../config/function.php';

$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $categoryId = validate($paraResult);

    $category = getById('categories', $categoryId);
    if($category['status'] == 200){

        $response = delete('categories', $categoryId);
        if($response){
            redirect('categories.php', 'Admin berhasil dihapus!');
        }else{
            redirect('categories.php', 'Ada sesuatu yang salah!');
        }
        
    }else{
        redirect('categories.php', $category['message']);
    }
    // echo $adminId;

}else{
    redirect('categories.php', 'Ada sesuatu yang salah!');
    
}

?>