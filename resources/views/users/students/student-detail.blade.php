@extends('layouts.app')
@section('tittle','Chi tiết học sinh')
@section('content')
@if(empty($student['user']))
    <div style="margin:auto">
      <div style="display:flex;align-item:center;justify-content:center">
            <img src="{{asset('assets/images/error/emty.svg')}}" width=50%> 
      </div>
      <h5 style="text-align:center;margin:10px">{{ $message ?? 'Không có dữ liệu học sinh' }}</h5>
    </div>               
@else
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg p-4" style="width: 100%; border-radius: 20px;">
        <div class="text-center mb-4">
            <img
                src="{{ data_get($student, 'user.profile.avatar') ?: asset('assets/images/avatars/01.png') }}"
                alt="Avatar"
                class="rounded"
                style="width:150px; height:150px; object-fit:cover;">

                <h4 class="mt-3 mb-0 fw-bold">{{$student['user']['profile']['hoten'] ?? 'Chưa có'}}</h4>
        </div>
        <div class="d-flex justify-content-center">
            <table class="table table-borderless" style="width:100px">
                <tbody>
                    <tr>
                        <th>Mã học sinh:</th>
                        <td>{{$student['user']['hoc_sinh_info']['mahs'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Ngày sinh:</th>
                        <td>{{ isset($student['user']['profile']['ngaysinh']) 
                                ? \Carbon\Carbon::parse($student['user']['profile']['ngaysinh'])->format('d/m/Y') 
                                : 'Chưa có' 
                            }}
                        </td>
                    </tr>
                    <tr>
                        <th>Giới tính:</th>
                        <td>{{$student['user']['profile']['gioitinh'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Lớp:</th>
                        <td>{{$student['user']['hoc_sinh_info']['lop'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{$student['user']['email'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Tuyến xe:</th>
                        <td>{{$student['user']['hoc_sinh_info']['xe_id']['tuyen'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Xe đưa đón:</th>
                        <td>{{$student['user']['hoc_sinh_info']['xe_id']['bienso'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Phụ huynh:</th>
                        <td>{{$student['user']['hoc_sinh_info']['phu_huynh']['hoten'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td>{{$student['user']['hoc_sinh_info']['phu_huynh']['sdt'] ?? 'Chưa có'}}</td>
                    </tr>
                    <tr>
                        <th>Địa chỉ:</th>
                        <td>{{$student['user']['profile']['diachi'] ?? 'Chưa có'}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
