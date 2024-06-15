<?php

require '../config/function.php';

if ($_SESSION['loggedInUser']['level'] != 'Admin' && $_SESSION['loggedInUser']['level'] != 'Manajer') {
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}

$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $categoryId = validate($paraResult);

    $category = getById('categories', $categoryId);
    if($category['status'] == 200){

        $response = delete('categories', $categoryId);
        if($response){
            redirect('categories.php', 'Kategori berhasil dihapus!');
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