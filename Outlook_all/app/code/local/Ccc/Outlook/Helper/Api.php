<?php
class Ccc_Outlook_Helper_Api extends Mage_Core_Helper_Abstract
{
    protected $clientId = 'ad82b05e-52c1-417b-9cfc-90ebcb36240c';
    protected $clientSecret = 'AwN8Q~PUa2bTTZVPAZGfSI9BSOa3ijeEVBw.Xbfe';
    protected $tenantId = 'f8cdef31-a31e-4b4a-93e4-5f571e91255a';
    protected $scope = 'https://graph.microsoft.com/.default';

    public function getAccessToken()
    {
        $url = 'https://login.microsoftonline.com/' . $this->tenantId . '/oauth2/v2.0/token';
        $response = $this->makeRequest('POST', $url, [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'scope' => $this->scope,
            ]
        ]);

        if (isset($response['access_token'])) {
            return $response['access_token'];
        }
        return null;
    }

    public function fetchEmails($emailAddress)
    {
        $accessToken = $this->getAccessToken();
        print_r($accessToken);
        if ($accessToken) {
            $url = 'https://graph.microsoft.com/v1.0/users/' . $emailAddress . '/mailFolders/Inbox/messages';
            $response = $this->makeRequest('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ]
            ]);

            if (isset($response['value'])) {
                return $response['value'];
            }
        }
        return null;
    }

    protected function makeRequest($method, $url, $options)
    {
        $client = new Zend_Http_Client($url);
        if(!isset($options['headers'])) {
            $options['headers'] = [];
        }
        foreach ($options['headers'] as $header => $value) {
            $client->setHeaders($header, $value);
        }
        if ($method == 'POST') {
            $client->setMethod(Zend_Http_Client::POST);
            $client->setParameterPost($options['form_params']);
        }
        $response = $client->request();
        return json_decode($response->getBody(), true);
    }
}
