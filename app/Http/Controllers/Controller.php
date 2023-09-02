<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getFiltrationAttributes(Request $request, int $user_id = null): array
    {
        return [
            'user_id' => $user_id,
            'type' => $request->type,
            'location' => $request->location,
            'number_of_rooms' => $request->number_of_rooms,
            'number_of_bathrooms' => $request->number_of_bathrooms,
            'area' => $request->area,
        ];
    }

    protected function checkPassword(string $password): bool
    {
        return Hash::check(request()->password, $password);
    }
}
