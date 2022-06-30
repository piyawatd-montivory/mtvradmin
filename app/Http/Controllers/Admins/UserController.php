<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;


class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // public function profile() {
    //     return view('admins.user.profile', ['user'=>User::find(Auth::id())]);
    // }

    // public function profileupdate(Request $request) {
    //     $user = User::find(Auth::id());
    //     if (!empty($request->input('password'))) {
    //         $user->password = Hash::make($request->password);
    //     }
    //     $user->name = $request->name;
    //     $user->save();

    //     Auth::guard('web')->logout();
    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();
    //     return redirect('/login');
    // }

    public function index()
    {
        return view('admins.user.index');
    }

    public function new()
    {
        return view('admins.user.form', [ 'user' => new User()]);
    }

    public function edit($id)
    {
        return view('admins.user.form', [ 'user' => User::find($id)]);
    }

    public function create(Request $request)
    {
        $user = new User();
        $this->updateDatabase($user, $request,'new');
        return redirect()->route('userindex')->with('success', 'user saved!');
    }

    public function checkEmail(Request $request)
    {
        $check = User::where('email', $request->input('email'))->count();
        $result['result'] = false;
        if ($check > 0) {
            $result['result'] = true;
        }
        return $result;
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $this->updateDatabase($user, $request,'edit');
        return redirect()->route('userindex')->with('success', 'user updated!');
    }

    public function updateDatabase(User $user, Request $request,$mode)
    {
        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->save();
    }

    public function delete($id, Request $request)
    {
        $user = User::find($id)->delete();
        return ['result'=>true];
    }

    public function list(Request $request)
    {
        // https://shareurcodes.com/blog/laravel%20datatables%20server%20side%20processing
        $columns = array(
            0 => 'firstname',
            1 => 'lastname',
            2 => 'email'
        );

        $totalData = User::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');


        $search = $request->input('search.value');

        $users = User::where('firstname', 'LIKE', "%{$search}%")
            ->orWhere('lastname', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->offset($start)
            ->limit($limit)
            ->orderBy($order, $dir)
            ->get();

        $totalFiltered = User::where('firstname', 'LIKE', "%{$search}%")
            ->orWhere('lastname', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->count();

        $data = array();
        if (!empty($users)) {
            foreach ($users as $user) {
                $edit = route('useredit', $user->id);
                $nestedData['id'] = $user->id;
                $nestedData['email'] = $user->email;
                $nestedData['firstname'] = $user->firstname;
                $nestedData['lastname'] = $user->lastname;
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );

        return $json_data;
    }
}
