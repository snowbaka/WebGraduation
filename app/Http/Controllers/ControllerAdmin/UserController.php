<?php

namespace App\Http\Controllers\ControllerAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    /**
     * active menu
     */
    public function __construct()
    {
        view()->share([
            'user_menu' => true,
        ]);
    }

    public function index()
    {
        $datas = User::orderBy('updated_at', 'DESC')->get();
        return view('admin.user.index', compact('datas'));
    }


    public function create()
    {
        return view('admin.user.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'txtName' => 'required|max:255',
            'txtEmail' => 'required|email|max:255|unique:users,email',
            'txtPassword' => 'required|confirmed|min:6',
        ], [
            'txtName.required' => 'You have not entered a name',
            'txtName.max' => 'The name can only be up to 255 characters',
            'txtEmail.required' => 'You have not entered Email',
            'txtEmail.unique' => 'This e-mail is already taken',
            'txtEmail.max' => 'Email maximum 255 characters',
            'txtEmail.email' => 'Email format incorrect',
            'txtPassword.required' => 'You have not entered the password',
            'txtPassword.confirmed' => 'Password mismatch',
            'txtPassword.min' => 'Password must be at least 6 characters',
        ]);

        User::create([
            'name' => $request->txtName,
            'email' => $request->txtEmail,
            'password' => bcrypt($request->txtPassword),
            'level' => $request->txtLevel,
            'status' => 1,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'New story added successfully !');
    }

    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.index')->with('danger','Data does not exist');
        }
        return view('admin.user.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'txtName' => 'required|max:255',
            'txtEmail' => 'required|email|max:255',
            'txtPassword' => 'nullable|confirmed|min:6',
        ], [
            'txtName.required' => 'You have not entered a name',
            'txtName.max' => 'The name can only be up to 255 characters',
            'txtEmail.required' => 'You have not entered Email',
            'txtEmail.max' => 'Email maximum 255 characters',
            'txtEmail.email' => 'Email format incorrect',
            'txtPassword.confirmed' => 'Password mismatch',
            'txtPassword.min' => 'Password must be at least 6 characters',
        ]);
        
        $user = User::find($id);
        $user->name = $request->txtName;
        $user->email = $request->txtEmail;
        if(!empty($request->txtPassword)) $user->password = bcrypt($request->txtPassword);
        $user->level = $request->txtLevel;
        $user->status = 1;

        if ($user->save()) {
            return redirect()->route('admin.user.update', $id)->with('success','Successful editing');
        } else {
            return redirect()->route('admin.user.index')->with('danger', 'An non-editable error has occurred');
        }
    }


    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.user.index')->with('danger','Data does not exist');
        }

        $user->delete();

        return redirect()->route('admin.user.index')->with('success','Deleted successfully');
    }

    /**
     * Đổi mật khẩu
     */
    public function passwordChange(Request $request)
    {
        $this->validate($request, [
            'txtPassword' => 'confirmed|min:6',
        ], [
            'txtPassword.confirmed' => 'Password mismatch',
            'txtPassword.min' => 'Password must be at least 6 characters',
        ]);
        $user = User::find(\Auth::user()->id);
        $user->password = bcrypt($request->txtPassword);
        $user->save();
        return redirect()->route('dashboard.changepassword')->with('success', 'Password successfully changed !');

    }
}
