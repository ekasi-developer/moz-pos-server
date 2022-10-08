<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Payment\Mobile\MPesaPayment;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    protected MPesaPayment $mpesaPayment;

    public function __construct(MPesaPayment $mpesaPayment)
    {
        $this->mpesaPayment = $mpesaPayment;
    }

    public function index(): JsonResponse
    {
        $transactions = Transaction::query()
            ->orderBy('id', 'DESC')
            ->get();
        return response()->json($transactions);
    }

    public function show(Transaction $transaction): JsonResponse
    {
        return response()->json($transaction);
    }

    public function destroy(Transaction $transaction): JsonResponse
    {
        switch (strtolower($transaction->method)) {
            case 'mpesa':
                return $this->reversePayment($transaction);
        }

        return response()->json($transaction);
    }

    private function reversePayment(Transaction $transaction): JsonResponse
    {
        try {
            return response()->json($this->mpesaPayment->reverse($transaction, Auth::user()));
        } catch (ClientException $exception) {
            if (! ($response = $exception->getResponse()->getBody()->getContents())) {
                return response()->json(['message' => 'Something went wrong please try again'], $exception->getCode());
            }
            return response()->json(['message' => json_decode($response, true)['output_ResponseDesc']], $exception->getCode());
        }
    }
}
