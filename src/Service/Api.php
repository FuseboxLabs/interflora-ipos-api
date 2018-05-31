<?php

namespace Interflora\IposApi\Service;

use GuzzleHttp\Client;
use Interflora\IposApi\Constant\ApiPath;

/**
 * Class Api.
 *
 * @package Drupal\interflora_ipos
 */
class Api
{

    /**
     * The http client.
     *
     * @var mixed
     */
    private $client;

    /**
     * Authentication service username.
     *
     * @var string
     */
    private $username = '';

    /**
     * Authentication service password.
     *
     * @var string
     */
    private $password = '';

    /**
     * Authentication service uri.
     *
     * @var string
     */
    private $baseAuthenticationUri;

    /**
     * @var boolean
     */
    private $debug;

    /**
     * IposApi constructor.
     */
    public function __construct($url, $authenticationUrl, $username = '', $password = '', $debug = FALSE)
    {
        if ($username && $password) {
            $this->username = $username;
            $this->password = $password;
        }
        $this->baseAuthenticationUri = $authenticationUrl;

        $clientArgs   = [
            'base_uri' => $url,
        ];
        $this->client = new Client($clientArgs);
        $this->debug = $debug;
    }

    /**
     * Get the headers for a request.
     *
     * @return array
     *   An array with relevant header information.
     */
    protected function getHeaders()
    {
        $headers = [
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json; charset=UTF-8',
        ];
        if ($this->username && $this->password) {
            $headers['Authorization'] = sprintf('Bearer %s', $this->getToken());
        }

        return $headers;
    }

    /**
     * Get options for a request.
     *
     * @param array $query
     *
     * @return array
     */
    protected function getOptions($query = []) {
        $options = [
            'headers' => $this->getHeaders(),
        ];
        if (!empty($query)) {
            $options['query'] = urldecode(http_build_query($query));
        }
        if ($this->debug) {
            $options['debug'] = $this->debug;
        }
        return $options;
    }

    /**
     * Get orders from core.
     *
     * @param string $path
     *   Path to the endpoint.
     * @param array $query
     *   Query parameters for the request.
     *
     * @return array
     *   Success.
     */
    public function getOrders($path = ApiPath::ORDER_PATH, $query = [])
    {
        try {
            $response = $this->client->get($path, $this->getOptions($query));
            return [
                'code' => 200,
                'body' => $response->getBody()->getContents(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send order data.
     *
     * @param string $data
     *   The transformed shipment data.
     * @param string $path
     *   Path to the endpoint.
     *
     * @return array
     *   Success.
     */
    public function sendOrder($data, $path = ApiPath::ORDER_PATH)
    {
        try {
            $options = $this->getOptions();
            $options['json'] = $data;
            $response = $this->client->post($path, $options);

            return [
                'code' => 200,
                'body' => $response->getBody(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send order data with a put request.
     *
     * @param string $data
     *   The transformed shipment data.
     * @param string $path
     *   Path to the endpoint.
     *
     * @return array
     *   Success.
     */
    public function putOrder($data, $path = ApiPath::ORDER_PATH)
    {
        try {
            $options = $this->getOptions();
            $options['json'] = $data;
            $response = $this->client->put($path, $options);

            return [
                'code' => 200,
                'body' => $response->getBody(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send order data with a put request.
     *
     * @param string $data
     *   The transformed shipment data.
     * @param string $path
     *   Path to the endpoint.
     *
     * @return array
     *   Success.
     */
    public function putCreditNote($data, $path = ApiPath::CREDIT_NOTE_PATH)
    {
        try {
            $options = $this->getOptions();
            $options['json'] = $data;
            $response = $this->client->put($path, $options);

            return [
                'code' => 200,
                'body' => $response->getBody(),
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update order state for existing order
     *
     * @param        $orderId
     * @param        $state
     * @param string $path
     * @return array
     */
    public function updateOrderState($orderId, $state, $path = ApiPath::ORDER_STATE_UPDATE_PATH)
    {
        try {
            $options = $this->getOptions();
            $options['json'] = $orderId;
            $response = $this->client->put($path . '/' . $state, $options);

            return [
                'code' => 200,
                'body' => $response->getBody(),
            ];

        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'body' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send order to queue endpoint.
     *
     * @param string $data
     *   The transformed shipment data.
     */
    public function sendOrderQueue($data)
    {
        return $this->sendOrder($data, ApiPath::ORDER_QUEUE_PATH);
    }

    /**
     * Get authorization token.
     *
     * @return string
     *    Token.
     */
    public function getToken()
    {
        $credentials = [
            'form_params' => [
                '_username' => $this->username,
                '_password' => $this->password
            ]
        ];
        $client      = new Client(['base_uri' => $this->baseAuthenticationUri]);
        $response    = $client->post(ApiPath::LOGIN_PATH, $credentials);

        return json_decode($response->getBody())->token;
    }

}
