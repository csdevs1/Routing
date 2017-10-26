<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Usuarios;
use JWTAuth;
use Auth;
class AuthenticationController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/api/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
    }
    
    public function authenticate(Request $request){
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        //dd($credentials);
        try {
            config(['auth.providers.users.model' => \App\Usuarios::class]);
            $token = JWTAuth::attempt($credentials);
            // dd($token);
            // attempt to verify the credentials and create a token for the user
            if (!$token) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        // all good so return the token
        return response()->json(compact('token'));
    }

    protected function register(Request $request)
    {
        $inputs = $request->only('name','email','password');
        //dd($inputs);   
        return $this->create($inputs);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Usuarios::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public function get_user_info(Request $request){
        try {
            $tokenFetch = JWTAuth::parseToken()->authenticate(); 
            $token = str_replace("Bearer ", "", $request->header('Authorization'));
            $input = $request->all();
            $user = JWTAuth::toUser($input['token']);
            return response()->json(['result' => $user]);
        }catch(\Tymon\JWTAuth\Exceptions\JWTException $e){//general JWT exception
            return response()->json(['error' => 'Not logged in.']);
        }
    }
}
