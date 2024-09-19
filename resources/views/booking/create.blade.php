@section('title', 'Create Booking')

@extends('layouts.app')

@section('content')
@section('sectionHeading', "Create Booking For $eventDetails->name")
<form class="row g-3" action="{{ route('bookings.store') }}" method="POST">
    @csrf
    <div class="col-md-6">
      <label for="user_id" class="form-label">Choose User</label>
      <select class="form-select @error('user_id') is-invalid @enderror" aria-label="Default select example"
          id="user_id" name="user_id">
          <option value="">select</option>
          @foreach ($users as $user)
          <option value="{{$user->id}}"
          {{ old('user_id') === $user->id  ? 'selected' : '' }}>{{$user->name}}</option>
          @endforeach
       
          
      </select>
      <input type="hidden" value="{{ $event_id }}" name="event_id">
      @error('priority_level')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
    <div class="col-12">
        <button class="btn btn-primary" type="submit">Book</button>
    </div>
</form>
@endsection

