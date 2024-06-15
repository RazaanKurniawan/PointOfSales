<?php include ('includes/header.php') ?>
<style>
    .product-details {
        display: none;
        margin-top: 20px;
    }

    .product-details .card {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        max-width: 400px; /* Set a max-width for the card */
        margin: auto; /* Center the card horizontally */
    }

    .product-details .card-title {
        font-size: 24px;
        font-weight: bold;
        text-align: center; /* Center the text */
    }

    .product-details .card-text {
        font-size: 20px;
        text-align: center; /* Center the text */
    }

    .product-details .card-img-top {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
        width: 200px;
        height: 200px;
        object-fit: contain;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
</head>
<body>
    <div class="container">
        <h1 class="mt-4 text-center">Scan Produk</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="scanForm">
                    <div class="form-group">
                        <label for="productCode">Kode Produk</label>
                        <input type="text" class="form-control" id="productCode" placeholder="Scan atau masukkan kode produk" autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                </form>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="product-details" id="productDetails">
                    <div class="card">
                        <img src="" id="productImage" class="card-img-top" alt="Product Image" style="width: 200px; height: 200px; object-fit: contain;">
                        <h2 class="card-title" id="productName"></h2>
                        <p class="card-text" id="productPrice"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('includes/footer.php') ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function(){
            $('#scanForm').on('submit', function(event){
                event.preventDefault();
                var productCode = $('#productCode').val();
                $.ajax({
                    url: 'fetch_product.php',
                    method: 'POST',
                    data: {productCode: productCode},
                    dataType: 'json',
                    success: function(response){
                        if(response.success){
                            $('#productName').text(response.data.name);
                            $('#productPrice').text('Rp. ' + response.data.price.toLocaleString('id-ID'));
                            $('#productImage').attr('src', '../'+response.data.image);
                            $('#productDetails').fadeIn();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Produk tidak ditemukan',
                                text: 'Produk dengan kode tersebut tidak ditemukan dalam database.',
                                showConfirmButton: true,
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>

