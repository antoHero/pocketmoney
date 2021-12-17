<?php

namespace App\Interfaces;

interface WalletRepositoryInterface
{
    public function rechargeWallet(array $details);
    public function getBalance();
    public function transferBalance($userId, array $recipientDetails);
}
