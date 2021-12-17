<?php

namespace App\Repositories;
use App\Interfaces\WalletRepositoryInterface;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class WalletRepository implements WalletRepositoryInterface
{
    // this function will be called to save the transaction and its status. If payment was succesful, another
    // function will update the transaction and insert add the new amount to the user wallet

    public function rechargeWallet($validated) {

        $user = Auth::user();

        $wallet_transaction = WalletTransaction::create([
            'sender_id' => $user->id,
            'wallet_id' => $user->wallet->id,
            'reference' => $this->reference(),
            'type' => 'Credit',
            'amount' => $validated['amount']
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Funding wallet completed successfully',
            'data' => $wallet_transaction->amount
        ], 200);
    }

    //this function will get the authenticated users wallet balance

    public function getBalance()
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Retrieved current balance successfully',
            'data' => auth()->user()->wallet->balance
        ], 201);
    }

    //this function has not been completed yet
    public function transferBalance($userId, array $recipientDetails)
    {
        return Wallet::whereId($userId)->update($recipientDetails);
    }

    //this function will create a new transaction reference
    public function reference()
    {
        return 'pktmy'. mt_rand(1000000000, 9999999999);
    }

}
