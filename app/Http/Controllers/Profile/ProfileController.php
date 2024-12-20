<?php


namespace App\Http\Controllers\Profile;

use App\Events\ConversationSelected;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Hiring\Event;
use App\Models\Hiring\EventJob;
use App\Models\Hiring\Hiring_request;
use App\Models\Hiring\Job_application;
use App\Models\Profile\Report;
use App\Models\Profile\Team;
use App\Models\Transaction\Review;
use App\Models\Transaction\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
  //

  public function showFreelancersProfile()
  {
    /** @var User $user */
    $user = Auth::user();
    $fullName = "{$user->first_name} {$user->last_name}";
    $socialMediaLinks = $user->socmed()->pluck('url', 'platform')->toArray();

    if ($user->user_type == 'freelancer') {
      // Load related data for freelancers
      $user->load(
        'freelancer.services',
        'freelancer.certificates',
        'freelancer.portfolios',
        'freelancer.reviews.transaction.event'
      );

      //get the freelancer's reviews made by the clients
      $reviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->paginate(4);
      return view('freelancer.f_profile', compact('user', 'fullName', 'reviews', 'socialMediaLinks'));
    }
  }

  public function showClientsProfile()
  {
    $user = Auth::user();
    $fullName = "{$user->first_name} {$user->last_name}";
    $socialMediaLinks = $user->socmed()->pluck('url', 'platform')->toArray();

    // Count the client's total job posts and hiring success rate
    $clientTotalPosts = Event::where('client_id', $user->id)->count();

    $successfulEvents = Event::where('client_id', $user->id)
      ->whereHas('event_jobs.transactions', function ($query) {
        $query->where('transaction_status', 'Done');
      })
      ->count();

    $hiringSuccessRate = 0;

    if ($successfulEvents > 0) {
      $hiringSuccessRate = ($successfulEvents / $clientTotalPosts) * 100;
    }

    if ($user->user_type == 'client') {
      // Get events with completed transactions and load reviews grouped by event
      $eventsWithReviews = Event::with(['transactions.reviews' => function ($query) {
        $query->where('reviewee_role', 'client');
      }])
        ->where('client_id', $user->id)
        ->whereHas('transactions', function ($query) {
          $query->where('transaction_status', 'Done');
        })
        ->paginate(4);

      return view('client.c_profile', compact('user', 'fullName', 'eventsWithReviews', 'socialMediaLinks', 'hiringSuccessRate'));
    }
  }

  public function updateProfilePic(Request $request)
  {
    /** @var User $user */
    $user = Auth::user();

    // Validate the incoming request
    $request->validate([
      'profile_picture' => 'required|image|mimes:jpg,png,gif|max:10240', // Adjust the max size as needed
    ]);

    // dd($request->all());
    // Handle the uploaded file
    if ($request->hasFile('profile_picture')) {
      // Delete the old profile picture if it exists
      if ($user->profile_image && Storage::exists($user->profile_image)) {
        Storage::delete($user->profile_image);
      }

      // Get the uploaded file
      $file = $request->file('profile_picture');

      // Create a unique name for the file using the original name and the user's last name
      $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
      $lastName = $user->last_name;
      $newFileName = "{$fileName}_{$lastName}." . $file->getClientOriginalExtension();

      // Store the file and get the path
      $path = $file->storeAs('profile_pictures', $newFileName, 'public');

      // Update the user's profile picture path in the database
      $user->profile_image = $path;
      $user->save();
    }

    return redirect()->back()->with('success', 'Profile picture updated successfully.');
  }

  public function viewFreelancerProfile($id)
  {
    // Find the freelancer's user by ID
    $user = User::find($id);
    $fullName = "{$user->first_name} {$user->last_name}";

    // Load related data for freelancers
    $user->load(
      'freelancer.services',
      'freelancer.certificates',
      'freelancer.portfolios',
      'freelancer.reviews.transaction.event'
    );

    // Get the freelancer's reviews made by the clients
    $reviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->paginate(4);

    // Retrieve the events for the authenticated user
    $events = auth()->user()->events()->where('status', 'Open')->get();
    $events = $events->isEmpty() ? null : $events;

    return view('components.Profile.view_freelancer_profile', compact('user', 'fullName', 'reviews', 'events'));
  }

  public function findSelectedEvent($id)
  {
    $event = Event::with('event_jobs')->findOrFail($id);
    $start = Carbon::parse($event->start_date);
    $end = Carbon::parse($event->end_date);
    $durationInHours = $start->diffInHours($end);

    //get the completedHiredCounts
    $completedHiredCounts = collect();

    foreach ($event->event_jobs as $job) {
      // Getting hired freelancers count for each job
      $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
      $hiredCount = $jobApplicantsHired->count();

      // Store the count of hired freelancers for the job
      $completedHiredCounts->put($job->job_id, $hiredCount);
    }

    Log::info('event:', $event->toArray());
    // Return the event jobs associated with the event
    return response()->json([
      'event_jobs' => $event->event_jobs,
      'durationInHours' => $durationInHours,
      'completedHiredCounts' => $completedHiredCounts,
    ]);
  }

  public function viewClientProfile($id)
  {
    $user = User::find($id);
    $fullName = "{$user->first_name} {$user->last_name}";
    $socialMediaLinks = $user->socmed()->pluck('url', 'platform')->toArray();

    // Count the client's total job posts and hiring success rate
    $clientTotalPosts = Event::where('client_id', $user->id)->count();

    $successfulEvents = Event::where('client_id', $user->id)
      ->whereHas('event_jobs.transactions', function ($query) {
        $query->where('transaction_status', 'Done');
      })
      ->count();

    $hiringSuccessRate = 0;

    if ($successfulEvents > 0) {
      $hiringSuccessRate = ($successfulEvents / $clientTotalPosts) * 100;
    }

    if ($user->user_type == 'client') {
      // Get events with completed transactions and load reviews grouped by event
      $eventsWithReviews = Event::with(['transactions.reviews' => function ($query) {
        $query->where('reviewee_role', 'client');
      }])
        ->where('client_id', $user->id)
        ->whereHas('transactions', function ($query) {
          $query->where('transaction_status', 'Done');
        })
        ->paginate(4);

      return view(
        'components.Profile.view_client_profile',
        compact('user', 'fullName', 'eventsWithReviews', 'socialMediaLinks', 'hiringSuccessRate')
      );
    }
  }

  public function showChat($conversationId = null)
  {

    if (is_null($conversationId)) {
      // Set a default conversation ID which is the latest
      $defaultConversation = Conversation::where(function ($query) {
        $query->where('sender_id', auth()->id())
          ->orWhere('recipient_id', auth()->id());
      })
        ->orderByDesc('last_time_message') // Order by the latest message time
        ->first(); // Get the latest conversation

      //if empty or no convo at first
      if (is_null($defaultConversation)) {
        return view('chat_ui', ['conversationId' => $defaultConversation]);
      }

      return view('chat_ui', ['conversationId' => $defaultConversation->conversation_id]);
    }

    return view('chat_ui', ['conversationId' => $conversationId]);
  }



  // Redirect to chat page
  public function redirectToChat(Request $request)
  {
    // Validate and get the recipient ID
    $validated = $request->validate([
      'recipientId' => 'required|integer|exists:users,id',
    ]);

    // Log::info('CHAT:', $validated);

    // Check for existing conversation with the recipient
    $conversation = Conversation::where(function ($query) use ($validated) {
      $query->where('sender_id', Auth::id())
        ->where('recipient_id', $validated['recipientId']);
    })->orWhere(function ($query) use ($validated) {
      $query->where('recipient_id', Auth::id())
        ->where('sender_id', $validated['recipientId']);
    })->first();

    if ($conversation) {
      // If conversation exists, use its ID
      $conversationId = $conversation->conversation_id;
      // Redirect to the chat page
      return redirect()->route('show-chat', ['conversationId' => $conversationId]);
    } else {
      // Create a new conversation if it doesn't exist
      $conversation = Conversation::create([
        'sender_id' => Auth::id(),
        'recipient_id' => $validated['recipientId'],
        'last_time_message' => now(),
      ]);
      $conversationId = $conversation->conversation_id;
      // Redirect to the chat page
      return redirect()->route('show-chat', ['conversationId' => $conversationId]);
    }
  }

  //store the report to the db
  public function reportStore(Request $request)
  {
    $validated = $request->validate([
      'reason' => 'required|array|min:1',
      'reason.*' => 'string',
      'details' => 'required|string',
      'proof_image' => 'nullable|array',
      'proof_image.*' => 'file|mimes:jpg,png,jpeg',
      'reported_user_id' => 'required|exists:users,id',
      'reporter_id' => 'required|exists:users,id',
    ]);


    // Process the proof images if provided
    $proofImagePaths = [];
    $proofImageOriginalNames = [];

    if ($request->hasFile('proof_image')) {
      foreach ($request->file('proof_image') as $file) {
        // Construct the desired file name
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // Get the file name without extension
        $extension = $file->getClientOriginalExtension(); // Get the file extension
        $newFileName = $originalName . '_' . $validated['reporter_id'] . '.' . $extension;

        // Store the file with the new name
        $proofImagePaths[] = $file->storeAs('reports/proofs', $newFileName, 'public');

        // Optionally, keep a record of the original names (if needed)
        $proofImageOriginalNames[] = $newFileName;
      }
    }

    // Create the report
    $report = new Report();
    $report->reported_user_id = $validated['reported_user_id'];
    $report->reporter_id = $validated['reporter_id'];
    $report->reason = json_encode($validated['reason']);
    $report->details = $validated['details'];
    $report->proof_image = json_encode($proofImagePaths); // Store the file paths as JSON
    $report->isArchived = false;
    $report->save();

    return response()->json(['success' => true]); //shows true to show the alert success 
  }

  //viewAllReviews
  public function showAllReviews($id)
  {
    //check if its a freelancer and client or team
    if (is_numeric($id)) {
      $user = User::find($id); //get the data
      $reviews = collect(); // container of the reviews
      $name = null;

      if ($user->user_type === 'freelancer') {
        $reviews = $user->freelancer->reviews()->where('reviewee_role', 'freelancer')->get();
        $name = $user->fullName();
      } elseif ($user->user_type === 'client') {
        $reviews = $user->client->reviews()->where('reviewee_role', 'client')->get();
        $name = $user->fullName();
      }

      return view('components.Profile.viewAllReviews', compact('reviews', 'name'));
    } else {
      $team = Team::where('team_name', $id)->first();
      $reviews = $team->reviews()->where('reviewee_role', 'team')->get();
      $name = $team->team_name;
      return view('components.Profile.viewAllReviews', compact('reviews', 'name'));
    }

  }

  //showAllPosts
  public function showAllPosts($id, Request $request)
  {

    $user = User::find($id);
    $fullName = $user->fullName();

    // Get the status filter from the request, default to 'All' if not provided
    $status = $request->input('status', 'All');

    // Get events for the authenticated user
    $eventsQuery = Event::where('client_id', $user->id)
      ->whereHas('event_jobs')
      ->orderBy('created_at'); //displays from oldest to latest

    // Apply filtering by status if it's not 'All'
    if ($status != 'All') {
      $eventsQuery->where('status', $status);
    }

    $events = $eventsQuery->get();

    // Get counts for each event 
    $eventsWithCounts = $events->map(function ($event) {
      // Initialize counters
      $hiredCount = 0;
      $jobApplicationsCount = 0;
      $hiringRequestsCount = 0;

      // Get all jobs associated with this event
      $jobs = EventJob::where('event_id', $event->event_id)->get();

      foreach ($jobs as $job) {
        // Fetch job applications
        $applications = Job_application::where('job_id', $job->job_id)->where('status', '!=', 'Accepted')->get();
        $jobApplicationsCount += $applications->count();

        // Getting hired freelancers count for each job
        $jobApplicantsHired = Transaction::where('job_id', $job->job_id)->get();
        $hiredCount += $jobApplicantsHired->count();

        // Get hiring requests count for the event's jobs
        $hiringRequestsCount += Hiring_request::where('job_id', $job->job_id)->where('status', '!=', 'Accepted')->count();
      }

      // Add counts to the event object
      $event->hiredCount = $hiredCount;
      $event->jobApplicationsCount = $jobApplicationsCount;
      $event->hiringRequestsCount = $hiringRequestsCount;

      return $event;
    });

    return view('components.Profile.see_all_posts', compact('events', 'status', 'fullName'));
  }
}
