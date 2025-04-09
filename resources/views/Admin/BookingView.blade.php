@extends('Admin.Layout')
@section('content')
<div class="pagetitle">
    <h1 style="font-size:2.5vw;font-size:2.5vh">Danh Sách lịch hẹn</h1>

</div><!-- End Page Title -->
@if (session('notice'))
<script>
    $.toast({
                heading: 'Thông báo',
                text: '{{ session('notice') }}',
                showHideTransition: 'slide',
                icon: 'success',
                position: 'bottom-right'
            })
</script>
@endif
@if (session('error'))
<script>
    $.toast({
                heading: 'Thông báo',
                text: '{{ session('error') }}',
                showHideTransition: 'slide',
                icon: 'error',
                position: 'bottom-right'
            })
</script>
@endif
<section class="section">
    <div class="row">
        <div class="search mt-4 mb-4 input-group" style="width:50%">
            <button class="input-group-text btn btn-success"><i class="fa-solid fa-magnifying-glass"></i></button>
            <input style="font-size:2vw;font-size:2vh" class="form-control" type="text" id="searchOrders">
        </div>
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body table-responsive">

                    <!-- Table with stripped rows -->
                    <table style="font-size:2vw;font-size:2vh" class="table text-center table-bordered">
                        <thead>
                            <tr>
                                <th> <b>I</b>D lịch hẹn </th>
                                <th>Tên khách hàng </th>
                                <th>Ngày hẹn</th>
                                <th>Dịch vụ</th>
                                <th>Tình trạng</th>
                                <th>Tính năng</th>
                            </tr>
                        </thead>
                        <tbody id="table-order">
                            @foreach ($book as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->nameCus }}</td>

                                <td>{{
                                    \Carbon\Carbon::parse((int)$row->date)->format('d-m-Y H:i:s') }}</td>
                                <td>{{ $row->nameService }}</td>
                                @if ($row->status == 1)
                                <td><button style="font-size:2vw;font-size:2vh" class="btn btn-success">Đã
                                        duyệt</button></td>
                                @elseif ($row->status == 2)
                                <td><button style="font-size:2vw;font-size:2vh" class="btn btn-success">Đã hoàn
                                        thành</button></td>
                                @else
                                <td><button style="font-size:2vw;font-size:2vh" class="btn btn-danger">Chưa
                                        duyệt</button></td>
                                @endif
                                @if ($row->status == 1)
                                <td class="d-flex justify-content-around flex-wrap">
                                    {{-- detail book --}}
                                    <a style="text-decoration:none"
                                        href="{{ route('admin.bookDetail', ['id' => $row->id]) }}"><button
                                            style="font-size:2vw;font-size:2vh" class="btn btn-secondary"><i
                                                class="fa-solid fa-bars"></i></button></a>
                                    {{-- xác nhận lịch hẹn đã hoàn thành --}}

                                    {{-- <a href="{{ route('admin.bookComplete',['id'=>$row->id]) }}"><button
                                            style="font-size:2vw;font-size:2vh" data-bs-toggle="modal"
                                            data-bs-target="#confirm{{ $row->id }}" class="btn btn-primary"><i
                                                class="fa-solid fa-money-bill"></i></button></a> --}}
                                    {{-- unconfirm book --}}
                                    <a style="text-decoration:none" class="ms-2"><button
                                            style="font-size:2vw;font-size:2vh" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#unconfirm{{ $row->id }}"><i
                                                class="fa-solid fa-circle-notch"></i></button></a>
                                    {{-- Modal unconfirm book --}}
                                    <div class="modal fade" id="unconfirm{{ $row->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông
                                                        báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Xác nhận hủy lịch hẹn</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    @csrf
                                                    <a href="{{ route('admin.bookUnConfirm', ['id' => $row->id]) }}">
                                                        <button type="submit" class="btn btn-primary">Xác
                                                            nhận</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @elseif ($row->status == 2)
                                <td>
                                    {{-- detail book --}}
                                    <a style="text-decoration:none"
                                        href="{{ route('admin.bookDetail', ['id' => $row->id]) }}"><button
                                            style="font-size:2vw;font-size:2vh" class="btn btn-secondary"><i
                                                class="fa-solid fa-bars"></i></button></a>
                                    {{-- xác nhận lịch hẹn đã hoàn thành --}}

                                    {{-- <a href="{{ route('admin.bookComplete',['id'=>$row->id]) }}"><button
                                            style="font-size:2vw;font-size:2vh" data-bs-toggle="modal"
                                            data-bs-target="#confirm{{ $row->id }}" class="btn btn-primary"><i
                                                class="fa-solid fa-money-bill"></i></button></a> --}}
                                </td>
                                @else <td class="d-flex justify-content-around flex-wrap">
                                    {{-- detail book --}}
                                    <a style="text-decoration:none"
                                        href="{{ route('admin.bookDetail', ['id' => $row->id]) }}"><button
                                            class="btn btn-secondary"><i class="fa-solid fa-bars"></i></button></a>
                                    {{-- confirm book --}}
                                    <a style="text-decoration:none" class="ms-2"><button data-bs-toggle="modal"
                                            data-bs-target="#confirm{{ $row->id }}" class="btn btn-primary"><i
                                                class="fa-solid fa-check"></i></button></a>
                                    {{-- modal confirm book --}}
                                    <div class="modal fade" id="confirm{{ $row->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Thông
                                                        báo</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Xác nhận lịch hẹn</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    @csrf
                                                    <a href="{{ route('admin.bookConfirm', ['id' => $row->id]) }}">
                                                        <button type="submit" class="btn btn-primary">Xác
                                                            nhận</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                    {{ $book->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Button trigger modal -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="fa-solid fa-check-double" style="color: #12ca27;"></i>
            <strong class="me-auto ms-2">Thông báo</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Đơn hàng đã được giao !
        </div>
    </div>
</div>
<!-- Modal xóa order -->
<div class="modal fade" id="deleteBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Bạn có chắc chắn muốn xóa lịch hẹn này không ?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <a style="text-decoration:none" class="ms-2" href="index.php?controller=book&action=delete&id="><button
                        class="btn btn-primary">Xác
                        nhận</button></a>
            </div>
        </div>
    </div>
</div>
<!-- Modal giao hàng -->
<div class="modal fade" id="delivery" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Thông báo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Xác nhận giao hàng</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <a href="index.php?controller=donhang&action=delivery&id="> <button type="submit"
                        class="btn btn-primary">Xác nhận</button></a>
            </div>
        </div>
    </div>
</div>
<script>
    const toastTrigger = document.getElementById('liveToastBtn')
        const toastLiveExample = document.getElementById('liveToast')

        if (toastTrigger) {
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
            toastTrigger.addEventListener('click', () => {
                toastBootstrap.show()
            })
        }
</script>
<script>
    $(document).ready(function() {
            $("#searchOrders").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table-order tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
</script>
@endsection