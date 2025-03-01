<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function doctors()
    {
        $title = 'Các bác sĩ của UNI CARE';
        $doctors =  Admin::role('Bác sĩ')->get();
        return view('user.doctor.doctors', compact('title', 'doctors'));
    }
}
