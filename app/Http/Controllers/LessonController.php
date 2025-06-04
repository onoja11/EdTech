<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    //
    
    public function create()
{
    $levels =  [100, 200, 300, 400, 500];
    return Inertia::render('Lesson/create',[
        'levels' => $levels,
    ]);
}

public function store(Request $request)
{
   
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|file|max:10248|mimes:pdf',
        'subject' => 'required|string',
        'grade_level' => 'required|string',
    ]);

 if ($request->hasFile('content')) {
         $validated['content'] = Storage::disk('public')->put('lessoNotes', $request->content);
    }
  



    Lesson::create([
        'title' => $validated['title'],
        'content' => $validated['content'],
        'subject' => $validated['subject'],
        'grade_level' => $validated['grade_level'],
        'created_by' => auth()->id(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Lesson created successfully!');
}

public function show(int $id)
{
    $lessons = Lesson::findOrFail($id);
    $questions = $lessons->questions()->where('user_id',auth()->id())->latest()->with('user')->get();

    $readMoreLessons =  Lesson::all();
    // dd($questions);
    $created_by = User::findOrFail($lessons->created_by);
    return Inertia::render('Lesson/show', [
        'questions' => $questions,
        'lesson' => $lessons,
        'created_by' => $created_by,
    ]);
}
}
