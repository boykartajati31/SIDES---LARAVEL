<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function account_request_view()
    {
        // Mengambil semua user dengan status 'submitted'
        $users = User::where('status', 'submitted')->get();
        $residents = Resident::where('user_id', null)->get();

        // Mengirim data user ke view
        return view('pages.account-request.index', [
            'users' => $users,
            'residents' => $residents,
        ]);
    }

    public function account_approval(Request $request, $userId)
    {
        $request->validate([
            'for' => ['required', Rule::in(['approve', 'reject', 'activate', 'deactivate'])],
            'resident_id' => ['nullable', 'exists:residents,id']
        ]);

        $for = $request->input('for');

        $user = User::findOrFail($userId);
        $user->status = ($for == 'approve' || $for == 'activate') ? 'approved' : 'rejected';
        $user->save();

        $resident_id = $request->input('resident_id');

        if ($request->has('resident_id') && isset ($resident_id)) {
            Resident::where('id', $resident_id)->update([
                'user_id' => $user->id,
            ]);
        }

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
