<?php
/**
 * PHP version 7
 * Contains the App Authentication
 *
 * LICENSE: MIT
 *
 * @category Authentication
 * @package  App\Http\Controllers
 * @author   Charles Oduk <odukjr@gmail.com>
 * @license  https://opensource.org/licenses/MIT  MIT
 * @link     none
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\JWTAuth;

 /**
  * Class AuthController
  *
  * @category Authentication
  * @package  App\Http\Controllers
  * @author   Charles Oduk <odukjr@gmail.com>
  * @license  https://opensource.org/licenses/MIT  MIT
  * @link     none yet
  */
class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }
    
    /**
     * Register a new user
     *
     * @param Request|object $request - request payload
     *
     * @return json JSON object containing a success message
     */
    public function register(Request $request)
    {

        $this->validate(
            $request, [
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6'
            ]
        );

        $user = User::create(
            [
            'name'=> $request->get('name'),
            'email' => $request->get('email'),
            'password'=> Hash::make($request->get('password')),
            ]
        );

        return $this->success("The user with with id {$user->id} has been created", 201);
    }
    
    /**
     * Log a user in
     *
     * @param Request|object $request - request payload
     *
     * @return json JSON object containing a token and the username
     */
    public function login(Request $request)
    {
        $this->validate(
            $request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
            ]
        );

        try {
            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }
        
        $user = $request->user();
        $userName = $user['name'];

        return response()->json(
            [
            'token' => $token,
            'name' => $userName
            ]
        );
    }
}
