<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resident;
use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    //
    public function index()
    {
        // Menggunakan eager loading dan relationship
    $complaints = Auth::user()->complaints()->paginate(2);
    return view('pages.complaint.index', compact('complaints'));
    }

    public function create()
    {
        return view('pages.complaint.create');
    }


    public function show($id)
    {
        // Logic to show a specific resident
        $complaint = Complaint::findOrFail($id);
        return view('pages.complaint.edit', [
            'complaint' => $complaint
        ]);
    }

    public function edit($id)
    {
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

        try {
            $complaint = Complaint::findOrFail($id);

            // Authorization check - hanya pemilik atau admin yang bisa update
            if (Auth::user()->role !== 'admin') {
                $resident = Resident::where('user_id', Auth::id())->first();

                // if (!$resident || $complaint->resident_id !== $resident->id) {
                //     abort(403, 'Unauthorized action.');
                // }
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
        catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
                return redirect()->back()->withInput()->with('error', 'Data resident tidak ditemukan.');
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
        $complaint = Complaint::findOrFail($id);

        // Tambahkan authorization check - hanya pemilik atau admin yang bisa hapus
        if (Auth::user()->role !== 'admin') {
            $resident = Resident::where('user_id', Auth::id())->first();

            if (!$resident || $complaint->resident_id !== $resident->id) {
                abort(403, 'Unauthorized action.');
            }
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
