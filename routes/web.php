<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home', [
        'greeting' => 'Hello',
        'name' => 'Kanishk',
    ]);
});

Route::get('/jobs', function () {
    // return view('welcome');
    // return ['foo' => 'bar'];

    $jobs = Job::with('employer')->latest()->simplePaginate(3);

    return view('jobs.index', [
        'jobs' => $jobs
    ]);
});


Route::get('/jobs/create', function () {
    return view('jobs.create');
});

Route::post('/jobs', function () {
    request() -> validate([
        'title'=> ['required', 'min:3'],
        'salary'=> ['required']
    ]);
    Job::create([
        'title' => request('title'),
        'salary' => request('salary'),
        'employer_id' => 1,
    ]);

    return redirect('/jobs');
});


Route::get('/jobs/{id}', function ($id) {
    // dd => dump and die
    // Arr is an object thats contains multiple methods related to arrays
    // This First function returns the first element it finds in the array with same attribute or condition
    $job = Job::find($id);

    return view('jobs.show', ['job' => $job]);
});


Route::get('/jobs/{id}/edit', function ($id) {
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

Route::patch('/jobs/{id}', function ($id) {
    // Research about Laravel Route Model Binding
    // validate
    request() -> validate([
        'title'=> ['required', 'min:3'],
        'salary'=> ['required']
    ]);

    // authorize (Oh Hold....)


    // update the job and persist

    $job = Job::findOrFail($id); // We used find or fail because what if I patch the URL req to update id 10000 which doesn't exist, it will crash my app hence findOrFail would fail in this senario

    $job->title = request('title');
    $job->salary = request('salary');
    $job->save();

    $job->update([
        'title' => request('title'),
        'salary' => request('salary'),
    ]);

    // redierct to the job page

    return redirect('/jobs/', $job->id);

});

Route::delete('/jobs/{id}', function ($id) {
    // validate
    request() -> validate([
        'title'=> ['required', 'min:3'],
        'salary'=> ['required']
    ]);


    // authorize (Oh Hold....)

    // delete the job

    Job::findOrFail($id)->delete();;

    return redirect('/jobs');

});

Route::get('/contact', function () {
    return view('contact');
});