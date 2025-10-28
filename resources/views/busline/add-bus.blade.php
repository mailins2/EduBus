@extends('layouts.app')

@section('title', 'Thêm xe mới')

@section('content')
@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Thành công!',
                text: @json(session('success')),
                confirmButtonText: 'OK',
                confirmButtonColor: '#28a745'
            }).then((result) => {
               if (result.isConfirmed) {
                     window.location.href = "{{ route('bus-list.') }}"; // quay về danh sách xe
               }
            });
         });
    </script>
@endif

@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Đã xảy ra lỗi!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Đóng',
                confirmButtonColor: '#dc3545'
            });
        });
    </script>
@endif
<form action="{{ route('bus-list.store') }}" method="POST">
   @csrf
   <div class="container-fluid content-inner mt-n5 py-0">
      <div class="row">
         <!-- Cột bên phải -->
         <div class="col-xl-9 col-lg-8">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Thêm xe mới</h4>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-user-info">
                        <div class="row">
                           <div class="form-group col-md-12">
                              <label class="form-label" for="name">Biển số xe:</label>
                              <input type="text" class="form-control" id="name" name="bienso" required>
                              <small id="error-name" class="text-danger error-message"></small>
                           </div>
                           <input type="hidden" name="suc_chua" value="16">
                           <div class="form-group col-md-12">
                              <label class="form-label">Tuyến:</label>
                              <select name="tuyen" class="selectpicker form-control" data-style="py-0" required>
                                 <option value="">-- Chọn --</option>
                                 <option value="Tuyến 1: Quận 1 - Quận 3 - Quận 5 - Quận 10">Tuyến 1: Quận 1 - Quận 3 - Quận 5 - Quận 10</option>
                                 <option value="Tuyến 2: Quận 2 (TP Thủ Đức) - Quận 9 (TP Thủ Đức) - Quận Thủ Đức (TP Thủ Đức)">Tuyến 2: Quận 2 (TP Thủ Đức) - Quận 9 (TP Thủ Đức) - Quận Thủ Đức (TP Thủ Đức)</option>
                                 <option value="Tuyến 3: Quận 4 - Quận 7 - Nhà Bè">Tuyến 3: Quận 4 - Quận 7 - Nhà Bè</option>
                                 <option value="Tuyến 4: Quận 6 - Quận 8 - Bình Chánh">Tuyến 4: Quận 6 - Quận 8 - Bình Chánh</option>
                                 <option value="Tuyến 5: Quận 12 - Gò Vấp - Tân Bình">Tuyến 5: Quận 12 - Gò Vấp - Tân Bình</option>
                                 <option value="Tuyến 6: Quận Bình Thạnh - Phú Nhuận - Quận 1">Tuyến 6: Quận Bình Thạnh - Phú Nhuận - Quận 1</option>
                                 <option value="Tuyến 7: Tân Phú - Bình Tân - Quận 11">Tuyến 7: Tân Phú - Bình Tân - Quận 11</option>
                                 <option value="Tuyến 8: Củ Chi - Hóc Môn - Quận 12">Tuyến 8: Củ Chi - Hóc Môn - Quận 12</option>
                                 <option value="Tuyến 9: Quận 5 - Quận 6 - Quận 11">Tuyến 9: Quận 5 - Quận 6 - Quận 11</option>
                                 <option value="Tuyến 10: Quận 10 - Quận 3 - Quận 1">Tuyến 10: Quận 10 - Quận 3 - Quận 1</option>

                              </select>
                           </div>
                           <label class="form-label">Tài xế:</label>
                           <div class="form-group col-md-12">
                              <select id="taixe" name="taixe_id" class="selectpicker form-control" data-style="py-0" required>
                                 <option value="">-- Chọn --</option>
                                 @foreach($drivers as $driver)
                                       <option value="{{ $driver['_id'] }}">{{ $driver['profile']['hoten'] ?? 'Tài xế' }}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<style>
.error-message { font-size: 0.9rem; margin-top: 3px; display: block; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
