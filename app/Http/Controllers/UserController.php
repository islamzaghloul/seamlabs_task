<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

public function Register(Request $request)
{
    try {

        $validateUser = Validator::make($request->all(),
        [
            'username' => 'required||unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'birth_date'=>'required|date_format:Y-m-d',
            'phone_number'=>'required|regex:/(01)[0-9]{9}/',

        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()->first()
            ], 401);
        }

        $user = User::create([
            'username'=>$request->username,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'birth_date'=>$request->birth_date,
            'phone_number'=>$request->phone_number
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }
    catch(Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }

}
public function Login(Request $request)
{

    try {
        $validateUser = Validator::make($request->all(),
        [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()->first()
            ], 401);
        }

        if(!Auth::attempt($request->only(['username', 'password']))){
            return response()->json([
                'status' => false,
                'message' => 'Username & Password does not match with our record.',
            ], 401);
        }

        $user = User::where('username', $request->username)->first();

        // return $this->respondWithToken($user->createToken("API TOKEN")->plainTextToken);
        return response()->json([
            'status' => true,
            'message' => 'User Logged In Successfully',
            'token' => $user->createToken("API TOKEN")->plainTextToken,
            'data' => $user
        ], 200);
    }catch (\Throwable $th) {
        return response()->json([
            'status' => false,
            'message' => $th->getMessage()
        ], 500);
    }

}
public function Show(Request $request)
{
    $users=User::all();
    if($users->isEmpty())
    {
        return response()->json([
            'status' => false,
            'message' => 'no users',
        ], 200);
    }

    return response()->json([
        'status' => true,
        'message' => 'here is users',
        'data' => $users
    ], 200);
}
public function GetById(Request $request)
{
    $user=User::find($request->id);
    if(is_null($user))
    {
        return response()->json([
            'status' => false,
            'message' => 'no user with this id',
        ], 200);
    }

    return response()->json([
        'status' => true,
        'message' => 'here is users',
        'data' => $user
    ], 200);
}
public function Edit(Request $request)
{

    $validateUser = Validator::make($request->all(),
    [

        'username' => 'unique:users,username',
        'email' => 'email|unique:users,email',
        'password' => 'min:8',
        'birth_date'=>'date_format:Y-m-d',
        'phone_number'=>'regex:/(01)[0-9]{9}/',

    ]);

    if($validateUser->fails()){
        return response()->json([
            'status' => false,
            'message' => 'validation error',
            'errors' => $validateUser->errors()->first()
        ], 401);
    }
    $data = [];
    if(isset($request->username))
        {$data['username']=$request->username;}
    if(isset($request->email))
        {$data['email']=$request->email;}
    if(isset($request->password))
        {$data['password']=$request->password;}
    if(isset($request->birth_date))
        {$data['birth_date']=$request->birth_date;}
    if(isset($request->birth_date))
        {$data['phone_number']=$request->phone_number;}
    // dd($data);
    if(!empty($data))
    {
    $user = User::where('id',auth()->user()->id)->update($data);
    return response()->json([
        'status'=>true,
        'message'=>'updated successfully',
    ]);
    }
    else
    {
        return response()->json([
            'status' => false,
            'message' => 'no field to be updated',]);
    }
}
public function Delete(Request $request)
{
    $user=User::where('id',$request->id)->delete();
    if(!$user)
    {
        return response()->json([
            'status' => false,
            'message' => 'no user with this id',
        ], 200);
    }

    return response()->json([
        'status' => true,
        'message' => 'user is deleted',
    ], 200);
}
}
