<?php

namespace App\Http\Controllers;


use DataTables;
use App\Models\User;
use App\Models\Category;
use App\Models\UserImage;
use Illuminate\Http\Request;
use App\Http\Requests\UserAddRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\RepoInterface\UserInterfaceRepo;
use Illuminate\Support\Str;
use  Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

    public function __construct(
        public UserInterfaceRepo $userInterfaceRepo
    ){

    }


    public function index(Request $request) {
     if ($request->ajax()) {
       
      
        $data = $this->userInterfaceRepo->getUsers([['is_admin',0]]);
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function(User $user) {
          $btn = '<a href="javascript:void(0)" data-user_id="'.$user->id.'"  class="btn btn-primary user-edit btn-sm">Edit</a>
                  <a href="javascript:void(0)" data-user_id="'.$user->id.'" class="btn btn-danger user-delete btn-sm ">Delete</a>';
          return $btn;
        })
        ->rawColumns(['action'])
        ->make(true);
     }
     
      return view('user.user-listing');
    }

    /**
    * Show the form for creating a new resource.
    */
    public function create() {}

    /**
    * Store a newly created resource in storage.
    */
    public function store(UserAddRequest $request) {

      $data = [
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
      ];
    
      $user = $this->userInterfaceRepo->createUser($data);

      return response()->json(['status' => 200, 'message' => 'User Add Successfully']);
    }

    /**
    * Display the specified resource.
    */
    public function show(string $id) {
    }

    /**
    * Show the form for editing the specified resource.
    */
    public function edit(string $id) {
      $result = $this->userInterfaceRepo->getUser([
        ['id',$id]
      ]);
      if ($result) {
        return response()->json(['status' => 200, 'message' => 'User Get Successfully', 'result' => $result]);
      } else {
        return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
      }
    }

    /**
    * Update the specified resource in storage.
    */
    public function update(UserUpdateRequest $request, string $id) {
      $data = [
        'name' => $request->name,
        'email' => $request->email,
      //  'password' => Hash::make($request->password),
      ];


      $this->userInterfaceRepo->updateUser([
        ['id', $id]
      ], $data);

      

      return response()->json(['status' => 200, 'message' => 'User Edit Successfully']);
    }

    /**
    * Remove the specified resource from storage.
    */
    public function destroy(string $id) {
      
      
      $result = $this->userInterfaceRepo->deleteUser([ ['id',$id]  ]);
      if ($result) {
        return response()->json(['status' => 200, 'message' => 'User Delete Successfully']);
      } else {
        return response()->json(['status' => 101, 'message' => 'Something Went Wrong']);
      }
    }

    // public function userImage =


}
