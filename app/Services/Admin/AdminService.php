<?php

namespace App\Services\Admin;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Admin;

use Auth;
use Hash;

 class AdminService {
 	  public function login($data) {

        $admin = Admin::where('email', $data['email'])->first();

        if ($admin) {

            if ($admin->status == 0) {
                return "inactive"; // Return status if the account is inactive
            }

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {

            // Remember Admin Email and Password
            if (!empty($data["remember"])) {
                setcookie("email", $data["email"], time() + 3600);
                setcookie("password", $data["password"], time() + 3600);
            } else {
                setcookie("email", "");
                setcookie("password", "");
            }

            return "success"; // Return success if login is successful

            } else {
                return "invalid"; // Return invalid if credentials are incorrect
            }

            } else {
                return "invalid"; // Return invalid if email is not found
        }
    }
 	public function verifyPassword($data)
 	{
 		if(Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)){
 			return "true";
 		} else {
 			return "false";
 		}
 	}
 	public function updatePassword($data)
	{
    // Check if Current Password is correct
    if (Hash::check(
        $data['current_pwd'],
        Auth::guard('admin')->user()->password
    )) {

        // Check new password and confirm password
        if ($data['new_pwd'] == $data['confirm_pwd']) {

            Admin::where(
                'email',
                Auth::guard('admin')->user()->email
            )->update([
                'password' => bcrypt($data['new_pwd'])
            ]);

            $status = "success";
            $message = "Password has been updated successfully!";

        } else {

            $status = "error";
            $message = "New Password and Confirm Password must match!";
        }

    } else {

        $status = "error";
        $message = "Your current password is incorrect!";
    }

    return [
        'status' => $status,
        'message' => $message
    ];

	}
	public function updateDetails($request)
    {
        $data = $request->all();

        // Start with existing image (if any)
        $imageName = $data['current_image'] ?? (Auth::guard('admin')->user()->image ?? null);

        // If new image uploaded, replace it
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

        if ($image_tmp && $image_tmp->isValid()) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_tmp);

            $extension = $image_tmp->getClientOriginalExtension();
            $imageName = rand(111, 9999) . '.' . $extension;

            $image_path = 'admin/images/photos/' . $imageName;

            // Make sure directory exists or this will fail
            $image->save($image_path);
        }
    }

        Admin::where('email', Auth::guard('admin')->user()->email)->update([
            'name' => $data['name'],
            'mobile' => $data['mobile'],
            'image' => $imageName,
        ]);
    }

    public function deleteProfileImage($adminId)
    {
        $profileImage = Admin::where('id', $adminId)->value('image');

        if ($profileImage) {
            $profile_image_path = 'admin/images/photos/' . $profileImage;

            if (file_exists(public_path($profile_image_path))) {
                unlink(public_path($profile_image_path));
            }

            Admin::where('id', $adminId)->update(['image' => null]);

            return [
                'status' => true,
                'message' => 'Profile image deleted successfully!'
            ];
        }

        return [
            'status' => false,
            'message' => 'Profile image not found!'
        ];
    }

    public function subadmins(){
        $subadmins = Admin::where('role', 'subadmin')->get();

        return $subadmins;
    }
    public function updateSubadminStatus($data){
        $status = ($data['status'] == "Active") ? 0 : 1;
        Admin::where('id', $data['subadmin_id'])->update(['status'=>$status]);
        return $status;
    }
    public function deleteSubadmin($id)
    {
        // Delete Sub Admin
        $deleted = Admin::where('id', $id)->delete();

        $message = $deleted
            ? 'Subadmin deleted successfully'
            : 'Subadmin not found';

        return [
            'message' => $message
        ];
    }

public function addEditSubadmin($request)
{
    $data = $request->all();

    // Add or Update
    if (isset($data['id']) && $data['id']!="") {
        $subadmindata = Admin::find($data['id']);
        $message = "Subadmin updated successfully!";
     } else {
        $subadmindata = new Admin;
        $message = "Subadmin added successfully!";
     }

    // Upload Admin Image
    if ($request->hasFile('image')) {
        $image_tmp = $request->file('image');

        if ($image_tmp->isValid()) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_tmp);

            $extension = $image_tmp->getClientOriginalExtension();
            $imageName = rand(111, 99999) . '.' . $extension;

            $image_path = 'admin/images/photos/' . $imageName;
            $image->save($image_path);
        }
    } else if(!empty($data['current_image'])){
        $imageName = $data['current_image'];
    }else{
        $imageName = "";
    }

    // Assign image
    $subadmindata->image = $imageName;
    $subadmindata->name   = $data['name'];
    $subadmindata->mobile = $data['mobile'];

    // Only for New Subadmin
    if (!isset($data['id'])) {
        $subadmindata->email = $data['email'];
        $subadmindata->role  = 'subadmin';
        $subadmindata->status = 1;
    }

    // Password
    if ($data['password']!="") {
        $subadmindata->password = bcrypt($data['password']);
    }

        $subadmindata->save();
        return array("message"=>$message);
    }
}