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

     /**
      * PUT, update a specific bucketlist
      *
      * @param Request|object $request       - request payload
      * @param Number         $bucketlist_id - id of the bucketlist
      *
      * @return json JSON object containing a success or error message
      */
    public function update(Request $request, $bucketlist_id)
    {
        $user_id = $this->userId($request);

        $bucketlist = Bucketlist::where(
            [
            'user_id'=> $user_id,
            'id' => $bucketlist_id
            ]
        )->first();

        if (empty($bucketlist)) {
            return $this->error(
                "Bucketlist with id {$bucketlist_id} does not exist or does not belong to you", 
                404
            );
        } else {
            $bucketlist->name = $request->get('name');
            $bucketlist->save();
            return $this->success('You have successfully updated the bucketlist', 200);
        }
    }

    /**
     * DELETE, delete a bucketlist
     *
     * @param Request|object $request       - request payload
     * @param Number         $bucketlist_id - id of the bucketlist
     *
     * @return json JSON object containing a success or error message
     */
    public function destroy(Request $request, $bucketlist_id)
    {
        $user_id = $this->userId($request);

        $bucketlist = Bucketlist::where(
            [
            'user_id'=> $user_id,
            'id' => $bucketlist_id,
            ]
        )->first();

        if (empty($bucketlist)) {
            return $this->error("Bucketlist with id {$bucketlist_id} could not be found", 404);
        } else {
            $bucketlist->delete();
            return $this->success("Bucketlist successfully deleted!", 200);
        }
    }
}
