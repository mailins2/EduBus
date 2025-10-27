<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;

class StudentController extends Controller
{
    public function index(ApiService $api)
    {
        $users = $api->getStudents();
        return view('users.students.student-list', compact('users'));
    }

    public function add()
    {
        return view('users.students.add-student');
    }

    // ✅ Hàm mới thêm để xử lý submit form
    public function store(Request $request, ApiService $api)
    {
        // --- 1️⃣ Validate dữ liệu đầu vào ---
        $validated = $request->validate([
            'email' => 'required|email',
            'hoten' => 'required|string',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|string',
            'sdt' => 'required|string',
            'address' => 'required|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'cccd' => 'nullable|string',
            'mahs' => 'required|string',
            'lop' => 'required|string',
            'phu_huynh_hoten' => 'required|string',
            'phu_huynh_sdt' => 'required|string',
            'quanhe' => 'required|string',
            'diadiem_don_tra' => 'nullable|string',
        ]);

        // --- 2️⃣ Ghép địa chỉ ---
        $fullAddress = "{$validated['address']}, {$validated['ward']}, {$validated['district']}, TP.HCM";

        // --- 4️⃣ Xử lý ảnh đại diện (nếu có) ---
        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $avatarUrl = asset('storage/' . $path);
        }

        // --- 5️⃣ Chuẩn bị dữ liệu gửi API ---
        $body = [
            'email' => $validated['email'],
            'role' => 'hoc_sinh',
            'profile' => [
                'hoten' => $validated['hoten'],
                'ngaysinh' => $validated['ngaysinh'],
                'gioitinh' => $validated['gioitinh'],
                'sdt' => $validated['sdt'],
                'diachi' => $fullAddress,
                'cccd' => $validated['cccd'] ?? '',
                'avatar' => $avatarUrl,
            ],
            'hoc_sinh_info' => [
                'mahs' => $validated['mahs'],
                'lop' => $validated['lop'],
                'phu_huynh' => [
                    'hoten' => $validated['phu_huynh_hoten'],
                    'sdt' => $validated['phu_huynh_sdt'],
                    'quanhe' => $validated['quanhe'],
                ],
                'diadiem_don_tra' => $validated['diadiem_don_tra'] ?? 'Chưa cập nhật',
                'state' => 'done',
                'state_time' => now()->toISOString(),
            ],
        ];

        // --- 6️⃣ Gọi API tạo học sinh ---
        try {
            $response = $api->createStudentAccount($body);
            \Log::info('Response from createStudentAccount:', $response);

            if ($response['ok'] && isset($response['data']['message'])) {
                // ✅ Thành công
                return redirect()
                    ->route('student-list.')
                    ->with('success', '✅ ' . $response['data']['message']);
            }

            // ❌ Nếu thất bại
            $errorMsg = $response['data']['message'] ?? 'Không thể tạo học sinh. Vui lòng thử lại.';
            return back()->withErrors(['error' => '❌ ' . $errorMsg]);

        } catch (\Exception $e) {
            // 🚨 Lỗi kết nối hoặc lỗi HTTP
            return back()->withErrors(['error' => '🚨 Lỗi API: ' . $e->getMessage()]);
        }
    }
    public function detail($id,ApiService $api){
        $student = $api->getStudentDetail($id);
        return view('users.students.student-detail',compact('student'));
    }
    public function adjust($id,ApiService $api){
        $student = $api->getStudentDetail($id);
        return view('users.students.adjust-student',compact('student'));
    }
    public function update($id, Request $request, ApiService $api)
    {
        // --- 1️⃣ Validate dữ liệu ---
        $validated = $request->validate([
            'email' => 'nullable|email',
            'hoten' => 'required|string',
            'ngaysinh' => 'required|date',
            'gioitinh' => 'required|string',
            'sdt' => 'required|string',
            'address' => 'required|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'cccd' => 'nullable|string',
            'lop' => 'required|string',
            'phu_huynh_hoten' => 'required|string',
            'phu_huynh_sdt' => 'required|string',
            'quanhe' => 'required|string',
            'diadiem_don_tra' => 'nullable|string',
        ]);

        $fullAddress = "{$validated['address']}, {$validated['ward']}, {$validated['district']}, TP.HCM";

        // --- 2️⃣ Upload ảnh (nếu có) ---
        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $avatarUrl = asset('storage/' . $path);
        } else {
            $avatarUrl = $request->input('old_avatar');
        }

        // --- 3️⃣ Gửi dữ liệu lên API ---
        $body = [
            'profile' => [
                'hoten' => $validated['hoten'],
                'ngaysinh' => $validated['ngaysinh'],
                'gioitinh' => $validated['gioitinh'],
                'sdt' => $validated['sdt'],
                'diachi' => $fullAddress,
                'cccd' => $validated['cccd'] ?? '',
                'avatar' => $avatarUrl,
            ],
            'hoc_sinh_info' => [
                'lop' => $validated['lop'],
                'phu_huynh' => [
                    'hoten' => $validated['phu_huynh_hoten'],
                    'sdt' => $validated['phu_huynh_sdt'],
                    'quanhe' => $validated['quanhe'],
                ],
                'diadiem_don_tra' => $validated['diadiem_don_tra'] ?? ''
            ],
        ];

        try {
            $response = $api->updateStudent($id, $body); // ✅ gọi service

            if ($response['ok']) {
                return redirect()
                    ->route('student-list.')
                    ->with('success', $response['data']['message'] ?? 'Cập nhật học sinh thành công!');
            } else {
                $errorMessage = $response['data']['message'] ?? 'Không thể cập nhật học sinh.';
                return back()->withErrors(['error' => $errorMessage]);
            }

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Lỗi API: ' . $e->getMessage()]);
        }
    }
    public function destroy($id, ApiService $api)
    {
        try {
            $result = $api->deleteUser($id);

            if (!empty($result['ok']) || !empty($result['success'])) {
                return redirect()->back()->with('success', $result['data']['message'] ?? 'Đã xóa học sinh thành công!');
            } else {
                return redirect()->back()->with('error', $result['data']['message'] ?? 'Không thể xóa học sinh!');
            }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi hệ thống hoặc API: ' . $e->getMessage());
        }
    }

}
