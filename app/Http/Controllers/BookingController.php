<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
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

  
        try {
            $event = Event::findOrFail($request->event_id);

            // Validate if slots are available
            if ($event->available_slots <= 0) {
                return redirect()->back()->with('error', 'No available slots for this event.');
            }
        
            // Validate if user has already booked the same event (Optional)
            $existingBooking = Booking::where('user_id', Auth::id())
                ->where('event_id', $event->id)
                ->first();
        
            if ($existingBooking) {
                alert()->warning('error','You have already booked a slot for this event.');
                return redirect()->back();
            }
        
            // Proceed with booking (reduce available slots)
            $event->available_slots--;
            
           
            // Create booking
            Booking::create([
                'user_id' => Auth::id(),
                'event_id' => $event->id,
                'slot_number' => time(), // Assign slot number
            ]);
    
    
            // Save updated event with reduced available slots
            $event->save();
            alert()->success('Title', 'Event Booked Successfully!');
            return to_route('events.index');
        } catch (\Exception $e) {
            alert()->error('Title', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
