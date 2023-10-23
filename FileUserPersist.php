<?php
declare(strict_types= 1);

require_once 'UserPersistInterface.php';

class FileUserPersist implements UserPersistInterface
{
    const FILENAME = 'users.txt';

    public function save(User $user): void
    {
        if (file_exists(filename: self::FILENAME)) {
            $fileContains = json_decode(file_get_contents(filename: self::FILENAME));
        } else {
            $fileContains = [];
        }

        $fileContains[] = $this->getUserToPersistByUser($user);
        
        file_put_contents(filename: self::FILENAME, data: json_encode($fileContains));
    }

    private function getUserToPersistByUser(User $user):array
    {
        return [
            "login"=> $user->getLogin(),
            "password"=> sha1($user->getPassword()),
            "createdAt" => $user->getCreatedAt() ->format(format: 'd.m.Y H:i:s'),
        ];
    }

}