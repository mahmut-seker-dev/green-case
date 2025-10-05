<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    /**
     * Kullanıcılar ana sayfası
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * DataTables verisi (aktif/silinmiş kullanıcılar)
     */
    public function data(Request $request)
    {
        $status = $request->get('status', 'active');

        $query = User::query();

        if ($status === 'deleted') {
            $query->onlyTrashed();
        }

        return DataTables::of($query)
            ->addColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('updated_at', function ($user) {
                return $user->updated_at ? $user->updated_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('actions', function ($row) use ($status) {
                if ($status === 'deleted') {
                    return '
                        <button class="btn btn-success btn-sm restoreUserBtn" data-id="' . $row->id . '">Geri Yükle</button>
                        <button class="btn btn-danger btn-sm forceDeleteUserBtn" data-id="' . $row->id . '">Kalıcı Sil</button>
                    ';
                }

                $buttons = '<button class="btn btn-primary btn-sm editUserBtn" data-id="' . $row->id . '">Düzenle</button>';
                
                // Kendi kullanıcısı için Sil butonunu gösterme
                if ($row->id != Auth::id()) {
                    $buttons .= ' <button class="btn btn-danger btn-sm deleteUserBtn" data-id="' . $row->id . '">Sil</button>';
                }
                
                return $buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Yeni kullanıcı oluşturma
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'Kullanıcı başarıyla eklendi.']);
    }
    public function create()
    {
        return view('users.create');
    }
    /**
     * Kullanıcıyı düzenleme
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return response()->json(['message' => 'Kullanıcı bilgileri güncellendi.']);
    }

    /**
     * Kullanıcı düzenleme sayfası
     */
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('users.edit', compact('user'));
    }


    /**
     * Kullanıcıyı soft delete ile sil
     */
    public function destroy($id)
    {
        // Admin ve Manager silme yapabilir
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Silme yetkiniz yok');
        }

        // Kendini silemez
        if (Auth::id() == $id) {
            return response()->json(['message' => 'Kendi kullanıcınızı silemezsiniz!'], 403);
        }

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Kullanıcı başarıyla silindi (soft delete).']);
    }

    /**
     * Silinmiş kullanıcıyı geri yükle
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return response()->json(['message' => 'Kullanıcı başarıyla geri yüklendi.']);
    }

    /**
     * Kalıcı olarak sil
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return response()->json(['message' => 'Kullanıcı kalıcı olarak silindi.']);
    }
}
