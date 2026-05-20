<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $annotations = \App\Models\Annotation::where('user_id', auth()->id())
            ->orderBy('date', 'asc')
            ->get();

        return view('webSite.partials.calendar', compact('annotations'));
    }
}
