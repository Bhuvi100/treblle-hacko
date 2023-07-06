<?php

namespace App\Http\Controllers\v1\Admin;

use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function show()
    {
        return new UserResource(auth()->user());
    }
}
