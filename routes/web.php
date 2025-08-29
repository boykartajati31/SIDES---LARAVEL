<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\RwController;


// Define the routes for authentication and resident management

// Route publik (login, register, dll)
Route::get('/', [AuthController::class, 'login']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('register', [AuthController::class, 'registerView']);
Route::post('register', [AuthController::class, 'register']);

// Route khusus admin
    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    })->middleware('role:admin,user');

        Route::get('/notifications', function () {
            return view('pages.notifications');
        });
        Route::post('/notification/{id}/read', function ($id) {
        $notification = \Illuminate\Support\Facades\DB::table('notifications')->where('id', $id);
        $notification->update([
            'read_at'   => \Illuminate\Support\Facades\DB::raw('CURRENT_TIMESTAMP'),
        ]);

        $dataArray = json_decode($notification->firstOrFail()->data, true);
        if (isset($dataArray['complaint_id'])) {
            return redirect('/complaint');
        }
            return back();

    })->middleware('role:admin,user');

    Route::get('/resident', [App\Http\Controllers\ResidentController::class, 'index'])->middleware('role:admin');
    Route::get('/resident/create', [App\Http\Controllers\ResidentController::class, 'create'])->middleware('role:admin');
    Route::post('/resident', [App\Http\Controllers\ResidentController::class, 'store'])->middleware('role:admin');
    Route::get('/resident/{id}/edit', [App\Http\Controllers\ResidentController::class, 'edit'])->middleware('role:admin');
    Route::put('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'update'])->middleware('role:admin');
    Route::delete('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'destroy'])->middleware('role:admin');
    Route::get('/resident/{id}', [App\Http\Controllers\ResidentController::class, 'show'])->middleware('role:admin');

    Route::get('/account-list', [App\Http\Controllers\UserController::class, 'account_list_view'])->middleware('role:admin');

    Route::get('/account-requests', [App\Http\Controllers\UserController::class, 'account_request_view'])->middleware('role:admin');
    Route::post('/account-requests/approval/{id}', [App\Http\Controllers\UserController::class, 'account_approval'])->middleware('role:admin');

    Route::get('/change-password', [App\Http\Controllers\UserController::class, 'change_password_view'])->middleware('role:admin,user');
    Route::post('/change-password/{id}', [App\Http\Controllers\UserController::class, 'change_password'])->middleware('role:admin,user');
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile_view'])->middleware('role:admin,user');
    Route::post('/profile/{id}', [App\Http\Controllers\UserController::class, 'update_profile'])->middleware('role:admin,user');

    Route::get('/complaint', [App\Http\Controllers\ComplaintController::class, 'index'])->middleware('role:admin,user');
    Route::get('/complaint/create', [App\Http\Controllers\ComplaintController::class, 'create'])->middleware('role:user');
    Route::post('/complaint', [App\Http\Controllers\ComplaintController::class, 'store'])->middleware('role:user');
    Route::get('/complaint/{id}/edit', [App\Http\Controllers\ComplaintController::class, 'edit'])->middleware('role:user');
    Route::put('/complaint/{id}', [App\Http\Controllers\ComplaintController::class, 'update'])->middleware('role:user');
    Route::delete('/complaint/{id}', [App\Http\Controllers\ComplaintController::class, 'destroy'])->middleware('role:user');
    Route::get('/complaint/{id}', [App\Http\Controllers\ComplaintController::class, 'show'])->middleware('role:user');
    Route::post('/complaint/update-status/{id}', [App\Http\Controllers\ComplaintController::class, 'update_status'])->middleware('role:admin');
    Route::resource('complaint', ComplaintController::class)->middleware('auth');

    Route::get('/rw-unit', [App\Http\Controllers\RwController::class, 'index'])->middleware('role:admin');
    Route::get('/rw-unit/create', [App\Http\Controllers\RwController::class, 'create'])->middleware('role:admin');
    Route::post('/rw-unit', [App\Http\Controllers\RwController::class, 'store'])->middleware('role:admin');
    Route::get('/rw-unit/{id}/edit', [App\Http\Controllers\RwController::class, 'edit'])->middleware('role:admin');
    Route::put('/rw-unit/{id}', [App\Http\Controllers\RwController::class, 'update'])->middleware('role:admin');
    Route::delete('/rw-unit/{id}', [App\Http\Controllers\RwController::class, 'destroy'])->middleware('role:admin');
    Route::get('/rw-unit/{id}', [App\Http\Controllers\RwController::class, 'show'])->middleware('role:admin');
