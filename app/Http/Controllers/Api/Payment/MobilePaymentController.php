<?php

namespace App\Http\Controllers\Api\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobilePaymentRequest;
use App\Services\Payment\Mobile\MPesaPayment;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MobilePaymentController extends Controller
{
    /**
     * @var MPesaPayment $mpesaPayment
     */
    protected MPesaPayment $mpesaPayment;

    public function __construct(MPesaPayment $mpesaPayment)
    {
        $this->mpesaPayment = $mpesaPayment;
    }

    public function store(MobilePaymentRequest $request)
    {
        //MPesa::fake();

        return match (strtolower($request->method)) {
            'mpesa' => $this->mpesaPayment($request),
            default => response()->json(['message' => 'Invalid payment type'], Response::HTTP_UNPROCESSABLE_ENTITY),
        };
    }

    protected function mpesaPayment(MobilePaymentRequest $request): JsonResponse
    {
        try {
            return response()->json($this->mpesaPayment->charge($request->msisdn, $request->amount, Auth::user()));
        } catch (ClientException $exception) {
            if (! ($response = $exception->getResponse()->getBody()->getContents())) {
                return response()->json(['message' => 'Something went wrong please try again'], $exception->getCode());
            }
            return response()->json(['message' => json_decode($response, true)['output_ResponseDesc']], $exception->getCode());
        }
    }
}
