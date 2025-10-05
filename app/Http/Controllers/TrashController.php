<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\JsonResponse;

class TrashController extends Controller
{
    /**
     * Sadece admin erişebilir
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->role !== 'admin') {
                abort(403, 'Bu sayfaya erişim yetkiniz yok. Sadece admin erişebilir.');
            }
            return $next($request);
        });
    }

    // 🧾 Silinen Müşteriler Sayfası
    public function customers()
    {
        return view('trash.trashed_customers');
    }

    // 👤 Silinen Kullanıcılar Sayfası
    public function users()
    {
        return view('trash.trashed_users');
    }

    // 📊 Silinen Müşteriler DataTables JSON verisi
    public function dataCustomers()
    {
        $query = Customer::onlyTrashed()->with(['creator', 'updater', 'deleter']);

        return DataTables::of($query)
            ->addColumn('created_at', function ($customer) {
                return $customer->created_at ? $customer->created_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('updated_at', function ($customer) {
                return $customer->updated_at ? $customer->updated_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('deleted_at', function ($customer) {
                return $customer->deleted_at ? $customer->deleted_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('creator_name', function ($customer) {
                return $customer->creator ? $customer->creator->name : '-';
            })
            ->addColumn('updater_name', function ($customer) {
                return $customer->updater ? $customer->updater->name : '-';
            })
            ->addColumn('deleter_name', function ($customer) {
                return $customer->deleter ? $customer->deleter->name : '-';
            })
            ->addColumn('actions', function ($row) {
                return '
                    <button class="btn btn-success btn-sm restoreBtn" data-id="' . $row->id . '">Geri Yükle</button>
                    <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row->id . '">Kalıcı Sil</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // 📊 Silinen Kullanıcılar DataTables JSON verisi
    public function dataUsers(): JsonResponse
    {
        $query = User::onlyTrashed();

        return DataTables::of($query)
            ->addColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('updated_at', function ($user) {
                return $user->updated_at ? $user->updated_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('deleted_at', function ($user) {
                return $user->deleted_at ? $user->deleted_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('actions', function ($row) {
                return '
                <button class="btn btn-success btn-sm restoreBtn" data-id="' . $row->id . '">Geri Yükle</button>
                <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row->id . '">Kalıcı Sil</button>
            ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    // ♻️ Geri Yükleme
    public function restore($type, $id)
    {
        $model = $type === 'customers' ? Customer::onlyTrashed()->findOrFail($id)
            : User::onlyTrashed()->findOrFail($id);
        $model->restore();
        return response()->json(['message' => 'Kayıt başarıyla geri yüklendi.']);
    }

    // 🚮 Kalıcı Silme
    public function forceDelete($type, $id)
    {
        $model = $type === 'customers' ? Customer::onlyTrashed()->findOrFail($id)
            : User::onlyTrashed()->findOrFail($id);
        $model->forceDelete();
        return response()->json(['message' => 'Kayıt kalıcı olarak silindi.']);
    }
}
