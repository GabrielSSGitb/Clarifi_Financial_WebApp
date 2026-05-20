<?php

namespace App\Http\Controllers;

use App\Models\Annotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        $annotations = \App\Models\Annotation::where('user_id', auth()->id())
            ->orderBy('date', 'asc')
            ->get();

        return view('webSite.partials.calendar', compact('annotations'));
    }

    public function store(Request $request)
    {
          $validatedData = $request->validate([
              'date' => 'required',
              'content' => 'required',
          ]);

          Annotation::create([
             'user_id' => Auth::id(),
             'date' => $validatedData['date'],
             'content' => $validatedData['content'],
          ]);

          return redirect()->route('dashboard.calendar');
    }
}
