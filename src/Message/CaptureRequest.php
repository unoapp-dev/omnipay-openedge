<?php

namespace Omnipay\OpenEdge\Message;

class CaptureRequest extends AbstractRequest
{
    public function getData()
    {
        $data = null;

        if ($this->getTransactionReference()) {

            $cardReference = simplexml_load_string($this->getTransactionReference());

            $GatewayRequest = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><GatewayRequest></GatewayRequest>');
            $GatewayRequest->addChild('SpecVersion', $this->getSpecVersion());
            $GatewayRequest->addChild('XWebID', $this->getXWebID());
            $GatewayRequest->addChild('TerminalID', $this->getTerminalID());
            $GatewayRequest->addChild('AuthKey', $this->getAuthKey());
            $GatewayRequest->addChild('Industry', $this->getIndustry());

            $GatewayRequest->addChild('POSType', 'PC');
            $GatewayRequest->addChild('PinCapabilities', 'FALSE');
            $GatewayRequest->addChild('TrackCapabilities', 'NONE');
            $GatewayRequest->addChild('DuplicateMode', 'CHECKING_OFF');
            $GatewayRequest->addChild('TransactionType', 'CreditCaptureTransaction');

            $GatewayRequest->addChild('TransactionID', $cardReference->TransactionID);

            $data = $GatewayRequest->asXML();
        }

        return preg_replace('/\n/', ' ', $data);
    }
}
