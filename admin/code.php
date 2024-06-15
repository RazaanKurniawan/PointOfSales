<?php
include ('../config/function.php');

if (isset($_POST['saveAdmin'])) {
    $nama = validate($_POST['nama']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $no_telp = validate($_POST['no_telp']);
    $level = validate($_POST['level']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($nama != '' && $email != '' && $password != '') {

        $emailCheck = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('admin-create.php', 'Email Sudah DiPakai!');
            }
        }

        $bcrypt_password = password_hash($password, PASSWORD_BCRYPT);


        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $bcrypt_password,
            'no_telp' => $no_telp,
            'level' => $level,
            'is_ban' => $is_ban
        ];


        $result = insert('admin', $data);
        if ($result) {
            redirect('admin.php', 'Akun Berhasil Dibuat!');
        } else {
            redirect('admin-create.php', 'Akun Gagal Dibuat!');
        }
    } else {
        redirect('admin-create.php', 'Tolong Isi Yang Kosong!');
    }
}

if (isset($_POST['updateAdmin'])) {

    $adminId = validate($_POST['adminId']);

    $adminData = getById('admin', $adminId);
    if ($adminData['status'] != 200) {
        redirect('admin-edit.php?id=' . $adminId, 'Tolong isi kolom yang kosong!');
    }

    $nama = validate($_POST['nama']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $no_telp = validate($_POST['no_telp']);
    $no_telp = validate($_POST['no_telp']);
    $is_ban = isset($_POST['is_ban']) == true ? 1 : 0;

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($nama != '' && $email != '') {

        $data = [
            'nama' => $nama,
            'email' => $email,
            'password' => $hashedPassword,
            'no_telp' => $no_telp,
            'is_ban' => $is_ban
        ];


        $result = update('admin', $adminId, $data);
        if ($result) {
            redirect('admin.php', 'Akun Berhasil Diupdate!');
        } else {
            redirect('admin-edit.php?id=' . $adminId, 'Akun Gagal Diupdate!');
        }

    } else {
        redirect('admin-edit.php?id=' . $adminId, 'Tolong Isi Yang Kosong!');
    }

}

if (isset($_POST['saveCategory'])) {
    $name = $_POST['name'];
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = insert('categories', $data);

    if ($result) {
        redirect('categories.php', 'Category Created Successfully!');
    } else {
        redirect('categories-create.php', 'Something Went Wrong!');
    }
}

if (isset($_POST['saveProduct'])) {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $product_code = $_POST['product_code'];
    $description = validate($_POST['description']);

    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $status = isset($_POST['status']) ? 1 : 0;

    $defaultImage = null; // Path gambar default

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);
        $finalImage = "assets/uploads/products/" . $filename;
    } else {
        $finalImage = $defaultImage; // Gunakan gambar default jika tidak ada gambar yang diunggah
    }

    $data = [   
        'category_id' => $category_id,
        'name' => $name,
        'product_code' => $product_code,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    $result = insert('products', $data);

    if ($result) {
        redirect('products.php', 'Product Created Successfully!');
    } else {
        redirect('products-create.php', 'Ada sesuatu yang salah!');
    }
}

if (isset($_POST['updateCategory'])) {

    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) && $_POST['status'] == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('categories.php', 'Category Updated Successfully!');
    } else {
        redirect('categories-edit.php?id=' . $categoryId, 'Something Went Wrong!');
    }
}

if (isset($_POST['updateProduct'])) {
    $product_id = $_POST['product_id'];
    $productData = getById('products', $product_id);
    if (!$productData) {
        redirect('products.php', 'Produk tidak ditemukan!');
    }

    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $product_code = $_POST['product_code'];
    $description = validate($_POST['description']);

    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $status = isset($_POST['status']) == true ? 1 : 0;

    if ($_FILES['image']['size'] > 0) {
        $path = "../assets/uploads/products";
        $image_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $image_ext;

        move_uploaded_file($_FILES['image']['tmp_name'], $path . "/" . $filename);

        $finalImage = "assets/uploads/products/" . $filename;

        $deleteImage = "../" . $productData['data']['image'];
        if (file_exists($deleteImage)) {
            unlink($deleteImage);
        }

    } else {
        $finalImage = $productData['data']['image'];
    }

    $data = [
        'category_id' => $category_id,
        'name' => $name,
        'product_code' => $product_code,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'image' => $finalImage,
        'status' => $status
    ];

    $result = update('products', $product_id, $data);

    if ($result) {
        redirect('products.php', 'Produk telah diupdate!');
    } else {
        redirect('products-edit.php?id=' . $product_id, 'Ada sesuatu yang salah!');
    }
}
if (isset($_POST['updateCategory'])) {

    $categoryId = validate($_POST['categoryId']);

    $name = validate($_POST['name']);
    $description = validate($_POST['description']);
    $status = isset($_POST['status']) && $_POST['status'] == true ? 1 : 0;

    $data = [
        'name' => $name,
        'description' => $description,
        'status' => $status
    ];

    $result = update('categories', $categoryId, $data);

    if ($result) {
        redirect('categories.php', 'Category Updated Successfully!');
    } else {
        redirect('categories-edit.php?id=' . $categoryId, 'Something Went Wrong!');
    }
}

if (isset($_POST['saveCustomer'])) {

    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) ? 1 : 0;

    if ($name != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('customers-create.php', 'Email sudah dipakai oleh pengguna lain!');
            }
        }

        $data = [
            'name' => $name,	
            'class' => $class,	
            'email' => $email,	
            'phone' => $phone,	
            'status' => $status
        ];

        $result = insert('customers', $data);
        if ($result) {
            redirect('customers.php', 'Pelanggan berhasil dibuat!');
        }else{
            redirect('customers-create.php', 'Ada sesuatu yang salah!');
        }

    } else {
        redirect('customers.php', 'Tolong isi kolom yang kosong!');
    }
}

if(isset($_POST['updateCustomer'])){
    $customerId = validate($_POST['customerId']);

    $name = validate($_POST['name']);
    $class = validate($_POST['class']);
    $email = validate($_POST['email']);
    $phone = validate($_POST['phone']);
    $status = validate($_POST['status']) ? 1 : 0;

    if ($name != '') {
        $emailCheck = mysqli_query($conn, "SELECT * FROM customers WHERE email='$email' AND id!='$customerId'");
        if ($emailCheck) {
            if (mysqli_num_rows($emailCheck) > 0) {
                redirect('customers-edit.php?id='.$customerId, 'Email sudah dipakai oleh pengguna lain!');
            }
        }

        $data = [
            'name' => $name,	
            'class' => $class,	
            'email' => $email,	
            'phone' => $phone,	
            'status' => $status
        ];

        $result = update('customers', $customerId, $data);
        if ($result) {
            redirect('customers.php', 'Pelanggan berhasil diupdate!');
        }else{
            redirect('customers-edit.php?id='.$customerId, 'Ada sesuatu yang salah!');
        }

    } else {
        redirect('customers-edit.php?id='.$customerId, 'Tolong isi kolom yang kosong!');
    }
}

