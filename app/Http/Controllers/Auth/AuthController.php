<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\Profiling\UserRepository;
use App\Services\Profiling\User\UserCreator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /** 
     * @var UserRepository
    */
    private $repository;

    /**
     * @var UserCreator
     */
    private $userCreatorService;

    /** 
     * AuthController Constructor.
     * @param UserCreator $userCreatorService
    */
    public function __construct(UserRepository $userRepository, UserCreator $userCreatorService) {
        $this->repository = $userRepository;
        $this->userCreatorService = $userCreatorService;
    }

    /** 
     * @param Request $request
     * @return JsonResponse
     * @throws ReflectionException
    */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:users,username',
            'password' => 'required|string|confirmed|min:6|max:12',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $user = $this->userCreatorService->create($request->all());

        $token = $user->createToken('myapptoken')->plainTextToken;

        $reponse = [
            'user' => $user,
            'token' => $token
        ];

        return response($reponse, 201);
    }

    /** 
     * @param Request $request
     * @return JsonResponse
     * @throws ReflectionException
    */
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $user = $this->repository->findOneByUniqueIdentifier($request->username);

        if (null === $user) {
            return response()->json(
                [
                    'message' => sprintf('User with username %s does not exist.', $request->input('username'))
                ],
                404
            );
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json(
                [
                    'message' => 'Password does not match our records.'
                ],
                401
            );
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    /** 
     * @return JsonResponse
     * @throws ReflectionException
    */
    public function logout() {
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'Logged Out'
        ];

        return response($response, 200);
    }
}
