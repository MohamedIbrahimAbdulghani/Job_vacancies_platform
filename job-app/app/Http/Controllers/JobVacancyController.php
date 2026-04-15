<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\Resume;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    public function show($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('job_vacancies'));
    }
    public function apply($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.apply', compact('job_vacancies'));
    }
    public function processing(ApplyJobRequest $request, $id) {
        $file = $request->file('resume_file');
        $originalFileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = 'resume_' . time() . $extension;
        // Store in laravel cloud
        $path = $file->storeAs('resumes', $fileName, 'cloud');

        // $fullPathFileUrl = config('filesystems.disks.cloud.url') . '/' . $path;

        // Create resume in database
        $resume = Resume::create([
            'filename' => $originalFileName,
            'fileUrl' => $path,
            'contactDetails' => json_encode([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]),
            'education' => '',
            'summary' => '',
            'skills' => '',
            'experience' => '',
            'user_id' => Auth::user()->id,
        ]);

        // Create Job Application
        $job_application = JobApplication::create([
            'status' => 'pending',
            'aiGeneratedScore' => 0,
            'aiGeneratedFeedback' => '',
            'user_id' => Auth::user()->id,
            'resume_id' => $resume->id,
            'job_vacancy_id' => $id,
        ]);

        return redirect()->route('job_application.index', $id)->with('success', 'Application Submitted Successfully');

    }
    // this function to test ai
    // public function testOpenAi() {
    //     try {
    //         $result = OpenAI::chat()->create([
    //             'model' => 'gpt-4o-mini',
    //             // 'model' => 'openrouter/auto',
    //             'messages' => [
    //                 ['role' => 'user', 'content' => 'Hello !'],
    //                 [
    //                     'role' => 'user', // role: user → انت اللي بتتكلم
    //                     'content' => 'How is messi?',  //طلب وصف او الطلب اللي ai هيبحث عنه او الداتا اللي هيرجعهالك
    //                 ],
    //             ],
    //         ]);
    //     } catch (\Exception $e) {
    //         return $e->getMessage();
    //     }
    //     return $result->choices[0]->message->content;
    // }
}
