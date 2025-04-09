@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
  <h1>Trang chủ</h1>
  <div class="main-content mt-4">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      <!-- End Navbar -->
      <div class="container-fluid py-4">
        {{-- Dữ liệu thống kê doanh thu theo tuần --}}
        <input value="{{ $Monday }}" id="Monday" hidden>
        <input value="{{ $Tuesday }}" id="Tuesday" hidden>
        <input value="{{ $Wednesday }}" id="Wednesday" hidden>
        <input value="{{ $Thursday }}" id="Thursday" hidden>
        <input value="{{ $Friday }}" id="Friday" hidden>
        <input value="{{ $Saturday }}" id="Saturday" hidden>
        <input value="{{ $Sunday }}" id="Sunday" hidden>
        {{-- dữ liệu thống kê theo tháng --}}
        <input value="{{ $jan }}" id="jan" hidden>
        <input value="{{ $feb }}" id="feb" hidden>
        <input value="{{ $mar }}" id="mar" hidden>
        <input value="{{ $apr }}" id="apr" hidden>
        <input value="{{ $may }}" id="may" hidden>
        <input value="{{ $june }}" id="june" hidden>
        <input value="{{ $july }}" id="july" hidden>
        <input value="{{ $aug }}" id="aug" hidden>
        <input value="{{ $sep }}" id="sep" hidden>
        <input value="{{ $oc }}" id="oc" hidden>
        <input value="{{ $no }}" id="no" hidden>
        <input value="{{ $de }}" id="de" hidden>
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-coins" style="color: #FFD43B;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Số đơn hàng hôm nay</p>
                  <h4 class="mb-0">{{ $orderTotal }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+55% </span>so với tuần trước</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-users" style="color: #74C0FC;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Sản phẩm hết hàng</p>
                  <h4 class="mb-0">{{ $productOutTotal }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+3% </span>than
                  lask month</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-user-check" style="color: #74C0FC;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Tổng khách hàng truy cập</p>
                  <h4 class="mb-0">{{ $CustomerTotal }}</h4>
                </div>
              </div>
              {{--
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-danger text-sm font-weight-bolder">-2%</span> so với hôm qua</p>
              </div> --}}
            </div>
          </div>
          <div class="col-xl-3 col-sm-6">
            <div class="card">
              <div class="card-header p-3 pt-2">
                <div
                  class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                  <i class="fa-solid fa-money-check" style="color: #e60f0f;"></i>
                </div>
                <div class="text-end pt-1">
                  <p class="text-sm mb-0 text-capitalize">Doanh thu</p>
                  <h4 class="mb-0">{{ number_format($Cost) }}đ</h4>
                </div>
              </div>
              <hr class="dark horizontal my-0">
              <div class="card-footer p-3">
                <p class="mb-0"><span class="text-success text-sm font-weight-bolder">+5% </span>so
                  với hôm qua</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2 ">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <div class="chart">
                    <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <h5 class="mt-2 ">Doanh số tuần (triệu đồng)</h5>
                {{-- <p class="text-sm ">Last Campaign Performance</p> --}}
                <hr class="dark horizontal">
                <div class="d-flex ">
                  {{-- <i class="material-icons text-sm my-auto me-1">schedule</i> --}}
                  {{-- <p class="mb-0 text-sm"> campaign sent 2 days ago </p> --}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 mt-4 mb-4">
            <div class="card z-index-2  ">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                  <div class="chart">
                    <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <h5 class="mt-2 "> Doanh số tháng (triệu đồng) </h5>
                <p class="text-sm "> (<span class="font-weight-bolder text-success">+15%</span>) tháng nay. </p>
                <hr class="dark horizontal">
                <div class="d-flex ">
                  {{-- <i class="material-icons text-sm my-auto me-1">schedule</i> --}}
                  <p class="mb-0 text-sm"> Cập nhật 4 phút trước </p>
                </div>
              </div>
            </div>
          </div>

        </div>
        <div class="row mb-4">
          <div class="col-lg-8 col-md-7 mb-md-0 mb-4">
            <div class="card" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Đơn hàng</h4>
                    {{-- <p class="text-sm mb-0">
                      <i class="fa fa-check text-info" aria-hidden="true"></i>
                      <span class="font-weight-bold ms-1">30 done</span> this month
                    </p> --}}
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Khách hàng</th>
                        <th class=" text-xxs font-weight-bolder opacity-7 ps-2">
                          Số điện thoại</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Thanh toán</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Trạng thái</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($orderDetail as $row)
                      <tr>
                        <td>
                          {{ $order->getCus($row->idCus) }}
                        </td>
                        <td>
                          {{ $order->getPhone($row->idCus) }}
                        </td>
                        <td class="align-middle text-center text-sm">
                          {{ $row->thanhtoan }}
                        </td>
                        @if ($row->status > 0)
                        <td class="align-middle text-success">
                          Đơn hàng đã được xác nhận
                        </td>
                        @else
                        <td class="align-middle text-danger">
                          Đơn hàng chưa được xác nhận
                        </td>
                        @endif
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- danh sách sản phẩm hot --}}
            <div class="card w-100" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Sản phẩm HOT</h4>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Tên sản phẩm</th>
                        <th class="ps-2">
                          Hình ảnh</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Giảm giá</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Số lượng mua</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($product2 as $row)
                      <tr>
                        <td>
                          {{ $row->namePro }}
                        </td>
                        <td>
                          <img style="max-width:100px;max-height:100px"
                            src="{{ asset('assets/img-add-pro/' . $productImg->getImgProduct($row->idPro)) }}">
                        </td>
                        @if ($row->discount > 0)
                        <td class="align-middle text-center text-sm">
                          {{ $row->discount }}%</td>
                        @else
                        <td></td>
                        @endif
                        <td class="align-middle text-center text-sm">{{ $row->Total }}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            {{-- danh sách sản phẩm bán chậm --}}
            <div class="card w-100" style="border:1px solid black">
              <div class="card-header pb-0">
                <div class="row">
                  <div class="col-lg-6 col-7">
                    <h4 class="text-black">Sản phẩm bán chậm</h4>
                  </div>
                </div>
              </div>
              <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                  <table class="table align-items-center mb-0">
                    <thead class="table-primary">
                      <tr>
                        <th class=" text-xxs font-weight-bolder opacity-7">
                          Tên sản phẩm</th>
                        <th class="ps-2">
                          Hình ảnh</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Giảm giá</th>
                        <th class="text-center text-xxs font-weight-bolder opacity-7">
                          Số lượng tồn</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($product4 as $row)
                      <tr>
                        <td>
                          {{ $row->namePro }}
                        </td>
                        <td>
                          <img style="max-width:100px;max-height:100px"
                            src="{{ asset('assets/img-add-pro/' . $productImg->getImgProduct($row->idPro)) }}">
                        </td>
                        @if ($row->discount > 0)
                        <td class="align-middle text-center text-sm">
                          {{ $row->discount }}%</td>
                        @else
                        <td></td>
                        @endif
                        <td class="align-middle text-center text-sm">{{ $row->count }}
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-5">
            <div class="card">
              <div class="card-header pb-0">
                <h5 class="text-black">Thông báo</h5>
                {{-- <p class="text-sm">
                  <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                  <span class="font-weight-bold">24%</span> this month
                </p> --}}
              </div>
              <div class="card-body p-3">
                <div class="timeline timeline-one-side" style="height:300px;overflow:auto">
                  @foreach ($CustomerNotice as $row)
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-success text-gradient">thông báo</i>
                    </span>
                    <div class="timeline-content">
                      <h5 class="text-dark text-sm font-weight-bold mb-0">
                        {{ $row->name }}
                      </h5>
                      <p>Đã đăng ký tài khoản thành công</p>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                        {{ $row->created_at }}
                      </p>
                    </div>
                  </div>
                  <hr>
                  @endforeach
                  @foreach ($OrderNotice as $row)
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-icons text-success text-gradient">thông báo</i>
                    </span>
                    <div class="timeline-content">
                      <h5 class="text-dark text-sm font-weight-bold mb-0">
                        {{ $order->getCus($row->idCus) }}
                      </h5>
                      <p>Đã đặt hàng</p>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                        {{ $row->created_at }}
                      </p>
                    </div>
                  </div>
                  <hr>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="{{ asset('assets/js/admin/homeadmin.js') }}"></script>
</div>
@endsection