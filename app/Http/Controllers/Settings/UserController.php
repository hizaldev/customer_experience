<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Constant\ConstantController;
use App\Http\Controllers\Controller;
use App\Models\Locations;
use App\Models\User;
use App\Models\Voltages;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{
    var $route = 'users';
    var $path_view = 'settings.user';

    function __construct()
    {
        $this->middleware('permission:settings_user-list-all|settings_user-list|settings_user-create|settings_user-edit|settings_user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:settings_user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:settings_user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:settings_user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = User::get();
            return DataTables::of($data)
                ->addColumn('role', function ($userRole) {
                    if (!empty($userRole->getRoleNames())) {
                        foreach ($userRole->getRoleNames() as $role) {
                            // Code Here
                            return '<span class="btn-inverse-info py-1 px-2">' . $role . '</span>';
                        }
                    } else {
                        return '';
                    }
                })
                ->addColumn('edit', function ($item) {
                    return '
                    
                        <a class="btn btn-success btn-sm btn-icon w-100 text-white" href="' . route("$this->route.edit", $item->id) . '">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z"></path>
                                <path d="M16 5l3 3"></path>
                                <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6"></path>
                            </svg>
                        </a>
                    ';
                })
                ->addColumn('delete', function ($item) {
                    return '
                        <form action="' . route("$this->route.destroy", $item->id) . '" method="POST" id="form" class="form-inline" onSubmit="if (confirm(`Apakah anda yakin menghapus data? Data yang sudah dihapus tidak dapat dikembalikan dan akan berpengaruh ke transaksi untuk user ini`)) run; return false">
                            ' . method_field('delete') . csrf_field() . '
                            <button type="submit" class="btn btn-danger btn-sm btn-icon text-white w-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M4 7l16 0"></path>
                                    <path d="M10 11l0 6"></path>
                                    <path d="M14 11l0 6"></path>
                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                </svg>
                            </button>
                        </form>
                    ';
                })
                ->addIndexColumn()
                ->rawColumns(['edit', 'delete', 'role'])
                ->make();
        }
        return view("$this->path_view.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = Role::whereNotIn('name', ['SuperAdmin'])->get();
        $unit = Locations::where('nlevel', 2)->get();
        return view("$this->path_view.create", [
            'role' => $role,
            'unit' => $unit,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
            'role_id' => 'required'
        ]);

        try {
            $data['user_id'] = Str::uuid();
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['password'] = bcrypt($request->passwod);
            $create = User::create($data);
            $create->assignRole([$request->role_id]);
            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }

        return redirect()->route($this->route . '.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $items = User::findOrFail($id);
        return view("$this->path_view.show", [
            'item' => $items,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = User::find($id);
        $role = Role::whereNotIn('name', ['SuperAdmin'])->get();
        $unit = $item->level_upt != null ? Locations::where('nlevel', 2)->where('id', $item->level_upt)->get() : Locations::where('nlevel', 2)->get();
        $ultg = $item->level_ultg != null ? Locations::where('parent_id', $item->level_upt)
            ->where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0d8e-4ce8-b809-9b7ff557a338')
            ->get() : [];
        $garduInduk = $item->level_substation != null ? Locations::where('section_id', $item->level_ultg)
            ->where('nlevel', 3)
            ->where('fungsi_id', '9a6ae5a7-0f5f-4cb1-a117-d14792d30537')
            ->get() : [];
        return view("$this->path_view.edit", [
            'item' => $item,
            'role' => $role,
            'unit' => $unit,
            'ultg' => $ultg,
            'gardu_induk' => $garduInduk,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);
        // dd($id);

        try {
            $data['email'] = $request->email;
            $data['name'] = $request->name;
            $data['level_upt'] = $request->level_upt;
            $data['level_ultg'] = $request->level_ultg;
            if ($request->level_substation) {
                $substation = array();
                $total = count($request->level_substation);
                for ($i = 0; $i < $total; $i++) {
                    $substation[] = "'" . $request->level_substation[$i] . "'";
                }
                $data['level_substation'] = implode(',', $substation);
            } else {
                $data['level_substation'] = null;
            }
            $induk = Locations::where('id', $request->level_upt)->first();
            if ($induk != null) {
                $data['level_induk'] = $induk->parent_id;
            } else {
                ConstantController::errorAlert('Data Induk tidak ditemukan berdasarkan unit yang dipilih cek kembali kesesuian data hubungi administrator');
            }
            $item = User::where('user_id', $id)->first();
            $item->update($data);
            if ($request->role_id) {
                $item->assignRole([$request->role_id]);
            }

            ConstantController::successAlert();
        } catch (Exception $e) {
            ConstantController::errorAlert($e->getMessage());
        }

        return redirect()->route($this->route . '.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }
}
