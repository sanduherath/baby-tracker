<?php

namespace App\Http\Controllers;

use App\Models\Baby;
use App\Models\BabyDiary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BabyDiaryController extends Controller
{
public function index(Request $request, $babyId)
{
    Log::info("Accessing diary for babyId: $babyId, user: " . Auth::id());
    $baby = Baby::where('id', $babyId)->where('user_id', Auth::id())->firstOrFail();
    $query = BabyDiary::where('baby_id', $babyId);
    if ($request->filled('search_date')) {
        $searchDate = $request->input('search_date');
        Log::info("Filtering entries by date: $searchDate");
        $query->whereDate('entry_date', $searchDate);
    }
    $entries = $query->latest()->paginate(5);
    Log::info("Fetched entries for babyId: $babyId", [
        'total_entries' => $entries->total(),
        'current_page' => $entries->currentPage(),
        'search_date' => $request->input('search_date', 'none'),
    ]);
    return view('baby.diary', compact('baby', 'entries'));
}

    public function store(Request $request, $babyId)
    {

        Log::info("Storing diary entry for babyId: $babyId, user: " . Auth::id());
        $baby = Baby::where('id', $babyId)->where('user_id', Auth::id())->firstOrFail();

        // Log request data for debugging
        Log::info('Request data:', $request->all());
        if ($request->hasFile('photo')) {
            Log::info('Photo file detected:', [
                'name' => $request->file('photo')->getClientOriginalName(),
                'size' => $request->file('photo')->getSize(),
                'mime' => $request->file('photo')->getMimeType(),
            ]);
        } else {
            Log::warning('No photo file detected in request.');
        }

        $request->validate([
            'entry_date' => 'required|date',
            'entry_time' => 'required',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'mood' => 'nullable|string|in:happy,sleepy,fussy,sick',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['entry_date', 'entry_time', 'title', 'description', 'mood']);
        $data['baby_id'] = $babyId;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            try {
                $path = $request->file('photo')->store('diary_photos', 'public');
                Log::info('Photo stored at: ' . $path);
                $data['photo_path'] = $path;
            } catch (\Exception $e) {
                Log::error('Failed to store photo: ' . $e->getMessage());
                return redirect()->back()->withErrors(['photo' => 'Failed to upload photo. Please try again.']);
            }
        }

        BabyDiary::create($data);

        return redirect()->route('baby.diary', ['babyId' => $babyId])->with('success', 'Diary entry added successfully!');
    }
}
