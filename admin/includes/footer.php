</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; | Point Of Sales 2024</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="assets/js/scripts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.14.0/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="assets/js/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function () {
        $('.mySelect2').select2();
    });

    document.getElementById('payment_mode').addEventListener('change', function() {
        var paymentMode = this.value;
        var bayarInput = document.getElementById('money');
        if (paymentMode === 'Bayar Online') {
            bayarInput.value = ''; // Clear the input value if Bayar Online is selected
            bayarInput.disabled = true; // Disable the input field
        } else {
            bayarInput.disabled = false; // Enable the input field for other payment modes
        }
    });
 
    document.addEventListener('DOMContentLoaded', function () {
        const barcodeInput = document.getElementById('barcode-input');

        // Focus on the barcode input field on page load
        barcodeInput.focus();

        barcodeInput.addEventListener(function () {
            // Submit the form when input is detected
            document.getElementById('barcode-form').submit();
        });

        // Event listener for form submission to refocus the barcode input
        document.getElementById('barcode-form').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            // Submit the form via AJAX
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'orders-code.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Handle the response if necessary
                    console.log('Form submitted successfully');

                    // Clear the input
                    barcodeInput.value = '';

                    // Refocus the input field
                    barcodeInput.focus();
                }
            };
            xhr.send(new URLSearchParams(new FormData(this)).toString());
        });
    });

    
</script>

<script src="assets/js/custom.js"></script>

</body>
</html>
