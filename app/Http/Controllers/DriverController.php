<?php

namespace App\Http\Controllers;
use App\Services\ApiService;
use Illuminate\Http\Request;

class DriverController extends Controller{
    public function index(ApiService $api)
    {
        $users = $api->getDrivers();
        return view('users.drivers.driver-list', compact('users'));
    }
    public function add()
    {
        return view('users.drivers.add-driver');
    }
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
            'mabanglai' => 'required|string'
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
            'role' => 'tai_xe',
            'profile' => [
                'hoten' => $validated['hoten'],
                'ngaysinh' => $validated['ngaysinh'],
                'gioitinh' => $validated['gioitinh'],
                'sdt' => $validated['sdt'],
                'diachi' => $fullAddress,
                'cccd' => $validated['cccd'] ?? '',
                'avatar' => $avatarUrl,
            ],
            'tai_xe_info' => [
                'mabanglai' => $validated['mabanglai'],
            ],
        ];

        // --- 6️⃣ Gọi API tạo học sinh ---
        try {
            $response = $api->createStudentAccount($body);
            \Log::info('Response from createStudentAccount:', $response);

            if ($response['ok'] && isset($response['data']['message'])) {
                // ✅ Thành công
                return redirect()
                    ->route('driver-list.')
                    ->with('success', '✅ ' . $response['data']['message']);
            }

            // ❌ Nếu thất bại
            $errorMsg = $response['data']['message'] ?? 'Không thể tạo tài xế. Vui lòng thử lại.';
            return back()->withErrors(['error' => '❌ ' . $errorMsg]);

        } catch (\Exception $e) {
            // 🚨 Lỗi kết nối hoặc lỗi HTTP
            return back()->withErrors(['error' => '🚨 Lỗi API: ' . $e->getMessage()]);
        }
    }
    public function detail($id,ApiService $api){
        $student = $api->getStudentDetail($id);
        return view('users.drivers.driver-detail',compact('student'));
    }
    public function adjust($id,ApiService $api){
        $student = $api->getStudentDetail($id);
        return view('users.drivers.adjust-driver',compact('student'));
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
            'mabanglai' => 'required|string'
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
            'tai_xe_info' => [
                'mabanglai' => $validated['mabanglai'],
            ],
        ];

        try {
            $response = $api->updateStudent($id, $body); // ✅ gọi service

            if ($response['ok']) {
                return redirect()
                    ->route('driver-list.')
                    ->with('success', $response['data']['message'] ?? 'Cập nhật tài xế thành công!');
            } else {
                $errorMessage = $response['data']['message'] ?? 'Không thể cập nhật tài xế.';
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
