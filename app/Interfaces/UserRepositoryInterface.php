<?php

namespace App\Interfaces;

interface UserRepositoryInterface
{
    public function createNewUser(array $userDetails);
    public function login(array $userDetails);
    public function rechargeWallet(array $details);
    public function transferBalance($userId, array $recipientDetails);
    public function generateUUID();
    public function uuidExists($uuid);
}
