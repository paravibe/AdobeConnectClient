<?php
/**
 * Created by PhpStorm.
 * User: Bruno
 * Date: 10/03/2018
 * Time: 15:50
 */

namespace AdobeConnectClient\Tests\Commands;

use AdobeConnectClient\Commands\UserUpdatePassword;
use AdobeConnectClient\Exceptions\NoAccessException;

class UserUpdatePasswordTest extends TestCommandBase
{
    public function testNoAccess()
    {
        $this->userLogout();

        $command = new UserUpdatePassword(1, 'password');
        $command->setClient($this->client);

        $this->expectException(NoAccessException::class);

        $command->execute();
    }

    public function testUpdateWithoutOldPassword()
    {
        $this->userLogin();

        $command = new UserUpdatePassword(1, 'newpassword');
        $command->setClient($this->client);

        $this->assertTrue($command->execute());
    }

    public function testUpdateWithOldPassword()
    {
        $this->userLogin();

        $command = new UserUpdatePassword(1, 'newpassword', 'oldpassword');
        $command->setClient($this->client);

        $this->assertTrue($command->execute());
    }
}