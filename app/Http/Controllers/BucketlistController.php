<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bucketlist;
use Illuminate\Http\Request;


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

    public function index(Request $request) {
         
         $user_id = $this->userID($request);

         $bucketlists = Bucketlist::where('user_id',$user_id)->get();

         return $this->success($bucketlists, 200);

    }
    public function store(Request $request) {

        $user_id = $this->userID($request);

        $this->validate($request, [
            'name' => 'required'
        ]);

        $bucketlist = Bucketlist::create([

            'name' => $request->get('name'),
            'user_id'=>$user_id
        ]);

        return $this->success("A new bucketlist has been created", 201);
    }
    public function show(Request $request, $bucketlist_id) {

        $user_id = $this->userID($request);

        $bucketlist = Bucketlist::where([
            'user_id' => $user_id,
            'id' => $bucketlist_id
            ])->get();

        return $this->success($bucketlist, 200);
    }
}