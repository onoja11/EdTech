<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LessonController extends Controller
{
    //
    public function view()
    {
        $lessons=Lesson::all();
        return Inertia::render('Lesson/index',[
            'lessons'=> $lessons
        ]);

    }
    public function create()
{
    return Inertia::render('Lesson/create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'subject' => 'required|string',
        'grade_level' => 'required|string',
    ]);


    Lesson::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'subject' => $validated['subject'],
        'grade_level' => $validated['grade_level'],
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Lesson created successfully!');
}

public function show($id)
{
    $lessons = Lesson::findOrFail($id);
    $created_by = User::findOrFail($lessons->created_by);
    return Inertia::render('Lesson/show', [
        'lesson' => $lessons,
        'created_by' => $created_by,
    ]);
}
}
