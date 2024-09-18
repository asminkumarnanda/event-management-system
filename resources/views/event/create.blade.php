@section('title', 'Create Event')

@extends('layouts.app')

@section('content')
@section('sectionHeading', 'Create Event')
<form class="row g-3" action="{{ route('events.store') }}" method="POST">
    @csrf
    <div class="col-md-6">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" autofocus
            value="{{ old('name') }}" name="name">

        @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" value="{{ old('date') }}" aria-describedby="inputGroupPrepend2" name="date">

        @error('date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="time" class="form-label">Time</label>
        <input type="time" class="form-control @error('time') is-invalid @enderror" id="time" value="{{ old('time') }}" aria-describedby="inputGroupPrepend2" name="time">

        @error('time')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="total_slots" class="form-label">Total Slots</label>
        <input type="number" class="form-control @error('total_slots') is-invalid @enderror" id="total_slots" value="{{ old('total_slots') }}" aria-describedby="inputGroupPrepend2" name="total_slots">

        @error('total_slots')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-md-6">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="1">{{old('description')}}</textarea>
        @error('description')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
    </div>

    <div class="col-12">
        <button class="btn btn-primary" type="submit">Submit</button>
    </div>
</form>
@endsection

