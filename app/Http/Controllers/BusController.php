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
    public function index(ApiService $api)
    {
        $buses = $api->getBuses();
        return view('busline.bus-list', compact('buses'));
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
                return !isset($driver['tai_xe_info']['bienso']);
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


}
