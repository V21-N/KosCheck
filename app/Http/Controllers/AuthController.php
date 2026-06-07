<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $selectedRole = $request->input('role', 'mahasiswa');

        // Demo users based on role selection (frontend-only demo)
        // Auto-login if email matches the demo email for selected role
        $usersByRole = [
            'mahasiswa' => [
                'email' => 'mahasiswa@usu.ac.id',
                'id' => 1,
                'name' => 'Andi Wijaya',
                'role' => 'mahasiswa',
                'institution' => 'USU'
            ],
            'owner' => [
                'email' => 'owner@email.com',
                'id' => 2,
                'name' => 'Budi Santoso',
                'role' => 'owner',
                'institution' => null
            ],
            'admin' => [
                'email' => 'admin@koscheck.id',
                'id' => 3,
                'name' => 'Admin KosCheck',
                'role' => 'admin',
                'institution' => null
            ],
        ];

        // For demo: validate email format and check if it matches expected demo email for role
        if (isset($usersByRole[$selectedRole])) {
            $user = $usersByRole[$selectedRole];

            // For demo, any password works if email matches or contains @
            if ($password && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Set session
                session([
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                    'user_institution' => $user['institution'] ?? null,
                ]);

                // Redirect based on role
                $redirectRoute = match ($user['role']) {
                    'mahasiswa' => route('student.dashboard'),
                    'owner' => route('owner.dashboard'),
                    'admin' => route('admin'),
                    default => route('home'),
                };

                return redirect($redirectRoute)->with('success', 'Berhasil login! Selamat datang, ' . $user['name']);
            }
        }

        return redirect()->back()->with('error', 'Email atau password salah.')->withInput();
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // For frontend demo, just redirect with success
        // In production, implement actual registration logic

        // Simulate registration
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role', 'mahasiswa');

        // Default redirect based on role
        $redirectRoute = match ($role) {
            'mahasiswa', 'owner' => route('login'),
            default => route('login'),
        };

        return redirect($redirectRoute)->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    public function logout()
    {
        // Clear all session data
        session()->flush();

        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}