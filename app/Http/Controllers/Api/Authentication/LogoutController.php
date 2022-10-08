<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthenticationInterface;
use App\Services\Authentication;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    protected AuthenticationInterface $authentication;

    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    public function index(): JsonResponse
    {
        $this->authentication->apiLogout(Auth::user());
        return response()->json(['loggedOut' => true]);
    }
}
