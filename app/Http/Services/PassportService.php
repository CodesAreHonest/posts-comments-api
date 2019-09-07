<?php


namespace App\Http\Services;

use App\Exceptions\InternalServerErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;


class PassportService
{
    private $client;
    private $url;

    public function __construct() {
        $this->client = new Client();
        $this->url = env('APP_URL');
    }

    /**
     * Get Access and Refresh Token with given credentials.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $username
     * @param string $password
     * @param string $scope = ''
     *
     * @return mixed $response
     */
    public function getAccessAndRefreshToken (
        string $clientId, string $clientSecret, string $username,
        string $password, string $scope = ''
    ) {

        $url = "$this->url/oauth/token";

        $body = [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'username'      => $username,
                'password'      => $password,
                'scope'         => $scope
            ]
        ];

        try {
            $response = $this->client->post($url, $body);
            $contents = json_decode($response->getBody()->getContents(), true);
            return $contents;
        } catch (ClientException $e) {
            return new InternalServerErrorException($e->getMessage());
        } catch (ServerException $e) {
            return new InternalServerErrorException($e->getMessage());
        }
    }
}
