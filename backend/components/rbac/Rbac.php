<?php
/**
 * Created by PhpStorm.
 * User: Alexey Shevchenko <ivanovosity@gmail.com>
 * Date: 07.10.16
 * Time: 5:57
 */

namespace backend\components\rbac;


class Rbac
{
    // Разрешения для доступа к Backend
    const PERMISSION_BACKEND = 'permBackend';

    // Разрешения для User Manager
    const PERMISSION_BACKEND_USER_CREATE = 'permCreateUser';
    const PERMISSION_BACKEND_USER_UPDATE = 'permUpdateUser';
    const PERMISSION_BACKEND_USER_VIEW = 'permViewUser';
    const PERMISSION_BACKEND_USER_DELETE = 'permDeleteUser';
}