<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Requests\Admin\DetailRequest;
use App\Services\Admin\AdminService;
use Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }
    public function index()
    {
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
        $data = $request->all();
        $loginStatus = $this->adminService->login($data);

        if($loginStatus==1){
            return redirect()->route('dashboard.index');
        }else{
            return redirect()->back()->with('error_message', 'Invalid Email or Password');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        Session::put('page', 'update-password');
        return view('admin.update_password');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function verifyPassword(Request $request)
    {
        $data = $request->all();
        return $this->adminService->verifyPassword($data);
    }
    public function updatePasswordRequest(PasswordRequest $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->input();

            $pwdStatus = $this->adminService->updatePassword($data);

            if ($pwdStatus['status'] == "success") {
                return redirect()->back()->with('success_message', $pwdStatus['message']);
            } else {
                return redirect()->back()->with('error_message', $pwdStatus['message']);
            }
        }
    }
    public function editDetails(){
        Session::put('page', 'update-details');
        return view('admin.update_details');
    }
    public function updateDetails(DetailRequest $request){
        Session::put('page', 'update-details');
        if($request->isMethod('post')){
            $this->adminService->updateDetails($request);
            return redirect()->back()->with('success_message', 'Admin Details have been updated successfully!');
        }
    }
    public function deleteProfileImage(Request $request)
    {
        $status = $this->adminService->deleteProfileImage($request->admin_id);
        return response()->join($status);
    }
    public function subadmins(){
        Session::put('page', 'subadmins');
        $subadmins = $this->adminService->subadmins();
        return view('admin.subadmins.subadmins')->with(compact('subadmins'));
    }
    public function updateSubadminStatus(Request $request)
    {
        if ($request->ajax()) {

        $data = $request->all();

        $status = $this->adminService->updateSubadminStatus($data);

            return response()->json([
                'status' => $status,
                'subadmin_id' => $data['subadmin_id']
            ]);
        }
    }
}
