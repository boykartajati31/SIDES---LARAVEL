<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function account_request_view()
    {
        // Mengambil semua user dengan status 'submitted'
        $users = User::where('status', 'submitted')->get();

        // Mengirim data user ke view
        return view('pages.account-request.index', [
            'users' => $users
        ]);
    }

    public function account_approval(Request $request, $userId)
    {
        $for = $request->input('for');

        $user = User::findOrFail($userId);
        $user->status = ($for == 'approve' || $for == 'activate') ? 'approved' : 'rejected';
        $user->save();

        if($for == 'activate') {
            return back()->with('success','Success Activate account');
        } else if ( $for == 'deactivate' )
            return back()->with('success','Success Non-Activate account');

        return back()->with('success', $for == 'approve' ? 'Success approvad account' : 'Success rejected account');
    }

    public function account_list_view()
    {
        $users = User::where('role_id', 2)->where('status', '!=', 'submitted')->get();

        return view('pages.account-list.index', [
            'users' => $users,
        ]);
    }
}
