<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Interfaces\AccountsInterface;
use App\Services\Accounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    protected AccountsInterface $accounts;

    public function __construct(Accounts $accounts)
    {
        $this->accounts = $accounts;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->accounts->accounts());
    }

    public function store(AccountRequest $request): JsonResponse
    {
        return response()->json(
            $this->accounts->create($request->firstname, $request->lastname, $request->email, $request->password)
        );
    }
}
