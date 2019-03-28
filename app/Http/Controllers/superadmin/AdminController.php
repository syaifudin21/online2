<?php

namespace App\Http\Controllers\superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:superadmin');
    }
    public function index()
    {
        $admins = Admin::all();
        return view('superadmin.admin', compact('admins'));
    }
    public function create()
    {
        return view('superadmin.admin-tambah');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:6|confirmed|alpha_num',
        ]);
        $adnim = new Admin();
        $adnim->fill($request->all());
        $adnim['password'] = Hash::make($request->password);
        $adnim['akses'] = (!empty($request->akses))?implode(',', $request['akses']):'';
        $adnim->save();

        if($adnim){
            return redirect($request->redirect)
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('superadmin.admin-edit', compact('admin'));
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,id,'.$request->id,
        ]);

        $admin =Admin::findOrFail($request->id);
        $admin->fill($request->except('password'));
        if (!empty($request->password)) {
            $this->validate($request, [
                'password' => 'required|string|min:6|confirmed|alpha_num',
            ]);
            $admin['password'] = Hash::make($request->password);
        }
        $admin['akses'] = (!empty($request->akses))?implode(',', $request['akses']):'';
        $admin->save();

        if($admin){
            return redirect($request->redirect)
            ->with(['alert'=> "'title':'Berhasil','text':'Data Berhasil Disimpan', 'icon':'success','buttons': false, 'timer': 1200"]);
        }else{
            return back()
            ->with(['alert'=> "'title':'Gagal Menyimpan','text':'Data gagal disimpan, periksa kembali data inputan', 'icon':'error'"])
            ->withInput($request->all());
        }
    }
    public function delete($id)
    {
        $admin = Admin::findOrFail($id);
        if (!empty($admin)) {
            $admin->delete();
            return response()->json(['kode'=>'00'], 200);
        }else{
            return response()->json(['kode'=>'01'], 200);
        }
    }
}
