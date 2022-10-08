<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobilePaymentRequest;
use App\Services\Payment\Mobile\MPesaPayment;
use App\Services\Payment\Mobile\Payment;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
    protected Payment $payment;

    public function index(MobilePaymentRequest $request): JsonResponse
    {
        switch ($request->method) {
            case 'MPesa':
                $this->payment = new MPesaPayment();
                break;
                default:
                    return response()->json(['Invalid payment method.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transaction = $this->payment->charge($request->msisdn, $request->amount);

        dd($request->all());
    }
}
