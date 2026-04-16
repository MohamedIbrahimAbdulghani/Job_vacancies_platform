<?php


namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use OpenAI\Laravel\Facades\OpenAI;
use Smalot\PdfParser\Parser;

// *-* This service made to read pdf from cloud and extract text form this pdf and send this text to openAI to return some data like education, skills, experience, summary return this data in file JSON
class ResumeAnalysisService {
    public function extractResumeInformation($fileUrl) /* $fileUrl is uploaded on cloud */  {
        try {
            // 1- Extract text from the resume pdf file ( read pdf, and get the text )
            $rowText = $this->extractTextFromPdf($fileUrl);

            Log::debug("Successfully extracted text from pdf file" . strlen($rowText) . ' characters '); // Store in log number of charters extracted from the PDF file

            // 2- Use OpenAI API to organize the text into a structured format ( Outout => {summary, skills, experience, education} but i need the output about JSON file )
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are a resume parser. Extract information and return ONLY valid JSON. Format education as a string, summary as a string, skills as a string (comma-separated), experience as a string with line breaks.' // this is prompt to AI Chat
                ],
                [
                    'role' => 'user',
                    'content' => "Extract education, summary, skills, and experience from this resume. Return JSON with these exact keys. Make education a single string, skills a comma-separated string, and experience a formatted string with each job on a new line.\n\n" . $rowText    // Required keys and data format
                ]
                ],

                'response_format' => [
                    'type' => 'json_object' // this case to forced about AI Or forced about ChatGPT returned clean JSON without any more data focus about user message i will send this user massage in messages when created it
                ],
                'temperature' => 0 // Sets the randomness of the AI response to 0, making it deterministic and focused on the most likely completion
            ]);

            $result = $response->choices[0]->message->content; // Get text from AI
            Log::debug("OpenAI response: " . $result);

            $parseResult = json_decode($result, true);  // to convert $result to associative array to abstract to keys

            if(json_last_error() !== JSON_ERROR_NONE) { // check about JSON is correct or not correct
                Log::error('Failed to parse OpenAI response: ' . json_last_error_msg());
                throw new \Exception('Failed to parse OpenAI response');
            }

            // Validate about keys ( $ParsedResult )
            $requiredKeys = ['education', 'summary', 'skills', 'experience'];
            foreach ($requiredKeys as $key) {
                if (!array_key_exists($key, $parseResult)) { // to confirm if key founded or not
                    Log::error("Missing key: " . $key);
                    throw new \Exception("Missing required key: " . $key);
                }
            }
            $missingKeys = array_diff($requiredKeys, array_keys($parseResult)); // this function make compare different between to array ( Any missing keys )
            if(count($missingKeys) > 0) {
                Log::error('Missing required keys: ' . implode(', ', $missingKeys));
                throw new \Exception('Missing required keys in the parsed result');
            }

            // 3- Return the JSON object
            return [
                'education' => $parseResult['education'] ?? '',
                'summary' => $parseResult['summary'] ?? '',
                'skills' => $parseResult['skills'] ?? '',
                'experience' => $parseResult['experience'] ?? '',
            ];
        }  catch (\Exception $e) {
            Log::error('Error extracting resume information: ' . $e->getMessage());
                return [
                'education' => '',
                'summary' => '',
                'skills' =>  '',
                'experience' =>  '',
            ];
        }
    }
    private function extractTextFromPdf($fileUrl) {

        // *----------------*  1- Reading the file from the cloud to local disk storage in temp file *----------------* //

        $tempFile = tempnam(sys_get_temp_dir(), 'resume'); // Temporary content محتوي مؤقت

        $filePath = parse_url($fileUrl, PHP_URL_PATH);
        if(!$filePath) {
            throw new \Exception('Invalid file URL');
        }
        $filename = basename($filePath);

        $storagePath = "resumes/{$filename}";

        // check if storagePath found in cloud or not
        if(!Storage::disk('cloud')->exists($storagePath)) {
            throw new \Exception('File Not Found');
        }

        // this steps to open pdf file and read it
        $pdfContent = Storage::disk('cloud')->get($storagePath);
        if(!$pdfContent) {
            throw new \Exception('Failed to read file');
        }

        // this is to take PDF Content and Put it in tempFile Variable
        file_put_contents($tempFile, $pdfContent);

        // *----------------*  3- Extract text from the pdf file  *----------------*  //

        try {
            $parser = new Parser();
            $pdf = $parser->parseFile($tempFile);  // to read pdf file أقرأ ملف ال pdf اللي موجود في الملف المؤقت
            $text = $pdf->getText();  // to get text from pdf file

            if (trim($text) === '') {
                throw new \Exception('No text could be extracted from PDF');
            }
        } catch (\Exception $e) {
            unlink($tempFile);
            throw new \Exception('Failed to extract text from PDF: ' . $e->getMessage());
        }
            // clean up temp file
            unlink($tempFile);
            return $text;
    }
}