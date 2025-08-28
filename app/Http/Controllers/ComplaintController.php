<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resident;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Notifications\ComplaintStatusChanged;

class ComplaintController extends Controller
{
    //
    public function index()
    {
        // Debugging: Cek role user
        // dd(Auth::user()->role_id, Auth::user()->resident);

        // Untuk admin (role_id = 1) tampilkan semua aduan
        if (Auth::user()->role_id == \App\Models\Role::role_admin) {
            $complaints = Complaint::with(['resident.user'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        // Untuk user biasa (role_id = 2) tampilkan hanya aduannya sendiri
        else {
            // Cek apakah user memiliki data resident
            $resident = Resident::where('user_id', Auth::id())->first();

            if (!$resident) {
                // Jika tidak ada data resident, tampilkan pesan error tanpa redirect
                $complaints = collect(); // collection kosong
                return view('pages.complaint.index', compact('complaints'))
                    ->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
            }

            $complaints = Complaint::where('resident_id', $resident->id)
                ->with('resident.user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return view('pages.complaint.index', compact('complaints'));
    }


    public function show($id)
    {
        // Logic to show a specific resident
         $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident) {
                return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
            }
        $complaint = Complaint::findOrFail($id);
         if ($complaint->status != 'new') {
                return redirect('/complaint')->with('error', "Gagal mengubah Status aduan, Status anda saat ini adalah $complaint->status_label ");
            }
        return view('pages.complaint.edit', [
            'complaint' => $complaint
        ]);
    }

    public function edit($id)
    {
        $resident = Resident::where('user_id', Auth::id())->first();
        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
        }

        $complaint = Complaint::findOrFail($id);
        return view('pages.complaint.create');
    }

    public function update(Request $request, $id )
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
            }

            $complaint = Complaint::findOrFail($id);
            if ($complaint->status != 'new') {
                return redirect('/complaint')->with('error', 'Gagal mengubah Status aduan, Status anda saat ini adalah "'. $complaint->status_label .'"');
            }

            $complaint->title = $request->input('title');
            $complaint->content = $request->input('content');

            if ($request->hasFile('photo_proof')) {
                // Hapus file lama jika ada
                if ($complaint->photo_proof && Storage::exists($complaint->photo_proof)) {
                    Storage::delete($complaint->photo_proof);
                }

                $filePath = $request->file('photo_proof')->store('public/uploads');
                $complaint->photo_proof = $filePath;
            }

            $complaint->save();
            return redirect('/complaint')->with('success', 'Berhasil mengubah Aduan');
    }

    public function update_status(Request $request, $id )
    {
        $request->validate([
            'status' => ['required', Rule::in(['new', 'processing', 'completed'])],
        ]);

            $resident = Resident::where('user_id', Auth::id())->first();
            if (Auth::user()->role_id == \App\Models\Role::role_user && !$resident ) {
            return redirect('/complaint')->with('Success', 'Berhasil Mengubah Status.');
            }

        try {
            $complaint = Complaint::findOrFail($id);
            $oldStatus = $complaint->status_label;
            $complaint->status = $request->input('status');
            $complaint->save();

            $newStatus = $complaint->status_label;

            User::where('id', $complaint->resident->user_id)->firstOrFail()->notify(new ComplaintStatusChanged($complaint, $oldStatus, $newStatus));

            return redirect('/complaint')->with('success', 'Berhasil mengubah Status');
        }
        catch (\Exception $e) {
            return redirect()->back()
            ->withInput()
            ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function create()
    {
        $resident = Resident::where('user_id', Auth::id())->first();
        if (!$resident) {
            return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
        }

        return view('pages.complaint.create');
    }


    public function store(Request $request )
    {
            $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content' => ['required', 'min:3', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        try {
            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident) {
                return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
            }

            $complaint = new Complaint();
            $complaint->resident_id      = $resident->id;
            $complaint->title            = $request->input('title');
            $complaint->content          = $request->input('content');

            if ($request->hasFile('photo_proof')) {
                // Simpan di folder 'public/uploads'
                $filePath = $request->file('photo_proof')->store('uploads', 'public');
                $complaint->photo_proof = 'uploads/'. basename($filePath);
            }

            $complaint->save();
            return redirect('/complaint')->with('success', 'Berhasil membuat Aduan');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: '. $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
        // PERBAIKI: findOrFile -> findOrFail
         $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident) {
                return redirect('/complaint')->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
            }

        $complaint = Complaint::findOrFail($id);
        if ($complaint->status != 'new') {
            return redirect('/complaint')->with('error', 'Gagal menghapus Status aduan, Status anda saat ini adalah "'. $complaint->status_label .'"');
        }
        // Hapus file foto jika ada
        if ($complaint->photo_proof && Storage::disk('public')->exists($complaint->photo_proof)) {
            Storage::disk('public')->delete($complaint->photo_proof);
        }

        $complaint->delete();

        return redirect('/complaint')->with('success', 'Berhasil menghapus Aduan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
