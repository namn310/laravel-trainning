<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Petcare</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
        <div class="card text-center shadow p-4" style="max-width: 500px">
            <div class="card-body">
                <div class="text-success mb-3">
                    <img src="{{ asset('assets/img/vnpay-logo-vinadesign-25-12-57-55.jpg') }}"
                        style="width:100px;height:100px" class="img-fluid">
                </div>
                <h2 class="card-title text-danger">Thanh toán thất bại !</h2>
                <p class="text-muted"><i class="fa-solid fa-triangle-exclamation fa-xl" style="color: #a00d0d;"></i></p>
                <p class="fw-bold text-dark">Có lỗi xảy ra trong quá trình thanh toán. Vui lòng thử lại sau !</p>
                <div class="d-flex justify-content-center gap-2 mt-3">
                </div>
                <button class="btn btn-primary"><a style="text-decoration: none;color:white" href="/">Trở
                        về</a></button>
            </div>
        </div>
    </div>
</body>

</html>