<?php
/**
 * PHP version 7
 * Contains the Bucketlist endpoints
 *
 * LICENSE: MIT
 *
 * @category Bucketlists
 * @package  App\Http\Controllers
 * @author   Charles Oduk <odukjr@gmail.com>
 * @license  https://opensource.org/licenses/MIT  MIT
 * @link     none
 */
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bucketlist;
use Illuminate\Http\Request;

 /**
  * Class BucketlistController
  *
  * @category Bucketlists
  * @package  App\Http\Controllers
  * @author   Charles Oduk <odukjr@gmail.com>
  * @license  https://opensource.org/licenses/MIT  MIT
  * @link     none yet
  */
class BucketlistController extends Controller
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
     * Gets all bucketlists for the current user
     *
     * @param Request|object $request - request payload
     *
     * @return json JSON object containing bucketlists(s)
     */
    public function index(Request $request) 
    {
         
         $user_id = $this->userID($request);

         $bucketlists = Bucketlist::where('user_id', $user_id)->get();

         return $this->success($bucketlists, 200);

    }

    /**
     * Adds a new bucketlist for the current user
     *
     * @param Request|object $request - request payload
     *
     * @return json JSON object containing success message and status code
     */
    public function store(Request $request) 
    {

        $user_id = $this->userID($request);

        $this->validate(
            $request, [
            'name' => 'required'
            ]
        );

        Bucketlist::create(
            [

            'name' => $request->get('name'),
            'user_id'=>$user_id
            ]
        );

        return $this->success("A new bucketlist has been created", 201);
    }

    /**
     * Gets a specific bucketlists for the current user
     *
     * @param Request|object $request       - request payload
     * @param int            $bucketlist_id - the bucketlist id
     *
     * @return json JSON object containing a bucketlist
     */
    public function show(Request $request, $bucketlist_id) 
    {

        $user_id = $this->userID($request);

        $bucketlist = Bucketlist::where(
            [
            'user_id' => $user_id,
            'id' => $bucketlist_id
            ]
        )->get();

        return $this->success($bucketlist, 200);
    }
}
