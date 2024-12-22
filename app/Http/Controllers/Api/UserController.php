<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Service\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {

        return $this->userService->index();
    }

    public function show($id)
    {
        return $this->userService->show($id);
    }

    public function store(UserStoreRequest $request) {
        $validatedData = $request->validated();
        return $this->userService->store($validatedData);
    }

    public function update(UpdateUserRequest $request, $id) {
        $validatedData = $request->validated();
        return $this->userService->update($validatedData, $id);
    }

    public function destroy($id) {
        return $this->userService->destroy($id);
    }
}
