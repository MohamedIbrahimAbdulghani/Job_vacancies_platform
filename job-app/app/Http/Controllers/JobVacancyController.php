<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Requests\ApplyJobRequest;
use App\Models\JobApplication;
use App\Models\Resume;
use App\Services\ResumeAnalysisService;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    protected $ResumeAnalysisService;

    // make it to use Design Pattern Model ( Dependency injection )
    public function __construct(ResumeAnalysisService $ResumeAnalysisService)
    {
        $this->ResumeAnalysisService = $ResumeAnalysisService;
    }

    public function show($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        return view('job_vacancy.show', compact('job_vacancies'));
    }

    public function apply($id) {
        $job_vacancies = JobVacancy::findOrFail($id);
        $resumes = Auth::user()->resumes;
        return view('job_vacancy.apply', compact('job_vacancies', 'resumes'));
    }

    // this function to upload file n cloud
    public function processing(ApplyJobRequest $request, $id) {

        $extractInfo = null;

        if($request->resume_option === 'new_resume') {
            $file = $request->file('resume_file');
            $originalFileName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = 'resume_' . time() . '.' . $extension;
            // Store in laravel cloud
            $path = $file->storeAs('resumes', $fileName, 'cloud');

            $fullPathFileUrl = config('filesystems.disks.cloud.url') . '/' . $path;

            $extractInfo = $this->ResumeAnalysisService->extractResumeInformation($fullPathFileUrl);

            // Create resume in database
            $resume = Resume::create([
                'filename' => $originalFileName,
                'fileUrl' => $path,
                'contactDetails' => json_encode([
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]),
                'education' => $extractInfo['education'],
                'summary' => $extractInfo['summary'],
                'skills' => $extractInfo['skills'],
                'experience' => $extractInfo['experience'],
                'user_id' => Auth::user()->id,
            ]);
        } else {
            $resume_id = $request->resume_option;
            $resume = Resume::findOrFail($resume_id);
            $extractInfo = [
                'education' => $resume->education,
                'summary' => $resume->summary,
                'skills' => $resume->skills,
                'experience' => $resume->experience,
            ];
        }
        // TODO: Evaluate Job Application
        // Use the $extractInfo to evaluate the job application
            JobApplication::create([
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
