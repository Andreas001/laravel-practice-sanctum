<?php

namespace App\Http\Controllers\Profiling;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Profiling\User;
use App\Repository\Profiling\UserRepository;
use App\Services\Profiling\User\UserCreator;
use App\Services\Profiling\User\UserDeleter;
use App\Services\Profiling\User\UserUpdater;

/** 
 * @author andreasgeraldo0@gmail.com
*/
class UserController extends Controller {
    /** 
     * @var UserRepository
    */
    private $repository;

    /**
     * @var UserCreator
     */
    private $userCreatorService;

    /**
     * @var UserUpdater
     */
    private $userUpdaterService;

    /**
     * @var UserDeleter
     */
    private $userDeleterService;

    /** 
     * UserController Constructor.
     * @param UserRepository $repository
     * @param UserCreator $userCreatorService
     * @param UserUpdater $userUpdaterService
     * @param UserDeleter $userDeleterService
    */
    public function __construct(UserRepository $repository, UserCreator $userCreatorService, UserUpdater $userUpdaterService, UserDeleter $userDeleterService) {
        $this->repository = $repository;
        $this->userCreatorService = $userCreatorService;
        $this->userUpdaterService = $userUpdaterService;
        $this->userDeleterService = $userDeleterService;
    }

    /** 
     * @return LengthAwarePaginator
    */
    public function index() {
        $keyword = request()->query('keyword');
        $limit = (int) request()->query('limit', 15);

        return $this->repository->findByName($keyword, $limit);
    }

    /** 
     * @param Request $request
     * @return User|JsonResponse
     * @throws ReflectionException
    */
    public function create(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'first_name'   => 'required|string|max:30',
        //     'last_name'    => 'required|string|max:30',
        //     'email'        => 'required|string|max:30|unique:users,email',
        //     'username'     => 'required|string|max:30|unique:users,username',
        //     'password'     => 'required|string|min:6|max:12',
        //     'phone_number' => 'required|string|max:15',
        // ]);
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:users,username',
            'password' => 'required|string|min:6|max:12',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $user = $this->userCreatorService->create($request->all());

        return $user;
    }

    /** 
     * @param Request $request
     * @return JsonResponse
     * @throws ReflectionException
    */
    public function update(Request $request) {
        // $validator = Validator::make($request->all(), [
        //     'first_name'   => 'required|string|max:30',
        //     'last_name'    => 'required|string|max:30',
        //     'email'        => 'required|string|max:30|unique:users,email',
        //     'username'     => 'required|string|max:30|unique:users,username',
        //     'password'     => 'required|string|min:6|max:12',
        //     'phone_number' => 'required|string|max:15',
        // ]);
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:30|unique:users,username',
            'password' => 'required|string|min:6|max:12',
        ]);

        if($validator->fails()) {
            return response()->json(
                $validator->errors()->getMessages()
            );
        }

        $user = User::find($request->route('id'));

        if(empty ($user)){
            return response()->json([
                    'success' => false,
                    'message' => 'Record with ID not found!',
            ], 404);
        }

        // if($this->repository->findByEmailAndExclude($request->input('email'), $user->id)){
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Email is already in use!',
        //     ], 400);
        // }

        if($this->repository->findByUsernameAndExclude($request->input('username'), $user->id)){
            return response()->json([
                'success' => false,
                'message' => 'Username is already in use!',
            ], 400);
        }

        $user->fill($request->all());
        // $user->status = UserStatus::get($request->input('status'));

        $this->userUpdaterService->update($user);

        return $user;
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if(empty ($user)){
            return response()->json([
                'success' => false,
                'message' => 'Record with ID not found!',
            ], 404);
        }

        // $this->repository->delete($user);
        $this->userDeleterService->delete($user);

        return $user;
    }

    /**
     * @param int $length
     * @return string
     */
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
