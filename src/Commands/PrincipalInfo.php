<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Command;
use AdobeConnectClient\Client;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Helpers\StatusValidate;
use AdobeConnectClient\Principal;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;

/**
 * Provides information about one principal, either a user or a group.
 *
 * @link https://helpx.adobe.com/adobe-connect/webservices/principal-info.html
 */
class PrincipalInfo extends Command
{
    /** @var int */
    protected $principalId;

    public function __construct(Client $client, $principalId)
    {
        parent::__construct($client);
        $this->principalId = (int) $principalId;
    }

    /**
     * @return Principal
     */
    public function execute()
    {
        $responseConverted = Converter::convert(
            $this->client->getConnection()->get([
                'action' => 'principal-info',
                'principal-id' => $this->principalId,
                'session' => $this->client->getSession()
            ])
        );

        StatusValidate::validate($responseConverted['status']);

        $principal = new Principal();
        FillObject::setAttributes($principal, $responseConverted['principal']);
        return $principal;
    }
}
