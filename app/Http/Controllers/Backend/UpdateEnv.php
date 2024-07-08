<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Support\Facades\Artisan;

class UpdateEnv
{
    public static function setEnv($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            // Lấy nội dung file .env
            $env = file_get_contents($path);

            // Kiểm tra xem key có tồn tại hay không
            if (strpos($env, $key) !== false) {
                // Key tồn tại, cập nhật giá trị
                $env = preg_replace('/^' . $key . '=.*/m', $key . '=' . $value, $env);
            } else {
                // Key không tồn tại, thêm mới
                $env .= "\n" . $key . '=' . $value;
            }

            // Lưu lại file .env
            file_put_contents($path, $env);

            // Xóa cache cấu hình để đảm bảo các thay đổi có hiệu lực
            \Artisan::call('config:clear');
        }
    }
}
