<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\UserRepositoryInterface;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\FundWalletRequest;

class AuthController extends Controller
{
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(CreateUserRequest $request)
    {
        $validated = $request->safe()->only(['name', 'email', 'username', 'phone', 'password']);

        return $this->userRepository->createNewUser($validated);
    }

    public function login(LoginUserRequest $request)
    {
        $validated = $request->validated();

        return $this->userRepository->login($validated);
    }

    public function logout()
    {
        // return auth()->user();
        if(auth()->user()->tokens()->delete()){
            return response()->json([
                'status' => 'success',
                'message' => 'User logged out successfully!',
            ], 200);
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'error' => 'Something went wrong!'
            ], 401);
        }

    }
}
