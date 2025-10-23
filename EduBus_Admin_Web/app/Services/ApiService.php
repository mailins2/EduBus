<?php

namespace App\Services;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

class ApiService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = env('API_BASE_URL', 'https://qlbus.onrender.com/api');
        $this->token = Session::get('access_token'); 
    }
    public function login($email, $password){
        $response = Http::post("{$this->baseUrl}/auth/login", [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['accessToken'])) {
                Session::put('access_token', $data['accessToken']);
                Session::put('user', $data['user'] ?? null);
            }
            return $data;
        }

        return ['error' => 'Login failed'];
    }
    public function getStudents()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . '/users?role=hoc_sinh');

        // Nếu request thất bại (API lỗi, 401, 500, ...)
        if (!$response->successful()) {
            return [
                'error' => true,
                'message' => 'Không thể kết nối API. Mã lỗi: ' . $response->status(),
            ];
        }

        $data = $response->json();

        // Kiểm tra dữ liệu rỗng hoặc không có users
        if (empty($data['users']) || count($data['users']) === 0) {
            return [
                'error' => false,
                'message' => 'Không có học sinh nào trong hệ thống.',
                'users' => [],
            ];
        }

        // Nếu có dữ liệu
        return [
            'error' => false,
            'message' => $data['message'] ?? 'Lấy danh sách học sinh thành công.',
            'users' => $data['users'],
        ];
    }


    public function getDrivers()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . '/users?role=tai_xe');

        // Nếu request thất bại (API lỗi, 401, 500, ...)
        if (!$response->successful()) {
            return [
                'error' => true,
                'message' => 'Không thể kết nối API. Mã lỗi: ' . $response->status(),
            ];
        }

        $data = $response->json();

        // Kiểm tra dữ liệu rỗng hoặc không có users
        if (empty($data['users']) || count($data['users']) === 0) {
            return [
                'error' => false,
                'message' => 'Không có tài xế nào trong hệ thống.',
                'users' => [],
            ];
        }

        // Nếu có dữ liệu
        return [
            'error' => false,
            'message' => $data['message'] ?? 'Lấy danh sách tài xế thành công.',
            'users' => $data['users'],
        ];
    }

    public function getBuses()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . '/xe');

        // Nếu request thất bại (API lỗi, 401, 500, ...)
        if (!$response->successful()) {
            return [
                'error' => true,
                'message' => 'Không thể kết nối API. Mã lỗi: ' . $response->status(),
            ];
        }

        return $response->json();
    }
}
