<?php

namespace Bluteki\MPesa;

use Bluteki\MPesa\Contracts\MPesaContract;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\StreamInterface;

class Request implements MPesaContract
{
    /**
     * @var string $host
     */
    protected string $host;

    /**
     * @var string $origin
     */
    protected string $origin;

    /**
     * @var string
     */
    protected string $token;

    /**
     * @var string $serviceProviderCode
     */
    protected string $serviceProviderCode;

    /**
     * @var string $initiatorIdentifier
     */
    protected string $initiatorIdentifier;

    /**
     * @var string $securityCredential
     */
    protected string $securityCredential;

    /**
     * @var bool $fake
     */
    protected bool $fake;

    /**
     * @var int $code
     */
    protected int $responseCode;

    /**
     * @var string $status
     */
    protected string $responseStatus;

    public function __construct(
        string $host,
        string $origin,
        string $token,
        string $serviceProviderCode,
        string $initiatorIdentifier,
        string $securityCredential)
    {
        $this->host = $host;
        $this->origin = $origin;
        $this->token = $token;
        $this->serviceProviderCode = $serviceProviderCode;
        $this->initiatorIdentifier = $initiatorIdentifier;
        $this->securityCredential = $securityCredential;
    }

    /**
     * @param bool $fake
     * @param int $code
     * @param string $status
     * @return MPesaContract
     */
    public function setFake(bool $fake, int $code, string $status): MPesaContract
    {
        $this->fake = $fake;
        $this->responseCode = $code;
        $this->responseStatus = $status;
        return $this;
    }

    /**
     * Initiates a customer to business (c2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param $thirdPartyReference
     * @return Transaction
     * @throws Exception|GuzzleException
     */
    public function c2b(float $amount, string $msisdn, string $transactionReference, $thirdPartyReference): Transaction
    {
        $data = [
            "input_TransactionReference" => $transactionReference,
            "input_CustomerMSISDN" => $msisdn,
            "input_Amount" => $amount,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $this->serviceProviderCode
        ];

        dd($data);

        $client = $this->request('18352', $data);

        $request = new \GuzzleHttp\Psr7\Request('POST', '/ipg/v1x/c2bPayment/singleStage/', [
            'Content-Type' => 'application/json',
            'origin' => $this->origin,
            'Authorization' => 'Bearer ' . $this->token,
        ], json_encode($data));

        $response = $client->send($request);

        return new Transaction($this->streamToArray($response->getBody()));
    }

    /**
     * Initiates a customer to business (b2b) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param $thirdPartyReference
     * @return Transaction
     * @throws Exception|GuzzleException
     */
    public function b2b(float $amount, string $msisdn, string $transactionReference, $thirdPartyReference): Transaction
    {
        $data = [
            "input_TransactionReference" => $transactionReference,
            "input_CustomerMSISDN" => $msisdn,
            "input_Amount" => $amount,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $this->serviceProviderCode
        ];

        $client = $this->request('18349', $data);

        $request = new \GuzzleHttp\Psr7\Request('POST', '/ipg/v1x/b2bPayment/', [
            'Content-Type' => 'application/json',
            'origin' => $this->origin,
            'Authorization' => 'Bearer ' . $this->token,
        ], json_encode($data));

        $response = $client->send($request);

        return new Transaction($this->streamToArray($response->getBody()));
    }

    /**
     * Initiates a business to business (b2c) transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $msisdn
     * @param string $transactionReference
     * @param $thirdPartyReference
     * @return Transaction
     * @throws Exception|GuzzleException
     */
    public function b2c(float $amount, string $msisdn, string $transactionReference, $thirdPartyReference): Transaction
    {
        $data = [
            "input_TransactionReference" => $transactionReference,
            "input_CustomerMSISDN" => $msisdn,
            "input_Amount" => $amount,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $this->serviceProviderCode
        ];

        $client = $this->request('18345', $data);

        $request = new \GuzzleHttp\Psr7\Request('POST', '/ipg/v1x/b2cPayment/', [
            'Content-Type' => 'application/json',
            'origin' => $this->origin,
            'Authorization' => 'Bearer ' . $this->token,
        ], json_encode($data));

        $response = $client->send($request);

        return new Transaction($this->streamToArray($response->getBody()));
    }

    /**
     * Initiates a reversal transaction on the M-Pesa API.
     *
     * @param float $amount
     * @param string $transactionID
     * @param string $thirdPartyReference
     * @return Transaction
     * @throws Exception|GuzzleException
     */
    public function reversal(float $amount, string $transactionID, string $thirdPartyReference): Transaction
    {
        $data = [
            'input_Amount' => $amount,
            'input_TransactionID' => $transactionID,
            'input_ThirdPartyReference' => $thirdPartyReference,
            'input_ServiceProviderCode' => $this->serviceProviderCode,
            'input_InitiatorIdentifier' => $this->initiatorIdentifier,
            'input_SecurityCredential' => $this->securityCredential,
        ];

        $client = $this->request('18354', $data);

        $request = new \GuzzleHttp\Psr7\Request('PUT', '/ipg/v1x/reversal/', [
            'Content-Type' => 'application/json',
            'origin' => $this->origin,
            'Authorization' => 'Bearer ' . $this->token,
        ], json_encode($data));

        $response = $client->send($request);

        return new Transaction($this->streamToArray($response->getBody()));
    }

    /**
     * Get transaction in M-Pesa API.
     *
     * @param string $transactionReference
     * @param string $thirdPartyReference
     * @return Transaction
     * @throws Exception|GuzzleException
     */
    public function transaction(string $transactionReference, string $thirdPartyReference): Transaction
    {
        $data = [
            "input_QueryReference" => $transactionReference,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $this->serviceProviderCode,
        ];

        $client = $this->request('18353', $data);

        $request = new \GuzzleHttp\Psr7\Request('GET', '/ipg/v1x/queryTransactionStatus/?' . http_build_query($data), [
            'Content-Type' => 'application/json',
            'origin' => $this->origin,
            'Authorization' => 'Bearer ' . $this->token
        ]);

        $response = $client->send($request);

        return new Transaction($this->streamToArray($response->getBody()));
    }

    /**
     * Check if development request of testing.
     *
     * @param string $port
     * @param array $body
     * @return Client
     * @throws Exception
     */
    protected function request(string $port = '' ,array $body = []): Client
    {
        return $this->fake ? $this->developmentRequest($body) : $this->productionRequest($port);
    }

    /**
     * @param string $port
     * @return Client
     */
    protected function productionRequest(string $port = ''): Client
    {
        return new Client(['base_uri' => $this->host . ':' . $port]);
    }

    /**
     * @param array $data
     * @return Client
     * @throws Exception
     */
    protected function developmentRequest(array $data): Client
    {
        $mock = new MockHandler([
            new Response($this->responseCode, [
                'Content-Type' => 'application/json',
                'origin' => $this->origin
            ], $this->testResponseBody($data))
        ]);
        return new Client(['handler' => HandlerStack::create($mock)]);
    }

    /**
     * @param array $data
     * @return string
     * @throws Exception
     */
    protected function testResponseBody(array $data): string
    {
        $response = [
            'output_ResponseCode' => $this->responseCode,
            'output_ResponseDesc' => 'Successfully Accepted Request',
            'output_TransactionID' => bin2hex(random_bytes(16)),
            'output_ConversationID' => bin2hex(random_bytes(16)),
            'output_ThirdPartyReference' => $data['input_ThirdPartyReference'] ?? null,
        ];

        $response = !isset($data['input_QueryReference']) && empty($this->responseStatus)  ? $response : array_merge($response, [
            'output_ResponseTransactionStatus' => empty($this->responseStatus) ? 'Completed' : $this->responseStatus,
        ]);

        return json_encode($response);
    }

    /**
     * Convert guzzle stream to array.
     *
     * @param StreamInterface $stream
     * @return array
     */
    protected function streamToArray(StreamInterface $stream): array
    {
        return json_decode((string)$stream, true);
    }
}
