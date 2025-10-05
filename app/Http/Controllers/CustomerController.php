<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers.index');
    }

    public function data(Request $request)
    {
        $query = Customer::with(['creator', 'updater']);

        return DataTables::of($query)
            ->addColumn('created_at', function ($customer) {
                return $customer->created_at ? $customer->created_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('updated_at', function ($customer) {
                return $customer->updated_at ? $customer->updated_at->format('d.m.Y H:i') : '-';
            })
            ->addColumn('updater_name', function ($customer) {
                return $customer->updater ? $customer->updater->name : '-';
            })
            ->addColumn('actions', function ($customer) {
                $user = Auth::user();
                $buttons = '';

                if ($user->role !== 'staff') {
                    $buttons .= '<button class="btn btn-sm btn-primary editBtn" data-id="' . $customer->id . '">Düzenle</button> ';
                }

                // Admin ve Manager silme yapabilir
                if (in_array($user->role, ['admin', 'manager'])) {
                    $buttons .= '<button class="btn btn-sm btn-danger deleteBtn" data-id="' . $customer->id . '">Sil</button>';
                }

                return $buttons;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role === 'staff') {
            abort(403, 'Yetkiniz yok');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create([
            'code' => uniqid('CUST-'),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Müşteri başarıyla eklendi.', 'customer' => $customer]);
        }

        return response()->json([
            'success' => true,
            'action' => 'add',
            'message' => 'Müşteri başarıyla eklendi.'
        ]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        if (Auth::user()->role === 'staff') {
            abort(403, 'Yetkiniz yok');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'updated_by' => Auth::id(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Müşteri güncellendi.', 'customer' => $customer]);
        }

        return response()->json([
            'success' => true,
            'action' => 'edit',
            'message' => 'Müşteri başarıyla güncellendi.'
        ]);
    }

    public function destroy(Request $request, Customer $customer)
    {
        // Admin ve Manager silme yapabilir
        if (!in_array(Auth::user()->role, ['admin', 'manager'])) {
            abort(403, 'Silme yetkiniz yok');
        }

        $customer->deleted_by = Auth::id();
        $customer->delete_reason = $request->reason ?? 'Belirtilmedi';
        $customer->save();
        $customer->delete();

        return response()->json(['success' => true, 'message' => 'Müşteri silindi.']);
    }

    public function trashed()
    {
        return view('customers.trashed');
    }

    public function trashedData()
    {
        $query = Customer::onlyTrashed()->with(['creator', 'deleter']);

        return DataTables::of($query)
            ->addColumn('actions', function ($customer) {
                return '
                    <button class="btn btn-sm btn-success restoreBtn" data-id="' . $customer->id . '">Geri Yükle</button>
                    <button class="btn btn-sm btn-danger forceDeleteBtn" data-id="' . $customer->id . '">Kalıcı Sil</button>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function restore($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->restore();

        return response()->json(['success' => true, 'message' => 'Müşteri başarıyla geri yüklendi.']);
    }

    public function forceDelete($id)
    {
        $customer = Customer::onlyTrashed()->findOrFail($id);
        $customer->forceDelete();

        return response()->json(['success' => true, 'message' => 'Müşteri kalıcı olarak silindi.']);
    }
}
