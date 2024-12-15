<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {

    }
    public function index() {

        return $this->userService->index();
    }

    public function show($id) {

        return User::select(
            'id',
            'name',
            'email',
            'phone',
            'created_at',
            'updated_at'
        )->where('id', '=', $id)->firstOrFail();

    }
    public function store(Request $request) {

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|max:255|unique:users',
            'password'  => 'required|string',
            'phone'     => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'phone'     => $request->phone,
        ]);

        $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => $user
        ]);

    }

}
