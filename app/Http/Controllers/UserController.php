<?php

namespace App\Http\Controllers;

use App\Models\KoorKecamatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $userLevel = auth()->user()->level;
        // switch ($userLevel) {
        //     case 'KOOR_KOTA':
        //         $users = User::all();
        //         return view('admin.index', compact('users'));
        //     case 'KOOR_KECAMATAN':
        //         $kecamatan = KoorKecamatan::where('user_id', auth()->user()->id)->first();
        //         $users = User::whereHas('koorDesa', function ($query) use ($kecamatan) {
        //             $query->where('koor_kecamatan_id', $kecamatan->id);
        //         })->orWhereHas('tps', function ($query) use ($kecamatan) {
        //             $query->whereIn('koor_desa_id', function ($subQuery) use ($kecamatan) {
        //                 $subQuery->select('id')->from('koor_desa')->where('koor_kecamatan_id', $kecamatan->id);
        //             });
        //         })->get();


        //         return view('admin.index', compact('users'));
        // }

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
            'photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'level' => Rule::requiredIf(auth()->user()->level == 'GENERAL'),
            'is_active' => 'required|boolean',
            'password' => 'required|min:8|confirmed',
        ]);

        $request->photo?->store('public/img/users');

        $level = '';
        switch (auth()->user()->level) {
            case 'KOOR_KOTA':
                $level = "KOOR_KECAMATAN";
                break;
            case 'KOOR_KECAMATAN':
                $level = "KOOR_DESA";
                break;
            case 'KOOR_DESA':
                $level = "KOOR_TPS";
                break;
            default:
                $level = $request->level;
                break;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'photo' => $request->photo ? $request->photo->hashName() : null,
            'level' => $level,
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
            'level' => Rule::requiredIf(auth()->user()->level == 'GENERAL'),
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
        $user->is_active = $request->is_active;
        $user->updated_by = auth()->user()->id;

        if ($user->level !== $request->level) {
            $user->level = $request->level;
            if ($user->koorKota()->exists()) {
                $user->koorKota->update(['user_id' => null]);
            }

            if ($user->koorKecamatan()->exists()) {
                $user->koorKecamatan->update(['user_id' => null]);
            }

            if ($user->koorDesa()->exists()) {
                $user->koorDesa->update(['user_id' => null]);
            }

            if ($user->tps()->exists()) {
                $user->tps->update(['user_id' => null]);
            }
        }

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
