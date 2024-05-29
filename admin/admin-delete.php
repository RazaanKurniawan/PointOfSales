
<?php
if (($_SESSION['loggedInUser']['level'] != 'Admin')) {

    echo '<script>window.location.href = "index.php";</script>';

}

require '../config/function.php';

$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $adminId = validate($paraResult);

    $admin = getById('admin', $adminId);
    if($admin['status'] == 200){

        $adminDeleteRes = delete('admin', $adminId);
        if($adminDeleteRes){
            redirect('admin.php', 'Admin berhasil dihapus!');
        }else{
            redirect('admin.php', 'Ada sesuatu yang salah!');
        }
        
    }else{
        redirect('admin.php', $admin['message']);
    }
    // echo $adminId;

}else{
    redirect('admin.php', 'Ada sesuatu yang salah!');
    
}

?>