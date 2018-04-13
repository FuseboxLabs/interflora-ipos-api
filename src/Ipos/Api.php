<?php

namespace Interflora\Ipos;

use GuzzleHttp\Client;

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
   * IposApi constructor.
   */
  public function __construct($url, $authenticationUrl, $username = '', $password = '') {
    if ($username && $password) {
      $this->username = $username;
      $this->password = $password;
    }
    $this->baseAuthenticationUri = $authenticationUrl;

    $clientArgs = [
      'base_uri' => $url,
    ];
    $this->client = new Client($clientArgs);
  }


  /**
   * Get the headers for a request.
   *
   * @return array
   *   An array with relevant header information.
   */
  protected function getHeaders() {
    $heasers = [
      'Accept' => 'application/json',
      'Content-Type'  => 'application/json; charset=UTF-8',
    ];
    if ($this->username && $this->password) {
      $heasers['Authorization'] = sprintf('Bearer %s', $this->getToken()),
    }

    return $heasers;
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
  public function sendOrder($data, $path = ApiPath::ORDER_PATH) {
    try {
      $response = $this->client->post($this->baseUri . $path, [
        'json' => $data,
        'headers' => $this->getHeaders(),
        'debug' => true,
      ]);

      return [
        'code' => 200,
        'body' => $response->getBody(),
      ];
    }
    catch (\Exception $e) {
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
  public function sendOrderQueue($data) {
    $this->sendOrder($data, ApiPath::ORDER_QUEUE_PATH);
  }

  /**
   * Get authorization token.
   *
   * @return string
   *    Token.
   */
  public function getToken() {
    $credentials = [
      'form_params' => [
        '_username' => $this->username,
        '_password' => $this->password
      ]
    ];
    $client = new Client(['base_uri' => $this->baseAuthenticationUri]);
    $response = $client->post(ApiPath::LOGIN_PATH, $credentials);
    return json_decode($response->getBody())->token;
  }

}