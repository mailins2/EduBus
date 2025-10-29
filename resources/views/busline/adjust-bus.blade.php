@extends('layouts.app')

@section('title', 'Chỉnh sửa thông tin xe')

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
<form action="{{ route('bus-list.update', $bus['xe']['_id']) }}" id="studentForm" method="POST" enctype="multipart/form-data">
   @csrf
    @method('PUT')
   <div class="container-fluid content-inner mt-n5 py-0">
      <div class="row">
         <!-- Cột bên phải -->
         <div class="col-xl-9 col-lg-8">
            <div class="card">
               <div class="card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Chỉnh sửa xe</h4>
                  </div>
               </div>
               <div class="card-body">
                  <div class="new-user-info">
                        <div class="row">
                           <div class="form-group col-md-12">
                              <label class="form-label" for="name">Biển số xe:</label>
                              <input value="{{$bus['xe']['bienso'] ?? '' }}" type="text" class="form-control" id="name" name="bienso" required>
                              <small id="error-name" class="text-danger error-message"></small>
                           </div>
                           <input type="hidden" name="suc_chua" value="16">
                           <!-- Tuyến -->
                            <div class="form-group col-md-12">
                            <label class="form-label">Tuyến:</label>
                            @php
                                $currentRoute = $bus['xe']['tuyen'] ?? '';
                            @endphp
                            <select name="tuyen" class="selectpicker form-control" data-style="py-0" required>
                                <option value="">-- Chọn --</option>
                                <option value="Tuyến 1: Quận 1 - Quận 3 - Quận 5 - Quận 10" {{ $currentRoute == 'Tuyến 1: Quận 1 - Quận 3 - Quận 5 - Quận 10' ? 'selected' : '' }}>Tuyến 1: Quận 1 - Quận 3 - Quận 5 - Quận 10</option>
                                <option value="Tuyến 2: Quận 2 (TP Thủ Đức) - Quận 9 (TP Thủ Đức) - Quận Thủ Đức (TP Thủ Đức)" {{ $currentRoute == 'Tuyến 2: Quận 2 (TP Thủ Đức) - Quận 9 (TP Thủ Đức) - Quận Thủ Đức (TP Thủ Đức)' ? 'selected' : '' }}>Tuyến 2: Quận 2 (TP Thủ Đức) - Quận 9 (TP Thủ Đức) - Quận Thủ Đức (TP Thủ Đức)</option>
                                <option value="Tuyến 3: Quận 4 - Quận 7 - Nhà Bè" {{ $currentRoute == 'Tuyến 3: Quận 4 - Quận 7 - Nhà Bè' ? 'selected' : '' }}>Tuyến 3: Quận 4 - Quận 7 - Nhà Bè</option>
                                <option value="Tuyến 4: Quận 6 - Quận 8 - Bình Chánh" {{ $currentRoute == 'Tuyến 4: Quận 6 - Quận 8 - Bình Chánh' ? 'selected' : '' }}>Tuyến 4: Quận 6 - Quận 8 - Bình Chánh</option>
                                <option value="Tuyến 5: Quận 12 - Gò Vấp - Tân Bình" {{ $currentRoute == 'Tuyến 5: Quận 12 - Gò Vấp - Tân Bình' ? 'selected' : '' }}>Tuyến 5: Quận 12 - Gò Vấp - Tân Bình</option>
                                <option value="Tuyến 6: Quận Bình Thạnh - Phú Nhuận - Quận 1" {{ $currentRoute == 'Tuyến 6: Quận Bình Thạnh - Phú Nhuận - Quận 1' ? 'selected' : '' }}>Tuyến 6: Quận Bình Thạnh - Phú Nhuận - Quận 1</option>
                                <option value="Tuyến 7: Tân Phú - Bình Tân - Quận 11" {{ $currentRoute == 'Tuyến 7: Tân Phú - Bình Tân - Quận 11' ? 'selected' : '' }}>Tuyến 7: Tân Phú - Bình Tân - Quận 11</option>
                                <option value="Tuyến 8: Củ Chi - Hóc Môn - Quận 12" {{ $currentRoute == 'Tuyến 8: Củ Chi - Hóc Môn - Quận 12' ? 'selected' : '' }}>Tuyến 8: Củ Chi - Hóc Môn - Quận 12</option>
                                <option value="Tuyến 9: Quận 5 - Quận 6 - Quận 11" {{ $currentRoute == 'Tuyến 9: Quận 5 - Quận 6 - Quận 11' ? 'selected' : '' }}>Tuyến 9: Quận 5 - Quận 6 - Quận 11</option>
                                <option value="Tuyến 10: Quận 10 - Quận 3 - Quận 1" {{ $currentRoute == 'Tuyến 10: Quận 10 - Quận 3 - Quận 1' ? 'selected' : '' }}>Tuyến 10: Quận 10 - Quận 3 - Quận 1</option>
                            </select>
                            </div>

                            <!-- Tài xế -->
                            <div class="form-group col-md-12">
                            <label class="form-label">Tài xế:</label>
                            <select id="taixe" name="taixe_id" class="selectpicker form-control" data-style="py-0" required>
                                
                                <option value="{{$bus['xe']['taixe_id']['_id'] ?? ''}}">{{$bus['xe']['taixe_id']['profile']['hoten'] ?? ''}}</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver['_id'] }}"
                                        {{ isset($bus['xe']['taixe_id']['_id']) && $bus['xe']['taixe_id']['_id'] == $driver['_id'] ? 'selected' : '' }}>
                                        {{ $driver['profile']['hoten'] ?? 'Tài xế' }}
                                    </option>

                                @endforeach
                            </select>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Sửa</button>
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
{{-- ✅ Hiển thị thông báo SweetAlert --}}
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
      // ✅ chỉ khi người dùng ấn OK mới chuyển trang
      if (result.isConfirmed) {
         window.location.href = "{{ route('bus-list.') }}";
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
      title: 'Thất bại!',
      text: @json(implode("\n", $errors->all())),
      confirmButtonText: 'OK',
      confirmButtonColor: '#dc3545'
   });
});
</script>
@endif
@endsection
