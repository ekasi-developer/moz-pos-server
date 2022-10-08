<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Interfaces\AuthenticationInterface;
use App\Services\Authentication;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * @var AuthenticationInterface
     */
    protected AuthenticationInterface $authentication;

    /**
     * @param Authentication $authentication
     */
    public function __construct(Authentication $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * Check user credentials and return a token.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function index(LoginRequest $request): JsonResponse
    {
        if (is_null($token = $this->authentication->apiLogin($request->email, $request->password)))
        {
            return response()->json([
                'message' => 'Invalid credentials please try again.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        return response()->json($token);
    }
}
