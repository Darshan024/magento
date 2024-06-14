<?php

class Ccc_Outlook_Model_Api extends Mage_Core_Model_Abstract
{
    private $scope = 'Mail.Read Mail.ReadBasic';
    private $redirectUri = null;
    protected $_config;
    protected $_email;
    protected function _construct()
    {
        $this->redirectUri = Mage::getBaseUrl() . 'outlook/email/index';
    }

    public function getAuthorizationUrl()
    {
        $configModel = $this->_config;
        $clientId = $configModel->getClientId();
        $configId = $configModel->getId();
        $authUrl = "https://login.microsoftonline.com/common/oauth2/v2.0/authorize";
        $params = [
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => 'http://localhost/my_magento/outlook/email/index',
            'scope' => $this->scope,
            'response_mode' => 'query',
            'state' => $configId,
        ];
        return $authUrl . '?' . http_build_query($params);
    }

    public function saveAccessToken($configModel)
    {
        $request = Mage::app()->getRequest();
        $code = $request->getParam('code');
        $tokenUrl = "https://login.microsoftonline.com/consumers/oauth2/v2.0/token";
        $data = [
            'client_id' => $configModel->getClientId(),
            'scope' => $this->scope,
            'code' => $code,
            'redirect_uri' => 'http://localhost/my_magento/outlook/email/index',
            'grant_type' => 'authorization_code',
            'client_secret' => $configModel->getSecretValue(),
        ];

        $headers = [
            'Content-Type: application/x-www-form-urlencoded'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error fetching access token: ' . curl_error($ch));
        }
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['access_token'])) {
            return $result['access_token'];
        } else {
            throw new Exception('Error fetching access token: ' . $response);
        }
    }
    public function getEmails()
    {
        $configModel = $this->_config;
        $accessToken = $configModel->getAccessToken();
        $url = 'https://graph.microsoft.com/v1.0/me/messages';
        
        if (!is_null($configModel->getLastReadTime())) {
            $date = new DateTime($configModel->getLastReadTime(), new DateTimeZone('UTC'));
            $date->modify('+1 second');
            $formatted_date = $date->format('Y-m-d\TH:i:s\Z');
            $url .= '?$filter=receivedDateTime+ge+'. $formatted_date;
        }
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new Exception('Error fetching emails: ' . curl_error($ch));
        }
        $emails = json_decode($response, true);
        $allEmails = $this->setEmails($emails['value']);
        return $allEmails;
    }
    public function setEmails($emails)
    {
        $configModel = $this->_config;
        $outlookEmails = [];
        foreach ($emails as $email) {
            $body = strip_tags($email['body']['content']);
            $outlookEmail = [
                'from' => $email['from']['emailAddress']['address'],
                'to' => $email['toRecipients'][0]['emailAddress']['address'],
                'subject' => $email['subject'],
                'received_datetime' => $email['receivedDateTime'],
                'has_attechments' => $email['hasAttachments'],
                'body' => trim($body),
                'outlook_id' => $email['id'],
                'config_id' => $configModel->getId(),
            ];
            $outlookEmails[] = $outlookEmail;
        }
        return $outlookEmails;
    }
    public function setConfigObj($config)
    {
        $this->_config = $config;
        return $this;
    }
    public function fetchAttachaments()
    {
        $emailModel = $this->_email;
        $outlookId = $emailModel->getOutlookId();
        $configModel = $emailModel->getConfigObj();
        $accessToken = $configModel->getAccessToken();
        $url = 'https://graph.microsoft.com/v1.0/me/messages/' . urlencode($outlookId) . '/attachments';
        $headers = [
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response, true);
        return $response;
    }
    public function setEmailObj($email)
    {
        $this->_email = $email;
        return $this;
    }
}
