<?php
/**
 * PHP version 7
 * Contains the Item endpoints
 *
 * LICENSE: MIT
 *
 * @category BaseController
 * @package  App\Http\Controllers
 * @author   Charles Oduk <odukjr@gmail.com>
 * @license  https://opensource.org/licenses/MIT  MIT
 * @link     none
 */
namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

 /**
  * Class Controller
  *
  * @category Bucketlist_Items
  * @package  App\Http\Controllers
  * @author   Charles Oduk <odukjr@gmail.com>
  * @license  https://opensource.org/licenses/MIT  MIT
  * @link     none yet
  */
class Controller extends BaseController
{
    /**
     * Builds the success messsage
     *
     * @param object $data - object containing data
     * @param int    $code - request status code
     * 
     * @return json JSON object data and the status code
     */
    public function success($data, $code)
    {
        return response()->json(['data' => $data], $code);
    }
    
    /**
     * Builds the error messsage
     *
     * @param string $message - the error message
     * @param int    $code    - request status code
     * 
     * @return json JSON object data and the status code
     */
    public function error($message, $code)
    {
        return response()->json(['message' => $message], $code);
    }
    
    /**
     * Retrieves the user id from the request payload
     *
     * @param Request|object $request - request payload
     * 
     * @return int $user_id - the user id
     */
    public function userId($request)
    {
        $user = $request->user();
        $user_id = $user['id'];

        return $user_id;
    }
}
