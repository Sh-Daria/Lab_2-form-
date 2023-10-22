<?php
declare(strict_types= 1);

require_once 'UserPersistInterface.php';

class DatabaseUserPersist implements UserPersistInterface
{
    public function save(User $user): void
    {
        echo __METHOD__;
    }

}
