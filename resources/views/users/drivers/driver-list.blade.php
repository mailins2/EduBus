@extends('layouts.app')
@section('tittle','Danh sách tài xế')
@section('content')

<div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Danh sách tài xế</h4>
               </div>
               <a class="btn" role ="button" style="color:#3a57e8" href="/driver-list/add-driver">
                     <svg class="icon-27" width="27" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M21.101 9.58786H19.8979V8.41162C19.8979 7.90945 19.4952 7.5 18.999 7.5C18.5038 7.5 18.1 7.90945 18.1 8.41162V9.58786H16.899C16.4027 9.58786 16 9.99731 16 10.4995C16 11.0016 16.4027 11.4111 16.899 11.4111H18.1V12.5884C18.1 13.0906 18.5038 13.5 18.999 13.5C19.4952 13.5 19.8979 13.0906 19.8979 12.5884V11.4111H21.101C21.5962 11.4111 22 11.0016 22 10.4995C22 9.99731 21.5962 9.58786 21.101 9.58786Z" fill="currentColor"></path>                                <path d="M9.5 15.0156C5.45422 15.0156 2 15.6625 2 18.2467C2 20.83 5.4332 21.5001 9.5 21.5001C13.5448 21.5001 17 20.8533 17 18.269C17 15.6848 13.5668 15.0156 9.5 15.0156Z" fill="currentColor"></path>                                <path opacity="0.4" d="M9.50023 12.5542C12.2548 12.5542 14.4629 10.3177 14.4629 7.52761C14.4629 4.73754 12.2548 2.5 9.50023 2.5C6.74566 2.5 4.5376 4.73754 4.5376 7.52761C4.5376 10.3177 6.74566 12.5542 9.50023 12.5542Z" fill="currentColor"></path>                                </svg>                  
               </a>
            </div>
            <div class="card-body px-0">
               <div class="table-responsive">
                  @if(empty($users))
                  <div style="margin:auto">
                     <div style="display:flex;align-item:center;justify-content:center">
                        <img src="..\assets\images\error\emty.svg" width=50%> 
                     </div>
                     <h5 style="text-align:center;margin:10px">{{ $message ?? 'Không có dữ liệu tài xế' }}</h5>
                  </div>
                  @else
                  <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                     <thead>
                        <tr class="ligth">
                           <th>STT</th>
                           <th>Họ và tên</th>
                           <th>Số điện thoại</th>
                           <th>Xe</th>
                           <th>Tuyến đường</th>
                           <th style="min-width: 100px">Chỉnh sửa</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $index => $user)
                        <tr onclick="window.location='{{ route('driver-list.detail', $user['_id']) }}'" style="cursor:pointer;">
                           <td class="text-center">{{($index +1)+(($currentPage-1)*10)}}</td>
                           <td>{{ $user['profile']['hoten'] ?? 'chưa có'}}</td>
                           <td>{{ $user['profile']['sdt'] ?? 'chưa có'}}</td>
                           <td>{{ $user['tai_xe_info']['xe_id']['bienso'] ?? 'chưa có'}}</td>
                           <td>{{ $user['tai_xe_info']['xe_id']['tuyen'] ?? 'chưa có'}}</td>
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a class="btn btn-sm btn-icon btn-warning"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Edit"
                                    href="{{ route('driver-list.adjust', $user['_id']) }}"
                                    onclick="event.stopPropagation()">
                                    <span class="btn-inner">
                                       <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M11.4925 2.78906H7.75349C4.67849 2.78906 2.75049 4.96606 2.75049 8.04806V16.3621C2.75049 19.4441 4.66949 21.6211 7.75349 21.6211H16.5775C19.6625 21.6211 21.5815 19.4441 21.5815 16.3621V12.3341" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path fill-rule="evenodd" clip-rule="evenodd" d="M8.82812 10.921L16.3011 3.44799C17.2321 2.51799 18.7411 2.51799 19.6721 3.44799L20.8891 4.66499C21.8201 5.59599 21.8201 7.10599 20.8891 8.03599L13.3801 15.545C12.9731 15.952 12.4211 16.181 11.8451 16.181H8.09912L8.19312 12.401C8.20712 11.845 8.43412 11.315 8.82812 10.921Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M15.1655 4.60254L19.7315 9.16854" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                    </span>
                                 </a>
                                 <a class="btn btn-sm btn-icon btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#confirmDeleteModal"
                                    data-id="{{ $user['_id'] }}"
                                    title="Delete"
                                    onclick="event.stopPropagation()">
                                    <span class="btn-inner">
                                       <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
                                          <path d="M19.3248 9.46826C19.3248 9.46826 18.7818 16.2033 18.4668 19.0403C18.3168 20.3953 17.4798 21.1893 16.1088 21.2143C13.4998 21.2613 10.8878 21.2643 8.27979 21.2093C6.96079 21.1823 6.13779 20.3783 5.99079 19.0473C5.67379 16.1853 5.13379 9.46826 5.13379 9.46826" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M20.708 6.23975H3.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M17.4406 6.23973C16.6556 6.23973 15.9796 5.68473 15.8256 4.91573L15.5826 3.69973C15.4326 3.13873 14.9246 2.75073 14.3456 2.75073H10.1126C9.53358 2.75073 9.02558 3.13873 8.87558 3.69973L8.63258 4.91573C8.47858 5.68473 7.80258 6.23973 7.01758 6.23973" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                       </svg>
                                    </span>
                                 </a>
                              </div>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  <div class="d-flex justify-content-center align-item-center">
                     <nav aria-label="Page navigation example">
                        <ul class="pagination">
                              {{-- Previous --}}
                              <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                                 <a class="page-link" href="{{ $currentPage > 1 ? route('driver-list.', ['page' => $currentPage - 1]) : '#' }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                 </a>
                              </li>

                              {{-- Page numbers --}}
                              @foreach(range(1, $pages) as $n)
                                 <li class="page-item {{ $currentPage == $n ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('driver-list.', ['page' => $n]) }}">
                                          {{ $n }}
                                    </a>
                                 </li>
                              @endforeach

                              {{-- Next --}}
                              <li class="page-item {{ $currentPage == $pages ? 'disabled' : '' }}">
                                 <a class="page-link" href="{{ $currentPage < $pages ? route('driver-list.', ['page' => $currentPage + 1]) : '#' }}" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                 </a>
                              </li>

                        </ul>
                     </nav>
                  </div>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Modal xác nhận xóa -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteLabel">Xác nhận xóa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        Bạn có chắc chắn muốn xóa tài xế này không?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <form id="deleteForm" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Xóa</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const confirmModal = document.getElementById('confirmDeleteModal');
  confirmModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const studentId = button.getAttribute('data-id');
    const form = document.getElementById('deleteForm');
    form.action = '/driver-list/delete/' + studentId; // hoặc "{{ url('/students') }}/" + studentId nếu dùng Blade
  });
});
</script>

@if(session('success') || session('error'))
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resultModalLabel">Kết quả</h5>
      </div>
      <div class="modal-body">
        {{ session('success') ?? session('error') }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var resultModal = new bootstrap.Modal(document.getElementById('resultModal'));
  resultModal.show();
});
</script>
@endif
@endsection