<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resident;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index()
    {
        // Debugging: Cek role user
        // dd(Auth::user()->role_id, Auth::user()->resident);

        // Untuk admin (role_id = 1) tampilkan semua aduan
        if (Auth::user()->role_id == 1) {
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
        $complaint = Complaint::with('resident.user')->findOrFail($id);

        // Cek akses: admin bisa akses semua, user hanya aduannya sendiri
        if (Auth::user()->role_id != 1) {
            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident || $complaint->resident_id != $resident->id) {
                return redirect()->route('complaint.index')
                    ->with('error', 'Anda tidak memiliki akses ke aduan ini.');
            }
        }

        return view('pages.complaint.show', compact('complaint'));
    }

    public function create()
    {
        // Hanya user biasa yang bisa membuat aduan
        if (Auth::user()->role_id == 1) {
            return redirect()->route('complaint.index')
                ->with('error', 'Admin tidak dapat membuat aduan.');
        }

        $resident = Resident::where('user_id', Auth::id())->first();

        if (!$resident) {
            return redirect()->route('complaint.index')
                ->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
        }

        return view('pages.complaint.create');
    }

    public function store(Request $request)
    {
        // Hanya user biasa yang bisa membuat aduan
        if (Auth::user()->role_id == 1) {
            return redirect()->route('complaint.index')
                ->with('error', 'Admin tidak dapat membuat aduan.');
        }

        $resident = Resident::where('user_id', Auth::id())->first();

        if (!$resident) {
            return redirect()->route('complaint.index')
                ->with('error', 'Akun anda tidak Terhubung dengan Data Penduduk mana pun.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'proof_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tambahkan resident_id ke data yang divalidasi
        $validated['resident_id'] = $resident->id;
        $validated['status'] = 'pending'; // Status default

        // Simpan foto jika ada
        if ($request->hasFile('proof_photo')) {
            $path = $request->file('proof_photo')->store('proof_photos', 'public');
            $validated['proof_photo'] = $path;
        }

        Complaint::create($validated);

        return redirect()->route('complaint.index')
            ->with('success', 'Aduan berhasil dikirim.');
    }

    public function edit($id)
    {
        $complaint = Complaint::with('resident.user')->findOrFail($id);

        // Cek akses: admin bisa akses semua, user hanya aduannya sendiri
        if (Auth::user()->role_id != 1) {
            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident || $complaint->resident_id != $resident->id) {
                return redirect()->route('complaint.index')
                    ->with('error', 'Anda tidak memiliki akses ke aduan ini.');
            }
        }

        return view('pages.complaint.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);

        // Cek akses: admin bisa akses semua, user hanya aduannya sendiri
        if (Auth::user()->role_id != 1) {
            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident || $complaint->resident_id != $resident->id) {
                return redirect()->route('complaint.index')
                    ->with('error', 'Anda tidak memiliki akses ke aduan ini.');
            }
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,process,completed',
            'proof_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('proof_photo')) {
            // Hapus foto lama jika ada
            if ($complaint->proof_photo) {
                Storage::disk('public')->delete($complaint->proof_photo);
            }

            $path = $request->file('proof_photo')->store('proof_photos', 'public');
            $validated['proof_photo'] = $path;
        }

        $complaint->update($validated);

        return redirect()->route('complaint.index')
            ->with('success', 'Aduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);

        // Cek akses: admin bisa akses semua, user hanya aduannya sendiri
        if (Auth::user()->role_id != 1) {
            $resident = Resident::where('user_id', Auth::id())->first();
            if (!$resident || $complaint->resident_id != $resident->id) {
                return redirect()->route('complaint.index')
                    ->with('error', 'Anda tidak memiliki akses ke aduan ini.');
            }
        }

        // Hapus foto jika ada
        if ($complaint->proof_photo) {
            Storage::disk('public')->delete($complaint->proof_photo);
        }

        $complaint->delete();

        return redirect()->route('complaint.index')
            ->with('success', 'Aduan berhasil dihapus.');
    }
}
