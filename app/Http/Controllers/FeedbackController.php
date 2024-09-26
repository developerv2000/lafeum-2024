<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    /**
     * Store the feedback submitted by the user.
     *
     * @param FeedbackStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FeedbackStoreRequest $request)
    {
        // Check if the reCAPTCHA validation passes
        if ($this->isRecaptchaValid($request)) {
            Feedback::create($request->all());
        }

        return redirect()->back();
    }

    /**
     * Validate Google reCAPTCHA v3 response for the submitted request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function isRecaptchaValid($request)
    {
        // Make a POST request to Google's reCAPTCHA siteverify endpoint
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('recaptcha_token'), // The reCAPTCHA token sent by the client
            'remoteip' => $request->ip(), // IP address of the user (optional but recommended)
        ]);

        $responseData = $recaptchaResponse->json();

        // Return true if reCAPTCHA was successful and the score is greater than or equal to 0.5 (indicating a human)
        return isset($responseData['success']) && $responseData['success'] && $responseData['score'] >= 0.5;
    }
}
