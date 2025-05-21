<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($data = null, $message = 'İşlem başarılı', $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function error($message = 'Bir hata oluştu', $code = 400, $data = null)
    {
        return response()->json([
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public function paginated($paginator, $message = 'Veriler listelendi')
    {
        return response()->json([
            'message' => $message,
            'data'    => $paginator->items(),
            'meta'    => [
                'current_page' => $paginator->currentPage(),
                'last_page'    => $paginator->lastPage(),
                'total'        => $paginator->total(),
                'per_page'     => $paginator->perPage(),
            ],
        ]);
    }

    public function validationError($errors, $message = 'Doğrulama hatası')
    {
        return response()->json([
            'message' => $message,
            'errors'  => $errors,
        ], 422);
    }
}
