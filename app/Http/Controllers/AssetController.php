<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Asset;
use App\Models\Department;
use App\Models\User;

class AssetController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => []]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $assets = Asset::get();
        return view('admin.assets.index', compact('assets'));
    }

    public function add()
    {
        return view('admin.assets.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:assets'],
            'category' => ['required', 'string', 'max:255'],
        ]);

        $asset_data = array(
            'name' => $request->name,
            'category' => $request->category,
        );

        Asset::create($asset_data);

        Session::flash('success_message','Successfully saved');

        return redirect('admin/assets');
    }

    public function edit($id)
    {
        $asset = Asset::where('id', $id)->first();
        if (!$asset) abort(404);
        return view('admin.assets.edit', compact('asset'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:assets,name,'.$id,
            'category' => ['required', 'string', 'max:255'],
        ]);

        $asset_data = array(
            'name' => $request->name,
            'category' => $request->category,
        );

        Asset::where('id', $id)->update($asset_data);

        Session::flash('success_message','Successfully updated');

        return redirect('admin/assets/edit/'.$id);
    }

    public function destroy($id)
    {
        $delete = Asset::where('id', $id)->delete();

        if ($delete) {
            Session::flash('success_message','Successfully deleted');
            echo "success";
        }
    }

    public function assignAssetsIndex()
    {
        $users = User::where('is_admin', 0)->orWhereNull('is_admin')->get();
        return view('admin.assets.assign_asset_index', compact('users'));
    }

    public function assignAssetsAdd($id)
    {
        $user = User::where('id', $id)->where('is_admin', 0)->first();
        $available_assets = Asset::where('assigned_to', 0)->get();
        if (!$user) abort(404);
        return view('admin.assets.assign_asset_add', compact('user', 'available_assets'));
    }

    public function assignAssetsUpdate(Request $request, $id)
    {
        foreach ($request->assign_assets as $asset_id) {
            echo $asset_id."<br>";
            // Check if asset is already assigned
            $check = Asset::where('id', $asset_id)->where('assigned_to', 0)->first();
            if ($check) {
                $assigned_time = date("Y-m-d H:i:s");
                $update_asset = Asset::where('id', $asset_id)->update(['assigned_to' => $id, 'assigned_time' => $assigned_time]);
            }
        }
        if ($update_asset) {
            Session::flash('success_message','Successfully updated');
        }
        return redirect('admin/assign_assets/'.$id);
    }

    public function assignAssetsDestroy($id)
    {
        $delete = Asset::where('id', $id)->update(['assigned_to' => 0, 'assigned_time' => NULL]);

        if ($delete) {
            Session::flash('success_message','Successfully deleted');
            echo "success";
        }
    }
}
