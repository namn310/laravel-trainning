@extends('User.LayoutTrangChu')
@section('content')
<!-- Danh mục sản phẩm-->
<div class="container-fluid pdt productDetail">
  <div class="row a ">
    <div>
      <div class="d-flex">
        <p id="idPro" hidden>{{ $product->idPro }}</p>
        <div class="img-slide mt-3" style="max-height:550px;max-width:200px;overflow:hidden">
          @foreach ($product->ImageProduct as $result)
          <div style="max-width:140px;border-top:1px solid black;border-bottom:1px solid black"><img
              class="img-fluid p-2 list-img" src="{{ asset('assets/img-add-pro/' . $result->image) }}">
          </div>
          @endforeach
        </div>

        <div class="product-detail d-flex justify-content-around">
          <div class="product-detail-img ms-2">
            {{-- Ảnh sản phẩm --}}
            <img class="img-float main-img-product" id="main-img-product"
              style="max-width:800px;max-height:600px;border:1px solid  #EA9E1E;border-radius:5px" src="/assets/img-add-pro/<?php
                                $listImage = $product->ImageProduct;
                                echo $listImage[0]->image;
                                ?>">

            <div class="img-slide-small ms-2" style="max-width:140px">
              @foreach ($product->ImageProduct as $result)
              <div style="max-width:140px"><img class="img-fluid p-2 list-img"
                  src="{{ asset('assets/img-add-pro/' . $result->image) }}"></div>
              @endforeach
            </div>
          </div>
          <div class="product-detail-intro ms-5 text-break">
            <p>
              {{-- Tên sản phẩm --}}
            <h4 style="font-size:3vw;font-size:3vh">
              {{ $product->namePro }}
            </h4>
            </p>
            {{-- Mã sản phẩm --}}
            <p style="font-size:2vw;font-size:2vh"><strong>Mã sản phẩm : </strong>
              {{ $product->idPro }}
            </p>
            <p id="CountProduct" style="font-size:2vw;font-size:2vh"><strong>Số lượng khả dụng : </strong>
              {{ $product->count }}
            </p>
            <p style="font-size:2vw;font-size:2vh"><strong>Lượt mua: </strong>324</p>
            <span class="rating secondary-font" style="font-size:3vw;font-size:3vh">
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              <i class="fa-solid fa-star text-warning"></i>
              5.0</span>
            @if (!$product->discount > 0)
            <p style="font-size:3vw;font-size:3vh"><span class="card-text text-danger">
                {{ number_format($product->cost) }}đ</span></p>
            @else
            <p style="font-size:3vw;font-size:3vh">
              <span>
                <b class="card-text text-black text-decoration-line-through"
                  style="border-right:solid black 1px;padding-right:5px">{{ number_format($product->cost) }}
                  đ</b>
                <b class="card-text text-danger">{{ number_format($product->cost - ($product->cost * $product->discount)
                  / 100) }}đ</b>
              </span>
            </p>
            @endif
            <div class="number-control">
              <div class="number-left me-2" id="buttonDown"></div>
              <input type="number" name="number" id="countToAdd" value="1" min="1" max="{{ $product->count }}"
                class="number-quantity">
              <div class="number-right ms-2" id="buttonUp"></div>
            </div>
            <!-- Button trigger modal -->
            {{-- @if (!Auth::guard('customer')->check()) --}}

            <button class="btn btn-danger mt-4" style="width:90px ;margin-left:10px;margin-bottom:20px"
              id="buttonAddToCart" data-id="{{ $product->idPro }}" data-name="{{ $product->namePro }}"
              data-cost="{{ $product->cost }}" data-discount="{{ $product->discount }}"
              data-image="{{ asset('assets/img-add-pro/' . $product->getImgProduct($product->idPro)) }}"
              style="text-decoration:none;color:white;font-size:2vw;font-size:2vh">
              Mua
            </button>
            <button type="button" style="width:150px;margin-left:10px;margin-bottom:20px;font-size:2vw;font-size:2vh"
              id="ButtonSoldOut" class="btn btn-danger mt-3 d-none">
              Hàng tạm hết</button>
          </div>
        </div>
      </div>

      <div class="mt-3">
        <ul class="nav nav-tabs" style="cursor:pointer">
          <li class="nav-item" style="font-weight:bold">
            <a class="nav-link" id="mota" style="text-decoration:none;color:black;font-size:2vw;font-size:2vh"
              aria-current="page">Mô
              tả
              sản
              phẩm</a>
          </li>
          <li class="nav-item" style="font-weight:bold">
            <a class="nav-link" id="comment" style="text-decoration:none;color:black;font-size:2vw;font-size:2vh">Bình
              luận</a>
          </li>
        </ul>
        <!-- Mô tả sản phẩm -->
        <div class="thongtinchitiet mt-3 ms-4" style="padding-bottom:50px;font-size:2vw;font-size:2vh">
          <?php echo $product->description; ?>

        </div>
        <!--  Bình luận sản phẩm -->

      </div>
      <hr>
      {{-- sản phẩm tương tự --}}
      <div class="align-items-center">
        <div class="text-center">
          <h3>Các sản phẩm tương tự</h3>
        </div>
        {{-- danh sách sản phẩm --}}
        <div class="product-list d-flex flex-wrap ms-5">
          <!-- Lấy dữ liệu từ bảng product để xuất ra sản phẩm -->
          @foreach ($productRelated as $product)
          {{-- Thông tin sản phẩm --}}
          <div id="product-infor" class="card position-relative" style="max-width:15rem;height:27rem"
            style="border:0px">
            {{-- giảm giá sản phẩm --}}
            @if ($product->discount > 0)
            <div class="onsale position-absolute top-0 start-0">
              <span class="badge rounded-0 bg-danger"><i class="fa-solid fa-arrow-down"></i>
                {{ $product->discount }}%
              </span>
            </div>
            @endif
            <div>
              <?php
                                    $nameProduct = Str::slug($product->namePro); ?>
              {{-- hình ảnh sản phẩm --}}
              <a id="img_pro"
                href="{{ route('user.productDetail', ['id' => $product->idPro, 'name' => $nameProduct]) }}">
                <img class="card-img-top img-fluid p-2" style="max-height:20rem"
                  src="{{ asset('assets/img-add-pro/' . $product->getImgProduct($product->idPro)) }}"
                  alt="Card image cap"></a>
            </div>
            <div class="card-body" id="card-body">
              <h6 id="name-product" class="card-title">
                {{ $product->namePro }}
              </h6>
              <span class="rating secondary-font">
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                <i class="fa-solid fa-star text-warning"></i>
                5.0</span>
              @if ($product->discount <= 0) <p class="card-text text-danger">
                {{ number_format($product->cost) }}đ
                </p>
                <p hidden id="productCostHidden">{{ $product->cost }}</p>
                @else
                <p class="card-text text-danger text-decoration-line-through">
                  {{ number_format($product->cost) }}đ
                </p>
                <p class="card-text text-danger" style="margin-top:-15px">
                  {{ number_format($product->cost - ($product->cost * $product->discount) / 100) }}đ
                </p>
                <p hidden id="productCostHidden">
                  {{ $product->cost - ($product->cost * $product->discount) / 100 }}
                </p>
                @endif
                {{-- <a href="{{ route('user.add', ['id' => $product->idPro]) }}"
                  style="text-decoration:none;color:white"><button type="submit" style="position:absolute;top:0;right:0"
                    class="btn btn-white shadow-sm rounded-pill"><i style="color:black"
                      class="fa-solid fa-cart-shopping text-danger"></i></button></a> --}}
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End mục sản phẩm-->
<!--footer end-->
<script src="{{ asset('assets/js/script.js') }}"></script>
@vite('resources/js/User/product/productDetail.js')
<style>
  @media screen and (max-width:1030px) {
    .a {
      margin-top: 50px;
    }
  }

  @media screen and (max-width:1200px) {
    .product-detail {
      flex-direction: column;
    }
  }

  @media screen and (max-width:800px) {
    .img-slide {
      display: none
    }

    .img-slide-small {
      display: block
    }
  }

  @media screen and (min-width:801px) {
    .img-slide-small {
      display: none;
    }
  }

  @media screen and (max-width:750px) {
    .a {
      margin-top: 100px;
    }
  }

  .product-detail-img {
    flex: 1;
  }

  .product-detail-intro {
    flex: 1;
  }

  /* From Uiverse.io by Cybercom682 */
  .number-control {
    display: flex;
    align-items: center;
  }

  .number-left::before,
  .number-right::after {
    content: attr(data-content);
    background-color: #333333;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid black;
    width: 20px;
    color: white;
    transition: background-color 0.3s;
    cursor: pointer;
  }

  .number-left::before {
    content: "-";
  }

  .number-right::after {
    content: "+";
  }

  .number-quantity {
    padding: 0.25rem;
    border: 1px solid black;
    width: 50px;
    -moz-appearance: textfield;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
  }

  .number-left:hover::before,
  .number-right:hover::after {
    background-color: #666666;
  }
</style>
@endsection