<?php

namespace App\Http\Controllers;
use App\Services\ApiService;
use Illuminate\Http\Request;

class BusController extends Controller{
    protected $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }
    public function index(Request $request, ApiService $api)
    {
        // Lấy dữ liệu từ API
        $result = $api->getBuses();

        // Nếu API lỗi → gửi view rỗng + thông báo lỗi
        if (!empty($result['error']) && $result['error'] === true) {
            return view('busline.bus-list', [
                'buses' => [],
                'pages' => 0,
                'currentPage' => 1,
                'message' => $result['message']
            ]);
        }

        // Lấy danh sách user (luôn là array)
        $buses = $result['dsXe'] ?? [];

        // PHÂN TRANG
        $perPage = 10;
        $total = count($buses);
        $pages = ceil($total / $perPage);

        // Lấy page hiện tại
        $currentPage = max(1, (int)$request->query('page', 1));

        // Cắt dữ liệu theo trang
        $offset = ($currentPage - 1) * $perPage;
        $usersPage = array_slice($buses, $offset, $perPage);

        return view('busline.bus-list', [
            'buses' => $usersPage,       // chỉ gửi 10 bản ghi
            'pages' => $pages,
            'currentPage' => $currentPage,
            'message' => $result['message'] ?? null
        ]);
    }
    public function add(ApiService $api)
    {
        // Lấy tất cả tài xế từ API
        $allDrivers = $api->getDrivers();

        // Nếu API lỗi, set rỗng
        $drivers = [];
        if (!$allDrivers['error'] && !empty($allDrivers['users'])) {
            // Lọc những tài xế chưa có xe (tai_xe_info.bienso không tồn tại)
            $drivers = array_filter($allDrivers['users'], function($driver) {
                return !isset($driver['tai_xe_info']['xe_id']);
            });
        }

        return view('busline.add-bus', compact('drivers'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bienso' => 'required|string',
            'suc_chua' => 'required|integer|min:1',
            'tuyen' => 'required|string',
            'taixe_id' => 'required|string',
        ]);

        $api = app(\App\Services\ApiService::class);
        $result = $this->apiService->createBus($validated);

        if (!isset($result['error'])) {
            return redirect()
                ->route('bus-list.add-bus')
                ->with('success', 'Thêm xe mới thành công!');
        }

        return back()->withErrors(['error' => 'Không thể thêm xe, vui lòng thử lại!']);
    }
    public function detail($id, ApiService $api)
    {
        $bus = $api->getBusDetail($id);
        $allStudents = $api->getStudents();
        $students = [];

        if (isset($allStudents['users']) && is_array($allStudents['users'])) {
            // Lọc những học sinh chưa có xe
            $students = array_values(array_filter($allStudents['users'], function ($stu) {
                return empty($stu['hoc_sinh_info']['xe_id']);
            }));
        }

        return view('busline.bus-detail', compact('bus', 'students'));
    }

    public function addStudents(Request $request, $xeId)
    {
        $hocSinhIds = $request->input('hocSinhIds', []);

        if (empty($hocSinhIds)) {
            return response()->json(['success' => false, 'message' => 'Không có học sinh được chọn']);
        }

        $result = $this->apiService->addStudentsToBus($xeId, $hocSinhIds);

        if (!empty($result['success'])) {
            return response()->json(['success' => true, 'message' => 'Thêm học sinh thành công!']);
        }

        return response()->json(['success' => false, 'message' => $result['message'] ?? 'Lỗi khi thêm học sinh']);
    }
    public function removeStudent($xeId, $hocSinhId)
    {
        try {
            $result = $this->apiService->removeStudentFromBus($xeId, $hocSinhId);

            if ($result['error']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Không thể xoá học sinh khỏi xe',
                    'data' => $result['data'] ?? null,
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message'] ?? 'Xoá học sinh khỏi xe thành công',
                'xe' => $result['xe'] ?? null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function destroy($id)
    {
        $result = $this->apiService->deleteBus($id);

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message']
        ]);
    }
    public function delete($id, ApiService $api)
    {
        try {
            // Gọi API xóa xe
            $result = $api->deleteBus($id);

            if (isset($result['message']) && str_contains($result['message'], 'thành công')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Xóa xe thành công!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Không thể xóa xe!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
            ]);
        }
    }
    public function adjust($id,ApiService $api){
        $bus = $api->getBusDetail($id);
        $allDrivers = $api->getDrivers();

        // Nếu API lỗi, set rỗng
        $drivers = [];
        if (!$allDrivers['error'] && !empty($allDrivers['users'])) {
            // Lọc những tài xế chưa có xe (tai_xe_info.bienso không tồn tại)
            $drivers = array_filter($allDrivers['users'], function($driver) {
                return !isset($driver['tai_xe_info']['xe_id']);
            });
        }
        return view('busline.adjust-bus',compact('bus','drivers'));
    }
    public function update($id, Request $request, ApiService $api)
    {
        $validated = $request->validate([
            'bienso' => 'required|string',
            'tuyen' => 'required|string',
            'taixe_id' => 'required|string',
        ]);

        $body = [
            'bienso' => $validated['bienso'],
            'tuyen' => $validated['tuyen'],
            'taixe_id' => $validated['taixe_id'],
        ];

        try {
            $response = $api->updateBus($id, $body);

            if (isset($response['ok']) && $response['ok'] === true) {
                // ✅ Lưu thông báo thành công
                return back()->with('success', $response['data']['message'] ?? 'Cập nhật xe thành công!');
            }

            $errorMessage = $response['data']['message']
                ?? $response['message']
                ?? $response['error']
                ?? 'Không thể cập nhật xe.';

            return back()->withErrors(['error' => $errorMessage]);

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Lỗi API: ' . $e->getMessage()]);
        }
    }

}
