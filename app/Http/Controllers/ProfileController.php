<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\ClassBooking;
use App\Models\GymClass;
use App\Models\Membership;
use App\Models\Trainer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth'
        ];
    }

    public function index()
    {
        $title = 'Profile';

        $user = Auth::user();

        if($user->role == 'member') {
            $member = $user->member;

            $classBookings = ClassBooking::where('member_id', $member->id)
            ->orderBy('gym_class_id')
            ->orderByRaw("
                FIELD(day,
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                )
            ")
            ->get();

            $memberships = Membership::all();
            $banks = Bank::all();

            // Membership aktif (jika ada)
            $activeMembership = $member->memberMemberships()->where('status', 'active')
                ->whereDate('end_date', '>=', now())
                ->orderByDesc('end_date')
                ->first();

            if($activeMembership) {
                $classes = GymClass::where('membership_id', $activeMembership->membership_id)->latest()->get();
            } else {
                $classes = '';
            }


            // Riwayat membership
            $historyMemberships = $member->memberMemberships()
                ->orderByDesc('created_at')
                ->get();


            // Riwayat absensi
            $attendances = $member->attendances()
                ->orderByDesc('check_in_at')
                ->get();

            return view('dashboard.profile.member', compact(
                'title',
                'member',
                'user',
                'activeMembership',
                'historyMemberships',
                'attendances',
                'memberships',
                'banks',
                'classBookings',
                'classes'
            ));
        } else if ($user->role == 'admin' || $user->role == 'super_admin' || $user->role == 'guest') {

        return view('dashboard.profile.admin', compact('user', 'title'));
        } else if ($user->role == 'trainer') {
            $trainer = $user->trainer;

            $classHistories = GymClass::where('trainer_id', $trainer->id)
                ->latest()
                ->get();

            $classBookings = ClassBooking::whereIn('gym_class_id', $classHistories->pluck('id'))->orderBy('gym_class_id')
            ->orderByRaw("
                FIELD(day,
                    'monday',
                    'tuesday',
                    'wednesday',
                    'thursday',
                    'friday',
                    'saturday',
                    'sunday'
                )
            ")
        ->get();

            return view('dashboard.profile.trainer', compact(
                'title',
                'trainer',
                'classHistories',
                'classBookings'
            ));
        }
    }

    public function edit()
    {
        $title = 'Edit Profile';
        $user = Auth::user();

        return view('dashboard.profile.edit', compact('title', 'user'));
    }

    public function update(Request $request, User $user)
    {
        $rule = [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'required|date|before:today',
            'phone' => 'required|regex:/^[0-9+\s\-]{8,15}$/',
            'image' => 'image|file|max:5120|nullable|mimes:jpg,jpeg,png,webp',
            'role' => 'required|in:admin,super_admin,member,guest,trainer'
        ];

        if($user->email != $request->email ){
            $rule['email'] = 'required|email|unique:users,email';
        }

        $validatedData = $request->validate($rule);

        if($validatedData['role'] == 'trainer') {
            $validatedTrainerData = $request->validate([
                'specialty' => 'required|string|max:255',
                'bio' => 'nullable|string',
                'years_experience' => 'integer|required',
            ]);

            Trainer::where('user_id', $user->id)->update($validatedTrainerData);
        }

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::disk('public')->delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('user-profile-image', 'public');
        }

        $user->update($validatedData);

        return redirect(route('profile.index'))->with('success', 'Profil berhasil diupdate.');
    }

        public function changePass(Request $request)
        {
            $request->validate([
                'old_password' => 'required|min:6|max:255',
                'new_password' => 'required|min:6|max:255|confirmed',
            ]);

            $user = User::find(Auth::id());

            if (!Hash::check($request->old_password, $user->password)) {
                return redirect()->back()->with('error', 'Password salah.');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diupdate.');
        }
}