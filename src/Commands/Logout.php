<?php

namespace AdobeConnectClient\Commands;

use AdobeConnectClient\Command;

/**
 * Ends the session
 *
 * @see https://helpx.adobe.com/content/help/en/adobe-connect/webservices/logout.html
 */
class Logout extends Command
{
    public function execute()
    {
        $this->client->getConnection()->get([
            'action' => 'logout',
            'session' => $this->client->getSession()
        ]);
        $this->client->setSession('');
        return true;
    }
}
