<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>VNPAY RESPONSE</title>
    <!-- Bootstrap core CSS -->
    <!-- Custom styles for this template -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="{{ asset('assets/css/jumbotron-narrow.css') }}" rel="stylesheet">
</head>

<body>
   
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>

                <label>
                    <?php echo $_GET['vnp_TxnRef'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label>
                    <?php echo $_GET['vnp_Amount'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label>
                    <?php echo $_GET['vnp_OrderInfo'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label>
                    <?php echo $_GET['vnp_ResponseCode'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label>
                    <?php echo $_GET['vnp_TransactionNo'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label>
                    <?php echo $_GET['vnp_BankCode'] ?? 1 ?>
                </label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label>
                    <?php echo $_GET['vnp_PayDate'] ?? 1?>
                </label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                  

                </label>
            </div>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY
                <?php echo date('D-M-Y') ?>
            </p>
        </footer>
    </div>
</body>

</html>