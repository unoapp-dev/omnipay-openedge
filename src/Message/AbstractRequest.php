<?php

namespace  Omnipay\OpenEdge\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $endpoint = null;

    public function getEndpoint()
    {
        if ($this->endpoint) return $this->endpoint;
        return $this->endpoint = $this->getTestMode() ? $this->getSandboxEndPoint() : $this->getProductionEndPoint();
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function getSandboxEndPoint()
    {
        return $this->getParameter('sandboxEndPoint');
    }

    public function setSandboxEndPoint($value)
    {
        return $this->setParameter('sandboxEndPoint', $value);
    }

    public function getProductionEndPoint()
    {
        return $this->getParameter('productionEndPoint');
    }

    public function setProductionEndPoint($value)
    {
        return $this->setParameter('productionEndPoint', $value);
    }

    public function getMerchantCurrency()
    {
        return $this->getParameter('merchantCurrency');
    }

    public function setMerchantCurrency($value)
    {
        return $this->setParameter('merchantCurrency', $value);
    }

    public function getSpecVersion()
    {
        return $this->getParameter('SpecVersion');
    }

    public function setSpecVersion($value)
    {
        return $this->setParameter('SpecVersion', $value);
    }

    public function getXWebID()
    {
        return $this->getParameter('XWebID');
    }

    public function setXWebID($value)
    {
        return $this->setParameter('XWebID', $value);
    }

    public function getTerminalID()
    {
        return $this->getParameter('TerminalID');
    }

    public function setTerminalID($value)
    {
        return $this->setParameter('TerminalID', $value);
    }

    public function getAuthKey()
    {
        return $this->getParameter('AuthKey');
    }

    public function setAuthKey($value)
    {
        return $this->setParameter('AuthKey', $value);
    }

    public function getIndustry()
    {
        return $this->getParameter('Industry');
    }

    public function setIndustry($value)
    {
        return $this->setParameter('Industry', $value);
    }

    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }

    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }

    public function getPaymentProfile()
    {
        return $this->getParameter('payment_profile');
    }

    public function setPaymentProfile($value)
    {
        return $this->setParameter('payment_profile', $value);
    }

    public function getOrderNumber()
    {
        return $this->getParameter('order_number');
    }

    public function setOrderNumber($value)
    {
        return $this->setParameter('order_number', $value);
    }

    protected function getHttpMethod()
    {
        return 'POST';
    }

    public function sendData($data)
    {
        $headers = [
            'Content-Type' => 'application/xml'
        ];

        if (!empty($data)) {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers, $data);
        }
        else {
            $httpResponse = $this->httpClient->request($this->getHttpMethod(), $this->getEndpoint(), $headers);
        }

        try {
            $xmlResponse = simplexml_load_string($httpResponse->getBody()->getContents());
        }
        catch (\Exception $e){
            info('Guzzle response : ', [$httpResponse]);
            $res = [];
            $res['resptext'] = 'Oops! something went wrong, Try again after sometime.';
            return $this->response = new Response($this, $res);
        }

        return $this->response = new Response($this, $xmlResponse);
    }
}

