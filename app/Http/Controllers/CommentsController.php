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

    $depressiveClassification = 0; // Default to 'possibly non-depressive'

    // Check if 'probabilities' key exists in the response and has at least 2 elements
    if (isset($fastAPIResponse['probabilities']) && count($fastAPIResponse['probabilities']) >= 2) {
        // Determine which probability is higher
        $predictedClass = array_search(max($fastAPIResponse['probabilities']), $fastAPIResponse['probabilities']);
        $predictionDescription = $this->interpretPrediction($predictedClass);

        // Update depressive_classification based on predicted class
        $depressiveClassification = $predictedClass === 1 ? 1 : 0;

        // Log the descriptive prediction result
        Log::info('FastAPI Prediction Result', [
            'request' => $commentText,
            'predicted_class_description' => $predictionDescription,
            'response' => $fastAPIResponse
        ]);
    } else {
        // Handle case where probabilities are not provided or not as expected
        Log::error('Probabilities missing or insufficient in FastAPI response.', [
            'request' => $commentText,
            'response' => $fastAPIResponse
        ]);
        $predictionDescription = 'Prediction unavailable';
    }

    $comment = new Comment();
    $comment->body = $commentText;
    $comment->discussion_id = $discussion->id;
    $comment->user_id = $userId;
    $comment->flagged_categories = $needsReview ? json_encode($moderationResult['categories']) : null;
    $comment->flagged = $needsReview ? 1 : 0;
    $comment->depressive_classification = $depressiveClassification; // Set classification
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

        public function destroy(Comment $comment)
{
    $user = Auth::user();
    Log::info('Destroy method called by user: ' . $user->id . ' with role: ' . $user->role->name);

    if (!$user || !in_array($user->role->name, ['administrator', 'moderator'])) {
        return back()->with('error', 'You do not have permission to delete this comment.');
    }

    $comment->delete();
    return back()->with('success', 'Comment deleted successfully.');
}


}
