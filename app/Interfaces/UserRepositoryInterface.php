<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createNewUser(array $userDetails);
    public function login(array $userDetails);
    public function generateUUID();
    public function uuidExists($uuid);
}
