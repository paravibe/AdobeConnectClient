<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Command;
use AdobeConnectClient\Arrayable;
use AdobeConnectClient\Converter\Converter;
use AdobeConnectClient\Helpers\StatusValidate;
use AdobeConnectClient\Helpers\SetEntityAttributes as FillObject;
use AdobeConnectClient\Principal;

/**
 * Provides a complete list of users and groups, including primary groups.
 *
 * @link https://helpx.adobe.com/adobe-connect/webservices/principal-list.html
 */
class PrincipalList extends Command
{
    /** @var array */
    protected $parameters;

    /**
     * @param int $groupId The ID of a group. Same as the principal-id of a principal that has a type value of group.
     * @param Arrayable $filter
     * @param Arrayable $sorter
     */
    public function __construct(
        $groupId = 0,
        Arrayable $filter = null,
        Arrayable $sorter = null
    ) {
        $this->parameters = [
            'action' => 'principal-list',
        ];

        if ($groupId) {
            $this->parameters['group-id'] = $groupId;
        }

        if ($filter) {
            $this->parameters += $filter->toArray();
        }

        if ($sorter) {
            $this->parameters += $sorter->toArray();
        }
    }

    /**
     * @return Principal[]
     */
    protected function process()
    {
        $response = Converter::convert(
            $this->client->doGet(
                $this->parameters + ['session' => $this->client->getSession()]
            )
        );

        StatusValidate::validate($response['status']);

        $principals = [];

        foreach ($response['principalList'] as $principalAttributes) {
            $principal = new Principal();
            FillObject::setAttributes($principal, $principalAttributes);
            $principals[] = $principal;
        }

        return $principals;
    }
}