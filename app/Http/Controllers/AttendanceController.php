<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\MemberMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Crypt;

class AttendanceController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            new Middleware('role:super_admin,admin'),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Kehadiran Member';
        $attendances = Attendance::whereDate('check_in_at', Carbon::today())->latest()->get();

        return view('dashboard.attendances.index', compact('title', 'attendances'));
    }

    public function all()
    {
        $title = 'Daftar Kehadiran Member';
        $attendances = Attendance::latest()->get();

        return view('dashboard.attendances.all', compact('title', 'attendances'));
    }

    public function scanQr(Request $request)
    {
        try {
            $encrypted = $request->qr;
            $decoded = json_decode(Crypt::decryptString($encrypted), true);

            if (!$decoded || !isset($decoded['expires_at'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR tidak valid.'
                ], 400);
            }

            if (now()->greaterThan($decoded['expires_at'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'QR Code sudah expired dan tidak bisa digunakan lagi.'
                ], 403);
            }

            $user = User::with('member')->findOrFail($decoded['user_id']);

            if (!$user->member->status || $user->member->status == 'inactive') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anggota member sedang tidak aktif.'
                ], 403);
            }
            if (!$user->member->status || $user->member->status !== 'active') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bukan anggota member Rey Fitnes.'
                ], 403);
            }

            $membership = MemberMembership::where('member_id', $decoded['member_id'])->where('status', 'active')->first();
            if (!$membership) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Membership Tidak Aktif.'
                ], 403);
            }

            return response()->json([
                'status' => 'success',
                'user' => [
                    'id' => $user->id,
                    'member_id' => $user->member->id,
                    'membership_id' => $membership->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'photo' => $user->image ? asset('storage/public/' . $user->image)  : '/homepage_assets/img/default-profil.png',
                    'membership' => $membership->membership->name,
                    'membership_end_date' => $membership->end_date,
                    'gender' => $user->gender = 'male' ? 'Laki-Laki' : 'Perempuan',
                    'phone' => $user->phone
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code tidak valid!',
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Kehadiran';
        return view('dashboard.attendances.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
        'user_id' => 'required',
        'member_id' => 'required',
        'membership_id' => 'required',
        ]);

        $validatedData['check_in_at'] = now();
        $validatedData['status'] = 'present';
        Attendance::create($validatedData);

        return redirect( route('attendances.create') )->with('success', 'Berhasil menambahkan data!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
