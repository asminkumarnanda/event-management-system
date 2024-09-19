<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::paginate(10);
        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Use Validator::make to apply custom validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'date' => ['required', 'date', 'after_or_equal:today'], // Validates that date is today or later
            'time' => ['required', 'date_format:H:i'], // Validates correct time format
            'total_slots' => ['required', 'integer', 'min:1'],
        ]);
        $validator->after(function ($validator) use ($request) {
            // Combine date and time
            $eventDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->date . ' ' . $request->time);

            // Check if the combined date and time is in the past
            if ($eventDateTime->isPast()) {
                $validator->errors()->add('time', 'The selected date and time must be in the future.');
            }
        });

        // Run the validation and return errors if it fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        try {
            $request = $request->except('_token');
            $request['available_slots'] = $request['total_slots'];
            Event::create($request);
            alert()->success('Title', 'Event Created Successfully!');
            return to_route('events.index');
        } catch (\Exception $e) {
            alert()->error('Title', $e->getMessage());
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $eventDetails=Event::find($id);
        $bookings = Booking::where('event_id',$id)->paginate(10);
        return view('booking.index', compact('bookings','eventDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $event = Event::find($id);
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Use Validator::make to apply custom validation
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'date' => ['required', 'date', 'after_or_equal:today'], // Validates that date is today or later
            'time' => ['required'], // Validates correct time format
            'total_slots' => ['required', 'integer', 'min:1'],
        ]);
    
        $validator->after(function ($validator) use ($request, $id) {
            $event = Event::find($id);
    
            // Combine date and time
            $eventDateTime = \Carbon\Carbon::parse($request->date . ' ' . $request->time);
    
            // Check if the combined date and time is in the past
            if ($eventDateTime->isPast()) {
                $validator->errors()->add('time', 'The selected time must be in the future.');
            }
    
            // Check if total_slots are being reduced below booked slots
            $bookedSlots = $event->total_slots - $event->available_slots;
    
            if ($request['total_slots'] < $bookedSlots) {
                $validator->errors()->add('total_slots', "Total slots can't be less than already booked slots ($bookedSlots).");
            }
        });
    
        // Run the validation and return errors if it fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        try {
            $event = Event::find($id);
    
            // Adjust available_slots if total_slots are being reduced
            if ($request['total_slots'] < $event->total_slots) {
                $difference = $event->total_slots - $request['total_slots'];
                $event->available_slots = max($event->available_slots - $difference, 0);
            } 
            // If the total slots are increased, update available slots accordingly
            else if ($request['total_slots'] > $event->total_slots) {
                $event->available_slots += $request['total_slots'] - $event->total_slots;
            }
    
            // Update the event with the validated data
            $event->update([
                'name' => $request->name,
                'date' => $request->date,
                'time' => $request->time,
                'total_slots' => $request->total_slots,
                'available_slots' => $event->available_slots,  // Make sure available slots are updated
            ]);
    
            alert()->success('Success', 'Event Updated Successfully!');
            return to_route('events.index');
        } catch (\Exception $e) {
            alert()->error('Error', $e->getMessage());
            return back()->withInput();
        }
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Event::find($id)->delete();
            alert()->success('Title', 'Event Deleted Successfully!');
            return back();
        } catch (\Exception $e) {
            alert()->error('Title', $e->getMessage());
            return back();
        }
    }
}
