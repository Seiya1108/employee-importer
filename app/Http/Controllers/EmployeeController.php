<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file, 'r');

        if (!$handle) {
            return response()->json(['message' => 'ファイルを開けませんでした。'], 500);
        }

        // ヘッダー読み飛ばし（Shift_JIS → UTF-8）
        $headerLine = fgets($handle);
        $headerLine = mb_convert_encoding($headerLine, 'UTF-8', 'SJIS-win');
        $header = str_getcsv($headerLine);

        // 既存のメール一覧（大量でも1回のクエリで取得）
        $existingEmails = Employee::pluck('email')->toArray();
        $existingEmailSet = array_flip($existingEmails); // in_array → isset で高速化

        $insertData = [];
        $now = Carbon::now();

        while (($line = fgets($handle)) !== false) {
            $line = mb_convert_encoding($line, 'UTF-8', 'SJIS-win');
            $data = str_getcsv($line);

            // カラム数チェック
            if (count($data) < 6) continue;

            $name          = $data[1];
            $email         = $data[2];
            $phone_number  = $data[3];
            $department_id = $data[4];
            $hire_date     = $data[5];

            if (isset($existingEmailSet[$email])) continue;

            $insertData[] = [
                'name'          => $name,
                'email'         => $email,
                'phone_number'  => $phone_number,
                'department_id' => $department_id,
                'hire_date'     => $hire_date,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        fclose($handle);

        if (!empty($insertData)) {
            // 一括INSERT（件数が多くてもOK）
            Employee::insert($insertData);
        }

        return response()->json([
            'message' => 'CSVがインポートされました（' . count($insertData) . '件）',
        ]);
    }
}