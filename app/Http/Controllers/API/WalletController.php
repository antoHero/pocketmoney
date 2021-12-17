<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Interfaces\WalletRepositoryInterface;
use App\Http\Requests\FundWalletRequest;

class WalletController extends Controller
{
    public function __construct(WalletRepositoryInterface $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function fundWallet(FundWalletRequest $request)
    {
        $validated = $request->validated();

        return $this->walletRepository->rechargeWallet($validated);
    }

    public function walletBalance()
    {
        return $this->walletRepository->getBalance();
    }


}
