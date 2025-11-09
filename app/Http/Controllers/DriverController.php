<?php

namespace App\Http\Controllers;
use App\Services\ApiService;
use Illuminate\Http\Request;

class DriverController extends Controller{
    public function index(Request $request, ApiService $api)
    {
        // Lấy dữ liệu từ API
        $result = $api->getDrivers();

        // Nếu API lỗi → gửi view rỗng + thông báo lỗi
        if (!empty($result['error']) && $result['error'] === true) {
            return view('users.drivers.drivers-list', [
                'users' => [],
                'pages' => 0,
                'currentPage' => 1,
                'message' => $result['message']
            ]);
        }

        // Lấy danh sách user (luôn là array)
        $users = $result['users'] ?? [];

        // PHÂN TRANG
        $perPage = 10;
        $total = count($users);
        $pages = ceil($total / $perPage);

        // Lấy page hiện tại
        $currentPage = max(1, (int)$request->query('page', 1));

        // Cắt dữ liệu theo trang
        $offset = ($currentPage - 1) * $perPage;
        $usersPage = array_slice($users, $offset, $perPage);

        return view('users.drivers.driver-list', [
            'users' => $usersPage,       // chỉ gửi 10 bản ghi
            'pages' => $pages,
            'currentPage' => $currentPage,
            'message' => $result['message'] ?? null
        ]);
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
            'mabanglai' => 'required|string',
            'avatar' => 'nullable|image|max:2048', // ✅ thêm validate cho ảnh
        ]);

        // --- 2️⃣ Ghép địa chỉ ---
        $fullAddress = "{$validated['address']}, {$validated['ward']}, {$validated['district']}, TP.HCM";

        // --- 3️⃣ Upload avatar qua API nếu có ---
        $avatarUrl = null;
        if ($request->hasFile('avatar')) {
            $uploadResult = $api->uploadAvatar($request->file('avatar'));

            if (!empty($uploadResult['error'])) {
                return back()->withErrors(['error' => 'Không thể upload ảnh: ' . ($uploadResult['message'] ?? 'Lỗi không xác định.')]);
            }

            // ✅ Lấy link ảnh Cloudinary từ API
            $avatarUrl = $uploadResult['avatar'] ?? null;
        }

        // --- 4️⃣ Chuẩn bị dữ liệu gửi API ---
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
                'avatar' => $avatarUrl, // ✅ gán link thực từ API
            ],
            'tai_xe_info' => [
                'mabanglai' => $validated['mabanglai'],
            ],
        ];

        // --- 5️⃣ Gọi API tạo tài xế ---
        try {
            $response = $api->createStudentAccount($body); // ⚠️ tên hàm này vẫn là createStudentAccount
            \Log::info('Response from createDriverAccount:', $response);

            if ($response['ok'] && isset($response['data']['message'])) {
                return redirect()
                    ->route('driver-list.')
                    ->with('success', '✅ ' . $response['data']['message']);
            }

            $errorMsg = $response['data']['message'] ?? 'Không thể tạo tài xế. Vui lòng thử lại.';
            return back()->withErrors(['error' => '❌ ' . $errorMsg]);
        } catch (\Exception $e) {
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
