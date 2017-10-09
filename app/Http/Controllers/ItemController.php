<?php 
/**
 * PHP version 7
 * Contains the Item endpoints
 *
 * LICENSE: MIT
 *
 * @category Bucketlist_Items
 * @package  App\Http\Controllers
 * @author   Charles Oduk <odukjr@gmail.com>
 * @license  https://opensource.org/licenses/MIT  MIT
 * @link     none
 */

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;

 /**
  * Class ItemController
  *
  * @category Bucketlist_Items
  * @package  App\Http\Controllers
  * @author   Charles Oduk <odukjr@gmail.com>
  * @license  https://opensource.org/licenses/MIT  MIT
  * @link     none yet
  */
class ItemController extends Controller
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
     * GET all items from a bucketlist
     *
     * @param Request|object $request       - request payload
     * @param Number         $bucketlist_id - id of the bucketlist
     *
     * @return json JSON object containing item(s)
     */
    public function index(Request $request, $bucketlist_id)
    {
        $user_id = $this->userID($request);

        $items = Item::where(
            [
            'user_id'=> $user_id,
            'bucketlist_id' => $bucketlist_id
            ]
        )->get()->toArray();

        if (empty($items)) {
            return $this->error('No items found in this bucketlist', 404);
        } else {
            return $this->success($items, 200);
        }
    }
    
    /**
     * POST a new item to the bucketlist
     *
     * @param Request|object $request       - request payload
     * @param Number         $bucketlist_id - id of the bucketlist
     *
     * @return json JSON object containing a success message
     */
    public function store(Request $request, $bucketlist_id)
    {
        $user_id = $this->userID($request);
        
        $this->validate(
            $request, [
            'name' => 'required'
            ]
        );

        $item = Item::create(
            [
            
            'name' => $request->get('name'),
            'user_id'=>$user_id,
            'bucketlist_id' => $bucketlist_id
            ]
        );
      
        return $this->success("A new bucketlist item has been created", 200);
    }
    
     /**
      * GET a specific item from the bucketlist
      *
      * @param Request|object $request       - request payload
      * @param Number         $bucketlist_id - id of the bucketlist
      * @param Number         $item_id       - id of the item
      *
      * @return json JSON object containing an item
      */
    public function show(Request $request, $bucketlist_id, $item_id)
    {
        $user_id = $this->userId($request);

        $item = Item::where(
            [
            'user_id'=> $user_id,
            'bucketlist_id' => $bucketlist_id,
            'id' => $item_id
            ]
        )->first();

        if (empty($item)) {
            return $this->error(
                "Item with id {$item_id} does not exist or does not belong to you",
                404
            );
        } else {
            return $this->success($item, 200);
        }
    }
    
     /**
      * PUT, update a specific item from the bucketlist
      *
      * @param Request|object $request       - request payload
      * @param Number         $bucketlist_id - id of the bucketlist
      * @param Number         $item_id       - id of the item
      *
      * @return json JSON object containing a success or error message
      */
    public function update(Request $request, $bucketlist_id, $item_id)
    {
        $user_id = $this->userId($request);

        $item = Item::where(
            [
            'user_id'=> $user_id,
            'bucketlist_id' => $bucketlist_id,
            'id' => $item_id
            ]
        )->first();

        if (empty($item)) {
            return $this->error(
                "Item with id {$item_id} does not exist or does not belong to you", 
                404
            );
        } else {
            $item->name = $request->get('name') ?? $item->name;
            $item->done = $request->get('done') ?? $item->done;
            $item->save();
            return $this->success('You have successfully updated the item', 200);
        }
    }

    /**
     * DELETE, delete a specific item from the bucketlist
     *
     * @param Request|object $request       - request payload
     * @param Number         $bucketlist_id - id of the bucketlist
     * @param Number         $item_id       - id of the item
     *
     * @return json JSON object containing a success or error message
     */
    public function delete(Request $request, $bucketlist_id, $item_id)
    {
        $user_id = $this->userId($request);

        $item = Item::where(
            [
            'user_id'=> $user_id,
            'bucketlist_id' => $bucketlist_id,
            'id' => $item_id
            ]
        )->first();

        if (empty($item)) {
            return $this->error("Item with id {$item_id} could not be found", 404);
        } else {
            $item->delete();
            return $this->success("Item successfully deleted!", 200);
        }
    }
}
