<?php

namespace App\Http\Controllers;

use App\Models\AccessLink;
use Illuminate\Http\Request;
use App\Mail\OneTimeLinkEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccessLinkController extends Controller
{

    // Show the form
    public function showForm()
    {
        return view('request');
    }

    public function generateLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Generate a unique token
        $token = Str::uuid();

        // Create the signed URL that expires in 10 minutes
        $signedUrl = URL::temporarySignedRoute(
            'secure-content',
            now()->addMinutes(10),
            ['token' => $token]
        );

        // Save the token to the database
        AccessLink::create([
            'token' => $token,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send the email with the signed URL
        Mail::to($request->email)->send(new OneTimeLinkEmail($signedUrl));

        return redirect()->back()->with('success', 'One-time access link sent to your email!');
    }

    public function secureContent(Request $request, $token)
    {
        // Check if the link is valid and not expired
        if (!$request->hasValidSignature()) {
            abort(403, 'Invalid or expired link.');
        }

        // Check if the token exists and is not used
        $accessLink = AccessLink::where('token', $token)->first();

        if (!$accessLink || $accessLink->used || $accessLink->expires_at < now()) {
            abort(403, 'Invalid or expired link.');
        }

        // Mark the token as used
        $accessLink->update(['used' => true]);

        // Return the secure content
        return response()->json([
            'message' => 'Access Granted',
            'data' => 'Some secure content',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AccessLink $oneTimeAccessLink)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccessLink $oneTimeAccessLink)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccessLink $oneTimeAccessLink)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccessLink $oneTimeAccessLink)
    {
        //
    }


}
