<?php
namespace App\Http\Controllers;

// use App\Models\Student;
use Illuminate\Http\Request;

class MidwifeController extends Controller
{
  public function create()
    {
        return view('midwife.addPatient');
    }

    public function store(Request $request)
    {
        // Validate and store patient info here
    }
}
