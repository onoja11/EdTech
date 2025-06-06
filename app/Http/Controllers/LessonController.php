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
    $authUser = User::find(auth()->id());
    $user_role = $authUser->user_roles;
    $created_by = User::findOrFail($lessons->created_by);
    return Inertia::render('Lesson/show', [
        'questions' => $questions,
        'lesson' => $lessons,
        'created_by' => $created_by,
        'user_role' => $user_role,
    ]);
}
public function edit($id){
      $lesson = Lesson::findOrFail($id);
        $levels = [100, 200, 300, 400, 500];
        return Inertia('Lesson/edit', [
            'levels' => $levels,
            'lesson' => $lesson,
            // 'user_roles' => $request->input('user_roles'),
        ]);
}
public function editContent($id)
{
    $lesson = Lesson::findOrFail($id);
    return Inertia::render('Lesson/editContent', [
        'lesson' => $lesson,
    ]);
}

public function updateContent(Request $request, $id)
{
    $validated = $request->validate([
        'content' => 'required|file|mimes:pdf|max:10248',
    ]);

    if ($request->hasFile('content')) {
        $path = $request->file('content')->store('lessonNotes', 'public');
        
        $lesson = Lesson::findOrFail($id);
        $lesson->update([
            'content' => $path,
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Lesson content updated.');
}

public function update(Request $request, $id){
     $validated = $request->validate([
        'title' => 'required|string|max:255',
        'subject' => 'required|string',
        'grade_level' => 'required|string',
    ]);

    $lesson = Lesson::findOrFail($id);

    $lesson->update([
        'title' => $validated['title'],
        'subject' => $validated['subject'],
        'grade_level' => $validated['grade_level'],
        'created_by' => auth()->id(),
    ]);
    
    return redirect()->route('dashboard')->with('success', 'Lesson created successfully!');

}

 public function delete($id)
    {
        $user = Lesson::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'Lesson deleted successfully.');
    }
}
