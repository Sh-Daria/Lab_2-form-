<?php

interface UserPersistInterface
{
    public function save(User $user): void;
}