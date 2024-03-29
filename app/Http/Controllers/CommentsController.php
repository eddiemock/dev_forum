<?php

namespace App\Http\Controllers;
use App\Services\OpenAiModerationService;
use App\Services\FastAPIService;
use App\Models\Discussion;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentFlaggedMail;
use Illuminate\Support\Facades\Log;

class CommentsController extends Controller
{
    protected $moderationService;
    protected $fastAPIService;

    public function __construct(OpenAiModerationService $moderationService, FastAPIService $fastAPIService)
    {
        $this->moderationService = $moderationService;
        $this->fastAPIService = $fastAPIService;
    }

    public function store(Request $request, Discussion $discussion)
    {
        if (!$discussion) {
            return back()->withErrors(['message' => 'Discussion not found.']);
        }

        $userId = Auth::id();
        $commentText = $request->input('body');

        $moderationResult = $this->needsReview($commentText);
        $needsReview = $moderationResult['flagged'];

        // Use FastAPIService to get predictions and log the response
        $fastAPIResponse = $this->fastAPIService->predict($commentText);
        $predictionDescription = $this->interpretPrediction($fastAPIResponse['predicted_class']);

        // Log the descriptive prediction result
        Log::info('FastAPI Prediction Result', [
            'request' => $commentText,
            'predicted_class_description' => $predictionDescription,
            'response' => $fastAPIResponse
        ]);

        $comment = new Comment();
        $comment->body = $commentText;
        $comment->discussion_id = $discussion->id;
        $comment->user_id = $userId;
        $comment->flagged_categories = $needsReview ? json_encode($moderationResult['categories']) : null;
        $comment->flagged = $needsReview ? 1 : 0;
        $comment->save();

        // If the comment is flagged, notify admins
        if ($needsReview) {
            $flaggedCategories = $moderationResult['categories']; // Get flagged categories
            Mail::to('admin@example.com')->send(new CommentFlaggedMail($comment, $flaggedCategories));
            return back()->withErrors(['message' => 'Your comment is under review.']);
        }

        // For both flagged and non-flagged comments, redirect back with a success message
        return back()->with('message', 'Your comment has been posted successfully.');
    }

    private function needsReview($text)
    {
        // Corrected to call the moderation service once
        return $this->moderationService->moderateText($text);   
    }

    /**
 * Interprets the predicted class and returns a descriptive string.
 *
 * @param int $predictedClass
 * @return string
 */
        private function interpretPrediction($predictedClass)
        {
            return $predictedClass === 1 ? 'possibly depressive' : 'possibly non-depressive';
        }

}
