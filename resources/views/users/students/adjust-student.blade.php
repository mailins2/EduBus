@extends('layouts.app')

@section('title', 'Chỉnh sửa thông tin học sinh')
@php
    $fullAddress = $student['user']['profile']['diachi'] ?? '';
    $street = $district = $ward = '';

    if ($fullAddress) {
        // Bỏ phần "TP.HCM" hoặc các biến thể tương tự ở cuối
        $fullAddress = preg_replace('/,\s*(tp\.?\s*hồ chí minh|thành phố hồ chí minh|tp\.?\s*hcm)$/iu', '', trim($fullAddress));

        $parts = array_map('trim', explode(',', $fullAddress));

        foreach ($parts as $part) {
            $lower = mb_strtolower($part);

            if (str_contains($lower, 'phường') || str_contains($lower, 'xã')) {
                $ward = $part;
            } elseif (str_contains($lower, 'quận') || str_contains($lower, 'huyện') || str_contains($lower, 'thành phố thủ đức')) {
                $district = $part;
            } else {
                // phần còn lại là số nhà, tên đường
                $street = $street ? "$street, $part" : $part;
            }
        }
    }
@endphp


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

<div class="container-fluid content-inner mt-n5 py-0">
   <div class="row">
      <!-- Cột bên trái -->
      <div class="col-xl-3 col-lg-4">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Thông tin học sinh</h4>
               </div>
            </div>
            <div class="card-body">
               <form action="{{ route('student-list.update', $student['user']['_id']) }}" id="studentForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="old_avatar" value="{{ $student['user']['profile']['avatar'] ?? '' }}">
                  <div class="form-group">
                     <div class="profile-img-edit position-relative">
                        <img id="preview"
                             src="{{ $student['user']['profile']['avatar'] ?? asset('assets/images/avatars/01.png') }}"
                             alt="profile-pic"
                             class="theme-color-default-img profile-pic rounded avatar-100">
                        <label class="upload-icone bg-primary" for="fileInput">
                           <svg class="upload-button icon-14" width="20" viewBox="0 0 24 24">
                              <path fill="#fff" d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                           </svg>
                        </label>
                        <input id="fileInput" class="file-upload" type="file" accept="image/*" name="avatar" hidden>
                     </div>
                     <div class="img-extension mt-3">
                        <div class="d-inline-block align-items-center">
                           <span>Chỉ chấp nhận file </span>
                           <a href="#">.jpg</a>
                           <a href="#">.png</a>
                           <a href="#">.jpeg</a>
                        </div>
                     </div>
                     <small id="error-avatar" class="text-danger error-message"></small>
                  </div>

                  <div class="form-group">
                     <label class="form-label" for="studentCode">Mã học sinh:</label>
                     <input id="studentCode" type="text" class="form-control"
                            value="{{ $student['user']['hoc_sinh_info']['mahs'] ?? '' }}"
                            name="mahs" readonly>
                  </div>

                  <div class="form-group">
                     <label class="form-label">Lớp:</label>
                     <select id="classList" name="lop" class="selectpicker form-control" data-style="py-0" required>
                        @if(!empty($student['user']['hoc_sinh_info']['lop']))
                           <option selected value="{{ $student['user']['hoc_sinh_info']['lop'] }}">{{ $student['user']['hoc_sinh_info']['lop'] }}</option>
                        @else
                           <option value="">-- Chọn lớp --</option>
                        @endif
                     </select>
                     <small id="error-classList" class="text-danger error-message"></small>
                  </div>
            </div>
         </div>
      </div>

      <!-- Cột bên phải -->
      <div class="col-xl-9 col-lg-8">
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title">Chỉnh sửa thông tin học sinh</h4>
               </div>
            </div>
            <div class="card-body">
               <div class="new-user-info">
                     <div class="row">
                        <div class="form-group col-md-6">
                           <label class="form-label" for="name">Họ tên:</label>
                           <input type="text" class="form-control" id="name" name="hoten"
                                  value="{{ $student['user']['profile']['hoten'] ?? '' }}" required>
                        </div>

                        <div class="form-group col-md-6">
                           <label for="dob">Ngày sinh:</label>
                           <input type="date" class="form-control" id="dob" name="ngaysinh"
                                  value="{{ isset($student['user']['profile']['ngaysinh']) ? date('Y-m-d', strtotime($student['user']['profile']['ngaysinh'])) : '' }}" required>
                        </div>

                        <div class="form-group col-md-6">
                           <label class="form-label" for="email">Email:</label>
                           <input type="email" class="form-control" id="email" name="email"
                                  value="{{ $student['user']['email'] ?? '' }}">
                        </div>

                        <div class="form-group col-md-6">
                           <label class="form-label">Giới tính:</label>
                           <select name="gioitinh" class="selectpicker form-control" data-style="py-0" required>
                              <option value="">-- Chọn --</option>
                              <option value="Nam" {{ ($student['user']['profile']['gioitinh'] ?? '') === 'Nam' ? 'selected' : '' }}>Nam</option>
                              <option value="Nữ" {{ ($student['user']['profile']['gioitinh'] ?? '') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                           </select>
                        </div>

                        <div class="form-group col-md-6">
                           <label class="form-label" for="phone">Số điện thoại:</label>
                           <input type="text" class="form-control" id="phone" name="sdt"
                                  value="{{ $student['user']['profile']['sdt'] ?? '' }}">
                        </div>

                        <div class="form-group col-md-6">
                           <label class="form-label" for="cccd">CCCD:</label>
                           <input type="text" class="form-control" id="cccd" name="cccd"
                                  value="{{ $student['user']['profile']['cccd'] ?? '' }}">
                        </div>

                        <label class="form-label">Địa chỉ:</label>
                        <div class="form-group col-md-6">
                           <select id="district" name="district" class="selectpicker form-control" data-style="py-0">
                              <option value="">-- Quận --</option>
                           </select>
                        </div>
                        <div class="form-group col-md-6">
                           <select id="ward" name="ward" class="selectpicker form-control" data-style="py-0">
                              <option value="">-- Phường --</option>
                           </select>
                        </div>
                        <div class="form-group col-md-12">
                           <input type="text" class="form-control" id="address" name="address"
                                 value="{{ $street }}" placeholder="Nhập số nhà, tên đường">
                        </div>

                     </div>

                     <hr>
                     <h5 class="mb-3">Liên hệ</h5>
                     <div class="row">
                        <div class="form-group col-md-12">
                           <label class="form-label" for="parent_name">Họ tên phụ huynh:</label>
                           <input type="text" class="form-control" id="parent_name" name="phu_huynh_hoten"
                                  value="{{ $student['user']['hoc_sinh_info']['phu_huynh']['hoten'] ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="relationship">Quan hệ:</label>
                           <input type="text" class="form-control" id="relationship" name="quanhe"
                                  value="{{ $student['user']['hoc_sinh_info']['phu_huynh']['quanhe'] ?? '' }}">
                        </div>
                        <div class="form-group col-md-6">
                           <label class="form-label" for="parent_phone">SĐT phụ huynh:</label>
                           <input type="text" class="form-control" id="parent_phone" name="phu_huynh_sdt"
                                  value="{{ $student['user']['hoc_sinh_info']['phu_huynh']['sdt'] ?? '' }}">
                        </div>
                     </div>

                     <button type="submit" class="btn btn-primary mt-3">Lưu thay đổi</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
.error-message { font-size: 0.9rem; margin-top: 3px; display: block; }
</style>

<script>
// ========== XEM TRƯỚC ẢNH ==========
const fileInput = document.getElementById('fileInput');
const previewImg = document.getElementById('preview');
const defaultImage = "{{ asset('assets/images/avatars/01.png') }}";

fileInput.addEventListener('change', function () {
   const file = this.files[0];
   if (file) {
      const reader = new FileReader();
      reader.onload = e => previewImg.src = e.target.result;
      reader.readAsDataURL(file);
   } else previewImg.src = defaultImage;
});

// ========== SINH DANH SÁCH LỚP ==========
const select = document.getElementById('classList');
const prefixes = ['A', 'B', 'C', 'D'];
for (let grade = 10; grade <= 12; grade++) {
   prefixes.forEach(prefix => {
      for (let i = 1; i <= 5; i++) {
         const value = `${grade}${prefix}${i}`;
         select.add(new Option(value, value));
      }
   });
}

// ========== LOAD QUẬN / PHƯỜNG ==========
async function loadDistricts() {
   const districtSelect = document.getElementById('district');
   const wardSelect = document.getElementById('ward');

   // Giá trị từ server
   const savedDistrict = @json($district);
   const savedWard = @json($ward);

   console.log("📌 Giá trị từ server:", { savedDistrict, savedWard });

   // Hàm chuẩn hoá chữ thường & bỏ dấu
   const normalize = (str) => str ? str.toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .replace(/\s+/g, ' ')
      .trim() : '';

   const normalizedDistrict = normalize(savedDistrict);
   const normalizedWard = normalize(savedWard);

   districtSelect.innerHTML = '<option value="">-- Đang tải danh sách quận --</option>';

   try {
      // TP.HCM code = 79
      const res = await fetch('https://provinces.open-api.vn/api/p/79?depth=2');
      const data = await res.json();

      districtSelect.innerHTML = '<option value="">-- Chọn quận --</option>';
      data.districts.forEach(d => {
         const opt = document.createElement('option');
         opt.value = d.name;
         opt.textContent = d.name;
         opt.setAttribute('data-code', d.code);
         districtSelect.appendChild(opt);
      });

      // ===== Chọn quận mặc định =====
      if (normalizedDistrict) {
         const selectedDistrict = Array.from(districtSelect.options)
            .find(opt => normalize(opt.value) === normalizedDistrict);
         if (selectedDistrict) {
            selectedDistrict.selected = true;
            console.log("✅ Chọn được quận:", selectedDistrict.value);
         } else {
            console.warn("⚠️ Không khớp được quận:", savedDistrict);
         }
      }

      // ===== Sự kiện khi chọn quận =====
      districtSelect.addEventListener('change', async function () {
         const selectedOpt = this.selectedOptions[0];
         const code = selectedOpt ? selectedOpt.getAttribute('data-code') : null;

         wardSelect.innerHTML = '<option value="">-- Đang tải phường --</option>';

         if (!code) {
            wardSelect.innerHTML = '<option value="">-- Chọn phường --</option>';
            return;
         }

         try {
            const res2 = await fetch(`https://provinces.open-api.vn/api/d/${code}?depth=2`);
            const districtData = await res2.json();

            wardSelect.innerHTML = '<option value="">-- Chọn phường --</option>';
            districtData.wards.forEach(w => {
               const opt = document.createElement('option');
               opt.value = w.name;
               opt.textContent = w.name;
               wardSelect.appendChild(opt);
            });

            // ===== Chọn phường mặc định nếu đúng quận =====
            if (normalize(this.value) === normalizedDistrict && normalizedWard) {
               const matchedWard = Array.from(wardSelect.options)
                  .find(opt => normalize(opt.value) === normalizedWard);
               if (matchedWard) {
                  matchedWard.selected = true;
                  console.log("✅ Chọn được phường:", matchedWard.value);
               } else {
                  console.warn("⚠️ Không khớp được phường:", savedWard);
               }
            }

         } catch (err) {
            console.error('❌ Lỗi load phường:', err);
            wardSelect.innerHTML = '<option value="">-- Lỗi tải phường --</option>';
         }
      });

      // ===== Nếu có quận mặc định thì trigger change để load phường =====
      if (normalizedDistrict) {
         districtSelect.dispatchEvent(new Event('change'));
      }

   } catch (error) {
      console.error('❌ Lỗi tải danh sách quận/phường:', error);
      districtSelect.innerHTML = '<option value="">-- Lỗi tải dữ liệu --</option>';
   }
}

// Gọi khi trang load
document.addEventListener('DOMContentLoaded', () => {
   loadDistricts();
});


// ========== VALIDATE ==========
function validateForm() {
   document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

   const name = document.getElementById('name').value.trim();
   const dob = document.getElementById('dob').value;
   const className = document.getElementById('classList').value;
   const email = document.getElementById('email').value.trim();
   const phone = document.getElementById('phone').value.trim();
   const parentPhone = document.getElementById('parent_phone').value.trim();
   const cccd = document.getElementById('cccd').value.trim();
   const avatar = document.getElementById('fileInput').files[0];

   let isValid = true;
   const phoneRegex = /^(0[0-9]{9})$/;
   const nameRegex = /^[A-Za-zÀ-ỹ\s-]+$/u;

   // ==== HỌ TÊN ====
   if (!name || !nameRegex.test(name)) {
      document.getElementById('error-name').textContent = "Họ tên không hợp lệ.";
      isValid = false;
   }

   // ==== NGÀY SINH ====
   if (!dob) {
      document.getElementById('error-dob').textContent = "Vui lòng nhập ngày sinh.";
      isValid = false;
   } else {
      const year = new Date(dob).getFullYear();
      const currentYear = new Date().getFullYear();
      const age = currentYear - year;

      if (age < 15 || age > 18) {
         document.getElementById('error-dob').textContent = "Tuổi phải từ 15 đến 18.";
         isValid = false;
      }
   }

   // ==== LỚP ====
   if (!className) {
      document.getElementById('error-classList').textContent = "Chọn lớp.";
      isValid = false;
   }

   // ==== EMAIL ====
   if (email && !/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
      document.getElementById('error-email').textContent = "Email không hợp lệ.";
      isValid = false;
   }

   // ==== SĐT ====
   if (phone && !phoneRegex.test(phone)) {
      document.getElementById('error-phone').textContent = "SĐT học sinh sai định dạng.";
      isValid = false;
   }

   if (parentPhone && !phoneRegex.test(parentPhone)) {
      document.getElementById('error-parent-phone').textContent = "SĐT phụ huynh sai định dạng.";
      isValid = false;
   }

   // ==== CCCD ====
   if (cccd && !/^[0-9]{9,12}$/.test(cccd)) {
      document.getElementById('error-cccd').textContent = "CCCD phải 9–12 chữ số.";
      isValid = false;
   }

   // ==== ẢNH ====
   if (avatar && !['image/jpeg', 'image/png', 'image/jpg'].includes(avatar.type)) {
      document.getElementById('error-avatar').textContent = "Ảnh không hợp lệ.";
      isValid = false;
   }

   // ==== NGĂN SUBMIT ====
   if (!isValid) {
      Swal.fire({
         icon: 'error',
         title: 'Dữ liệu chưa hợp lệ!',
         text: 'Vui lòng kiểm tra lại các trường bị lỗi trước khi gửi.',
         confirmButtonText: 'OK',
         confirmButtonColor: '#dc3545'
      });
      return false; // 🔥 quan trọng: NGĂN form gửi đi
   }

   return true; // cho phép submit
}

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
