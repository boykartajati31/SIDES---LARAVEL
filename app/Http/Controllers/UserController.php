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
        $user->status = $for == 'approve' ? 'approved' : 'rejected';
        $user->save();

        return back()->with('success', $for == 'approve' ? 'Success approvad account' : 'Success rejected account');
    }
}
