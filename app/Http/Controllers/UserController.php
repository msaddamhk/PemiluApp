<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:4048',
            'level' => 'required',
            'is_active' => 'required|boolean',
            'password' => 'required|min:8|confirmed',
        ]);


        $request->photo?->store('public/img/users');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'photo' => $request->photo?->hashName(),
            'level' => $request->level,
            'is_active' => $request->is_active,
            'password' => bcrypt($request->password),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'level' => 'required',
            'is_active' => 'required|boolean',
            'password' => 'nullable|min:8',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('photo')) {
            Storage::delete('public/img/users/' . $user->photo);
            $request->photo->store('public/img/users');
            $user->photo = $request->photo->hashName();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->level = $request->level;
        $user->is_active = $request->is_active;
        $user->updated_by = auth()->user()->id;

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
