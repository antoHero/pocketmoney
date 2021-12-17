<?php

namespace App\Repositories;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class UserRepository implements UserRepositoryInterface
{

    //this function will create a new user
    public function createNewUser(array $validated_data)
    {
        $data = array(
            'uuid' => $this->generateUUID(),
            'name' => $validated_data['name'],
            'username' => $validated_data['username'],
            'email' => $validated_data['email'],
            'phone' => $validated_data['phone'],
            'password' => Hash::make($validated_data['password'])
        );

        $user =  User::create($data);

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0
        ]);

        $token = $user->createToken('userAccountToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => new UserResource($user),
            'token' => $token
        ], 200);
    }

    //this function will log the user into the system using their phone number and password
    public function login($userDetails)
    {

        if(!Auth::attempt(['phone' => $userDetails['phone'], 'password' => $userDetails['password']]))
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = User::where('phone', $userDetails['phone'])->firstOrFail();

        $token = $user->createToken('userToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer'
        ], 200);

    }

    //this function will generate a uuid to for a new user, it also checks if the uuid already exists
    public function generateUUID()
    {
        $uuid = Str::uuid()->toString();

        if ($this->uuidExists($uuid)) {
            return $this->generateUUID();
        }

        return $uuid;
    }

    //this function will check if a uuid is in use by another user
    public function uuidExists($uuid)
    {
        return User::whereUuid($uuid)->exists();
    }

    //this function will create a new transaction reference
    public function reference()
    {
        return 'pktmy'. mt_rand(1000000000, 9999999999);
    }

}
