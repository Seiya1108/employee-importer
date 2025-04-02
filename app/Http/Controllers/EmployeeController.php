<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file, 'r');

        // ヘッダー行を読み込み、文字コード変換
        $headerLine = fgets($handle);
        $headerLine = mb_convert_encoding($headerLine, 'UTF-8', 'SJIS-win');
        $header = str_getcsv($headerLine);

        // 各行を1行ずつ処理
        while (($line = fgets($handle)) !== false) {
            // Shift_JIS から UTF-8 へ変換
            $line = mb_convert_encoding($line, 'UTF-8', 'SJIS-win');
            $data = str_getcsv($line);

            // 必要なカラム数が揃っていない場合はスキップ
            if (count($data) < 6) {
                continue;
            }
            
            // CSVのカラム順：id, name, email, phone_number, department_id, hire_date, created_at, updated_at
            // id, created_at, updated_atはDB側で自動管理されるため、1列目はスキップ
            $name          = $data[1];
            $email         = $data[2];
            $phone_number  = $data[3];
            $department_id = $data[4];
            $hire_date     = $data[5];

            // 重複チェック（emailが既に存在する場合はスキップ）
            if (Employee::where('email', $email)->exists()) {
                continue;
            }

            Employee::create([
                'name'          => $name,
                'email'         => $email,
                'phone_number'  => $phone_number,
                'department_id' => $department_id,
                'hire_date'     => $hire_date,
            ]);
        }

        fclose($handle);

        return response()->json(['message' => 'CSVがインポート出来ました！']);
    }
}