<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Petcare</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/PetCARE.png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: white;
            padding: 40px 60px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #28a745;
            margin-top: 10px;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
        }

        strong {
            font-weight: bold;
        }

        .button {
            margin-top: 20px;
        }

        .button a {
            text-decoration: none;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
        }

        .button a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div><img class="img-fluid" style="width:100px;height:100px" src="{{ asset('assets/img/7518748.png') }}"></div>
        <h2>THANH TOÁN THÀNH CÔNG !</h2>
        <p class="text-muted">Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi.</p>
        <p class="fw-bold text-dark">Mã giao dịch: {{ 12 }}</p>
        <p class="fw-bold text-dark">Mã giao dịch ngân hàng: {{ 12}}</p>
        <p class="fs-5 text-primary fw-bold">Số tiền giao dịch: {{ 12 }}</p>
        <div class="button">
            <a href="/dashboard">Quay về dashboard</a>
        </div>
    </div>
</body>

</html>