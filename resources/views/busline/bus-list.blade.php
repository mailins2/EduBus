@extends('layouts.app')
@section('tittle','Danh sách xe')
@section('content')

<div>
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Danh sách xe</h4>
               </div>
               <a class="btn" role ="button" style="color:#3a57e8" href="/bus-list/add-bus">
                  <svg class="icon-32" width="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">                                <path opacity="0.4" d="M16.6667 2H7.33333C3.92889 2 2 3.92889 2 7.33333V16.6667C2 20.0622 3.92 22 7.33333 22H16.6667C20.0711 22 22 20.0622 22 16.6667V7.33333C22 3.92889 20.0711 2 16.6667 2Z" fill="currentColor"></path>                                <path d="M15.3205 12.7083H12.7495V15.257C12.7495 15.6673 12.4139 16 12 16C11.5861 16 11.2505 15.6673 11.2505 15.257V12.7083H8.67955C8.29342 12.6687 8 12.3461 8 11.9613C8 11.5765 8.29342 11.2539 8.67955 11.2143H11.2424V8.67365C11.2824 8.29088 11.6078 8 11.996 8C12.3842 8 12.7095 8.29088 12.7495 8.67365V11.2143H15.3205C15.7066 11.2539 16 11.5765 16 11.9613C16 12.3461 15.7066 12.6687 15.3205 12.7083Z" fill="currentColor"></path>                                </svg>                            
               </a>
            </div>
            <div class="card-body px-0">
               <div class="table-responsive">
                  @if(empty($buses))
                  <div style="margin:auto">
                     <div style="display:flex;align-item:center;justify-content:center">
                        <img src="..\assets\images\error\emty.svg" width=50%> 
                     </div>
                     <h5 style="text-align:center;margin:10px">{{ $message ?? 'Không có dữ liệu xe' }}</h5>
                  </div>
                  @else
                  <table id="user-list-table" class="table table-striped" role="grid" data-bs-toggle="data-table">
                     <thead>
                        <tr class="ligth">
                           <th>STT</th>
                           <th>Biển số</th>
                           <th>Sức chứa</th>
                           <th>Tuyến đường</th>
                           <th>Tài xế</th>
                           <th style="min-width: 100px">Chỉnh sửa</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($buses as $index => $bus)
                        <tr onclick="window.location='{{ route('bus-list.detail', $bus['_id']) }}'" style="cursor:pointer;">
                           <td class="text-center">{{($index +1)+(($currentPage-1)*10)}}</td>
                           <td>{{ $bus['bienso'] ?? 'chưa có'}}</td>
                           <td>{{ count($bus['hoc_sinh_ids']) ?? 'chưa có'}}/{{ $bus['suc_chua'] ?? 'chưa có'}}</td>
                           <td>{{ $bus['tuyen'] ?? 'chưa có'}}</td>
                           <td>{{ $bus['taixe_id']['profile']['hoten'] ?? 'chưa có'}}</td>
                           <td>
                              <div class="flex align-items-center list-user-action">
                                 <a class="btn btn-sm btn-icon btn-warning"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Edit"
                                    href="{{ route('bus-list.adjust', $bus['_id']) }}"
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
                                    href="javascript:void(0);"
                                    title="Delete"
                                    onclick="event.stopPropagation(); confirmDelete('{{ $bus['_id'] }}')">
                                    <span class="btn-inner">
                                       <svg class="icon-20" width="20" viewBox="0 0 24 24" fill="none" 
                                          xmlns="http://www.w3.org/2000/svg" stroke="currentColor">
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
                                 <a class="page-link" href="{{ $currentPage > 1 ? route('bus-list.', ['page' => $currentPage - 1]) : '#' }}" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                 </a>
                              </li>

                              {{-- Page numbers --}}
                              @foreach(range(1, $pages) as $n)
                                 <li class="page-item {{ $currentPage == $n ? 'active' : '' }}">
                                    <a class="page-link" href="{{ route('bus-list.', ['page' => $n]) }}">
                                          {{ $n }}
                                    </a>
                                 </li>
                              @endforeach

                              {{-- Next --}}
                              <li class="page-item {{ $currentPage == $pages ? 'disabled' : '' }}">
                                 <a class="page-link" href="{{ $currentPage < $pages ? route('bus-list.', ['page' => $currentPage + 1]) : '#' }}" aria-label="Next">
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
<!-- Modal Xác nhận -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Xác nhận xóa xe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <p>Bạn có chắc chắn muốn xóa xe này không?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
      </div>
    </div>
  </div>
</div>
<script>
    let deleteBusId = null;

    function confirmDelete(id) {
        deleteBusId = id;
        const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
        if (!deleteBusId) return;

        fetch(`/bus-list/delete/${deleteBusId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            modal.hide();

            Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                if (data.success) window.location.reload();
            });
        })
        .catch(error => {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: 'Không thể kết nối đến máy chủ.'
            });
        });
    });
</script>

@endsection