<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class Helper
{
    static public function formatPaginate(LengthAwarePaginator $paginage)
    {
        return [
            'current_page' => $paginage->currentPage(),
            'data' => $paginage->items(),
            'total' => $paginage->total(),
        ];
    }

    static public function deleteFile($path)
    {
        if (is_file($path)) {
            unlink($path);
        }
    }
}
