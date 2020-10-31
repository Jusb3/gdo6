<?php
namespace GDO\User\Test;

use PHPUnit\Framework\TestCase;
use GDO\User\GDO_User;
use GDO\Util\BCrypt;
use GDO\User\GDO_UserPermission;
use GDO\Core\Module_Core;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertTrue;

final class UserTest extends TestCase
{
    public function testSystemUser()
    {
        $u1 = Module_Core::instance()->cfgSystemUser();
        $u2 = GDO_User::system();
        $id = Module_Core::instance()->cfgSystemUserID();

        $this->assertTrue($u1 === $u2);
        $this->assertEquals($id, $u1->getID());
        
        GDO_User::$CURRENT = $u1;
    }
    
    public function testAdminCreation()
    {
        $user = GDO_User::blank(array(
            'user_id' => null,
            'user_name' => 'gizmore',
            'user_type' => GDO_User::MEMBER,
            'user_email' => 'gizmore@gizmore.org',
            'user_password' => BCrypt::create('11111111')->__toString(),
        ))->insert();
        
        assertTrue($user->getID() > 0);
        
        GDO_UserPermission::grant($user, 'admin');
        GDO_UserPermission::grant($user, 'staff');
        GDO_UserPermission::grant($user, 'cronjob');
        $user->changedPermissions();
        
        assertTrue($user->isAdmin());
    }
}