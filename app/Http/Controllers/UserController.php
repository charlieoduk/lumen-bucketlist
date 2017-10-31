<?php
/**
 * PHP version 7
 * Contains the Item endpoints
 *
 * LICENSE: MIT
 *
 * @category Users
 * @package  App\Http\Controllers
 * @author   Charles Oduk <odukjr@gmail.com>
 * @license  https://opensource.org/licenses/MIT  MIT
 * @link     none
 */
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

 /**
  * Class UserController
  *
  * @category Bucketlist_Items
  * @package  App\Http\Controllers
  * @author   Charles Oduk <odukjr@gmail.com>
  * @license  https://opensource.org/licenses/MIT  MIT
  * @link     none yet
  */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    /**
     * Gets all available users. If there are
     * no users an error message is returned
     *
     * @return json JSON object containing user(s)
     */
    public function index()
    {
        $users = User::all();

        if (empty($users)) {
            return $this->error("There are no users", 404);
        }
        return $this->success($users, 200);
    }
    
    /**
     * Gets the user specified by the user id. If the
     * user is not found, an error message is returned
     *
     * @param int $user_id - the user id
     * 
     * @return json JSON object containing user
     */
    public function show($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return $this->error("The user with id {$user_id} doesn't exist", 404);
        }
        return $this->success($user, 200);
    }
    
    /**
     * Gets the user specified by the user id and updates
     * the user details. If the user is not found, an error
     * message is returned.
     *
     * @param int $user_id - the user id
     * 
     * @return json JSON object containing error/success message
     */
    public function update($user_id)
    {
        $user = User::find($user_id);
        
        if (!$user) {
            return $this->error("The user with {$user_id} doesn't exist", 404);
        }
        $this->validate(
            $request, [
            'name' => 'required',
            'email' => 'required|email|unique:users', 
            'password' => 'required|min:6'
            ]
        );
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        return $this->success("The user with with id {$user->id} has been updated", 200);
    }
    
    /**
     * Gets the user specified by the user id and deletes the user
     * If the user is not found, an error
     * message is returned.
     *
     * @param int $user_id - the user id
     * 
     * @return json JSON object containing error/success message
     */
    public function destroy($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return $this->error("The user with {$user_id} doesn't exist", 404);
        }
        $user->delete();
        return $this->success("The user with with id {$user_id} has been deleted", 200);
    }
}
