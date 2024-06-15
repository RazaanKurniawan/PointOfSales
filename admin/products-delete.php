<?php

require '../config/function.php';

if ($_SESSION['loggedInUser']['level'] != 'Admin' && $_SESSION['loggedInUser']['level'] != 'Manajer') {
    echo '<script>window.location.href = "index.php";</script>';
    exit();
}

$paraResult = checkParamId('id');
if(is_numeric($paraResult)){

    $productId = validate($paraResult);

    $product = getById('products', $productId);
    if($product['status'] == 200){

        $response = delete('products', $productId);
        if($response){
            $deleteImage = "../".$product['data']['image'];
            $defaultImage = null; // Path gambar default

            // Cek apakah gambar yang akan dihapus bukan gambar default
            if(file_exists($deleteImage) && $deleteImage !== $defaultImage){
                unlink($deleteImage);
            }
            redirect('products.php', 'Produk berhasil dihapus!');
        }else{
            redirect('products.php', 'Ada sesuatu yang salah!');
        }
        
    }else{
        redirect('products.php', $product['message']);
    }
    // echo $adminId;

}else{
    redirect('products.php', 'Ada sesuatu yang salah!');
    
}

?>
