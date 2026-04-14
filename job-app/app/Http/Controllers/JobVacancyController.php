<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

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
    public function processing($id) {

    }
    public function testOpenAi() {
        try {
            $result = OpenAI::chat()->create([
                'model' => 'openrouter/auto',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are an HR manager.'],
                    ['role' => 'user', 'content' => 'Hello !'],
                    // [
                        // 'role' => 'user',
                        // 'content' => 'اعمل وصف وظيفي لمبرمج Laravel',
                        // 'content' => 'Hello!',
                    // ],
                ],
            ]);

            return $result->choices[0]->message->content;

        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}