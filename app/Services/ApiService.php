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
        ])->get($this->baseUrl . '/users?role=hoc_sinh&sort=asc');

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
    public function createStudentAccount($data)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->asJson()->post($this->baseUrl . '/users/admin-create', $data);
        if ($response->failed()) {
            \Log::error('API Error createStudentAccount', [
                'status' => $response->status(),
                'body' => $response->body(),
                'sent_data' => $data,
            ]);
        }
        return [
            'status' => $response->status(),
            'ok' => $response->successful(),
            'data' => $response->json(),
        ];
    }
    public function getStudentDetail($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . '/users/' . $id);

        // Nếu request thất bại (API lỗi, 401, 500, ...)
        if (!$response->successful()) {
            return [
                'error' => true,
                'message' => 'Không thể kết nối API. Mã lỗi: ' . $response->status(),
            ];
        }

        return $response->json();
    }
    public function updateStudent($id, $body)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->put("{$this->baseUrl}/users/update-user/{$id}", $body);

        return [
            'status' => $response->status(),
            'ok' => $response->successful(),
            'data' => $response->json(),
        ];
    }

    public function deleteUser($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->delete("{$this->baseUrl}/users/{$id}");

        return [
            'status' => $response->status(),
            'ok' => $response->successful(),
            'data' => $response->json(),
        ];
    }
    public function getBusDetail($id)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json',
        ])->get($this->baseUrl . '/xe/' . $id);

        // Nếu request thất bại (API lỗi, 401, 500, ...)
        if (!$response->successful()) {
            return [
                'error' => true,
                'message' => 'Không thể kết nối API. Mã lỗi: ' . $response->status(),
            ];
        }

        return $response->json();
    }
    public function addStudentsToBus($xeId, array $hocSinhIds)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json', // nếu API yêu cầu
            ])->post($this->baseUrl . "/xe/{$xeId}/add-hocsinh", [
                'hocSinhIds' => $hocSinhIds, // gửi mảng nhiều ID
            ]);

            return $response->json();
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
    public function removeStudentFromBus($xeId, $hocSinhId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ])->delete("{$this->baseUrl}/xe/{$xeId}/remove-hocsinh/{$hocSinhId}");

            if ($response->failed()) {
                return [
                    'error' => true,
                    'message' => 'Không thể xoá học sinh khỏi xe. Mã lỗi: ' . $response->status(),
                    'data' => $response->json(),
                ];
            }

            $data = $response->json();

            return [
                'error' => false,
                'message' => $data['message'] ?? 'Xoá học sinh khỏi xe thành công',
                'xe' => $data['xe'] ?? null,
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Lỗi khi gọi API: ' . $e->getMessage(),
            ];
        }
    }
    public function createBus($data)
    {
        $token = session('access_token');
        $response = Http::withToken($token)
            ->post($this->baseUrl . '/xe', $data);

        if ($response->successful()) {
            return $response->json();
        }

        return [
            'error' => true,
            'message' => $response->json()['message'] ?? 'Không thể thêm xe mới',
        ];
    }

}
