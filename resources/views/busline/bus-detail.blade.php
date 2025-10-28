@extends('layouts.app')
@section('tittle','Chi tiết xe')
@section('content')
@if(empty($bus['xe']))
    <div style="margin:auto">
      <div style="display:flex;align-item:center;justify-content:center">
            <img src="{{asset('assets/images/error/emty.svg')}}" width=50%> 
      </div>
      <h5 style="text-align:center;margin:10px">{{ $message ?? 'Không có dữ liệu xe' }}</h5>
    </div>               
@else
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg" style="width: 100%; border-radius: 20px;padding:30px">
        <h5>Thông tin xe</h5>
        <div class="d-flex ">
            <table class="table table-borderless" style="width:100px">
                <tbody>
                    <tr>
                        <th>Biển số xe:</th>
                        <td>{{$bus['xe']['bienso'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Sức chứa:</th>
                        <td>
                            {{ count($bus['xe']['hoc_sinh_ids']) ?? 'chưa có'}}/{{ $bus['xe']['suc_chua'] ?? 'chưa có'}}
                        </td>
                    </tr>
                    <tr>
                        <th>Tuyến:</th>
                        <td>{{$bus['xe']['tuyen'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Tài xế:</th>
                        <td>{{$bus['xe']['taixe_id']['profile']['hoten'] ?? 'Chưa có'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between">
            <h5>Danh sách học sinh trên xe</h5>
            <button class="btn" style="color: #3a57e8"
                data-bs-toggle="modal"
                data-bs-target="#addStudentModal">
                <svg class="icon-27" width="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M21.101 9.58786H19.8979V8.41162C19.8979 7.90945 19.4952 7.5 18.999 7.5C18.5038 7.5 18.1 7.90945 18.1 8.41162V9.58786H16.899C16.4027 9.58786 16 9.99731 16 10.4995C16 11.0016 16.4027 11.4111 16.899 11.4111H18.1V12.5884C18.1 13.0906 18.5038 13.5 18.999 13.5C19.4952 13.5 19.8979 13.0906 19.8979 12.5884V11.4111H21.101C21.5962 11.4111 22 11.0016 22 10.4995C22 9.99731 21.5962 9.58786 21.101 9.58786Z" fill="currentColor"></path>                                <path d="M9.5 15.0156C5.45422 15.0156 2 15.6625 2 18.2467C2 20.83 5.4332 21.5001 9.5 21.5001C13.5448 21.5001 17 20.8533 17 18.269C17 15.6848 13.5668 15.0156 9.5 15.0156Z" fill="currentColor"></path>                                <path opacity="0.4" d="M9.50023 12.5542C12.2548 12.5542 14.4629 10.3177 14.4629 7.52761C14.4629 4.73754 12.2548 2.5 9.50023 2.5C6.74566 2.5 4.5376 4.73754 4.5376 7.52761C4.5376 10.3177 6.74566 12.5542 9.50023 12.5542Z" fill="currentColor"></path>                                </svg>                  
            </button>
        </div>
        <div class="card-body px-0">
               <div class="table-responsive">
                  <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                     <thead>
                        <tr class="ligth">
                           <th>STT</th>
                           <th>Họ và tên</th>
                           <th>Giới tính</th>
                           <th>Số điện thoại</th>
                           <th>Địa chỉ nhà</th>
                           <th style="min-width: 100px">Xóa</th>
                        </tr>
                     </thead>
                     @if(empty($bus['xe']['hoc_sinh_ids']))
                    </table>
                     <h5 style="text-align:center;">Chưa có học sinh nào được thêm vào xe này</h5>
                     @else
                     <tbody>
                        @foreach($bus['xe']['hoc_sinh_ids'] as $index => $user)
                        <tr onclick="window.location='{{ route('student-list.detail', $user['user_id']) }}'" style="cursor:pointer;">
                           <td class="text-center">{{$index +1}}</td>
                           <td>{{ $user['hoten'] ?? 'chưa có'}}</td>
                           <td>{{ $user['gioitinh'] ?? 'chưa có'}}</td>
                           <td>{{ $user['sdt'] ?? 'chưa có'}}</td>
                           <td>{{ $user['diachi'] ?? 'chưa có'}}</td>
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a href="javascript:void(0)" 
                                    class="btn-delete-student" 
                                    data-student-id="{{ $user['user_id'] }}" 
                                    data-xe-id="{{ $bus['xe']['_id'] }}"
                                    onclick="event.stopPropagation(); removeStudent('{{ $bus['xe']['_id'] }}', '{{ $user['user_id'] }}');">
                                    <span class="btn-inner">
                                       <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none"
                                          xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                          <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5"
                                             stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973"
                                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                    </span>
                                 </a>

                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                     @endif
                  </table>
               </div>
            </div>
    </div>
</div>
@endif
<!-- Modal thêm học sinh -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 15px;">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Thêm học sinh vào xe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>

      <form id="addStudentForm">
        @csrf
        <div class="modal-body">
          <div class="table-responsive">
            @if(empty($students))
              <div style="margin:auto">
                <h5 style="text-align:center;margin:10px">{{ $message ?? 'Không có học sinh chưa có xe' }}</h5>
              </div>
            @else
              <table id="user-list-table" class="table table-striped align-middle">
                <thead class="table-light">
                  <tr>
                    <th class="text-center" style="width: 50px;">Chọn</th>
                    <th>STT</th>
                    <th>Mã học sinh</th>
                    <th>Họ và tên</th>
                    <th>Lớp</th>
                    <th>Địa chỉ nhà</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($students as $index => $user)
                    <tr>
                      <td class="text-center">
                        <input type="checkbox" name="hocSinhIds[]" value="{{ $user['_id'] }}">
                      </td>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $user['hoc_sinh_info']['mahs'] ?? 'Chưa có' }}</td>
                      <td>{{ $user['profile']['hoten'] ?? 'Chưa có' }}</td>
                      <td>{{ $user['hoc_sinh_info']['lop'] ?? 'Chưa có' }}</td>
                      <td>{{ $user['profile']['diachi'] ?? 'Chưa có' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
          <button type="submit" class="btn btn-primary" id="saveStudentBtn">Lưu</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addStudentForm');
    const saveBtn = document.getElementById('saveStudentBtn');
    

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        const xeId = "{{ $bus['xe']['_id'] ?? '' }}";
        const selected = Array.from(form.querySelectorAll('input[name="hocSinhIds[]"]:checked'))
            .map(cb => cb.value);
        console.log('Selected:', selected);
        console.log('XeId:', xeId);
        if (selected.length === 0) {
            Swal.fire('Thông báo', 'Vui lòng chọn ít nhất một học sinh.', 'warning');
            return;
        }

        saveBtn.disabled = true;
        fetch(`/bus-list/${xeId}/add-students`, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ hocSinhIds: selected })
})
.then(async res => {
    const data = await res.json().catch(() => null);
    console.log('Response:', data);

    if (!data) {
        Swal.fire('Lỗi', 'Phản hồi không hợp lệ từ server', 'error');
        return;
    }

    // ✅ Sửa đoạn điều kiện này
    if (data.success || (data.message && data.message.toLowerCase().includes("thành công"))) {
        Swal.fire({
            icon: 'success',
            title: 'Thành công!',
            text: data.message || 'Thêm học sinh vào xe thành công',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                location.reload();
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: data.message || 'Thêm học sinh thất bại'
        });
    }

})
.catch(err => {
    Swal.fire('Lỗi', 'Không thể kết nối đến server', 'error');
    console.error(err);
})
.finally(() => saveBtn.disabled = false);

    });
});

// Xóa học sinh khỏi xe
function removeStudent(xeId, hocSinhId) {
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Bạn có chắc muốn xóa học sinh này khỏi xe?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/bus-list/${xeId}/remove-student/${hocSinhId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: data.message,
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: data.message || 'Không thể xoá học sinh khỏi xe.',
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi kết nối!',
                    text: error.message,
                });
            });
        }
    });
}
</script>

@endsection
