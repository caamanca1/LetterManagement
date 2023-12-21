<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function loginAuth(Request $request) 
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);
        // if (Auth::attempt($user)) {
        //     if ($user->role == 'staff'){
        //         return redirect()->route('home.page')->with('success', 'Login Berhasil!');
        //     } else {
        //         return redirect()->back()->with('failed', 'proses login gagal, silahkan coba kembali dengan data yang benar!');
        //     }
        // }
        if (Auth::attempt($user)) {
            return redirect()->route('home.page')->with('success', 'Login Berhasil!');
        } else {
            return redirect()->back()->with('failed', 'proses login gagal, silahkan coba kembali dengan data yang benar!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Anda telah logout!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
    
        return view('home');  
    }

    public function Staffindex(Request $request)
    {
        $users = User::all();
        return view('userStaff.index', compact('users'));
        // $Search = $request->Search;
        // $search = User::get('name')->where('name','LIKE',"%".$Search."%")->paginate(10);
        // return view("userStaff.index", compact("search"));
        
    }
    
    public function Guruindex(Request $request)
    {
        $users = User::all();
        return view('userGuru.index', compact('users'));
        // $Search = $request->Search;
        // $search = User::get('name')->where('name','LIKE',"%".$Search."%")->paginate(10);
        // return view("userGuru.index", compact("search"));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function Staffcreate()
    {
        return view('userStaff.create');
    }

    public function Gurucreate()
    {
        return view('userGuru.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function Staffstore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
        ]);

        $password = substr($request->email, 0, 3).substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'staff',
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah Data!');
    }

    public function Gurustore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required',
        ]);

        $password = substr($request->email, 0, 3).substr($request->name, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => 'guru',
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambah Data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function Staffedit(User $user, $id)
    {
        $user = user::find($id);
        return view('userStaff.edit', compact('user'));
    }

    public function Guruedit(User $user, $id)
    {
        $user = user::find($id);
        return view('userGuru.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function Staffupdate(Request $request, $id)
    {
        $user = User::find($id);
            if (!$user) {
                return redirect()->route('userStaff.home')->with('error', 'Akun tidak ditemukan.');
            }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'staff',
        ]);

        if ($request->password) {
            // $password = substr($request->email, 0, 3).substr($request->name, 0, 3);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'role' => $request->role,
            ]);
        }

        return redirect()->route('userStaff.home')->with('success', 'Akun berhasil diperbarui.');

    }

    public function Guruupdate(Request $request, $id)
    {
        $user = User::find($id);
            if (!$user) {
                return redirect()->route('userGuru.home')->with('error', 'Akun tidak ditemukan.');
            }

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'guru',
        ]);

        if ($request->password) {
            // $password = substr($request->email, 0, 3).substr($request->name, 0, 3);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                // 'role' => $request->role,
            ]);
        }

        return redirect()->route('userGuru.home')->with('success', 'Akun berhasil diperbarui.');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->back()->with('deleted', 'Berhasil Menghapus Data!');
    }
}