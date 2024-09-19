@section('title', 'Bookings')

@extends('layouts.app')

@section('content')
@section('sectionHeading', "Bookings For $eventDetails->name")

<div class="table-responsive small ">

  @if (Auth::user()->hasRole('Admin'))
  <a href="{{ route('bookings.create', ['event' => request()->route('event')]) }}" class="btn btn-primary mb-4">Book Event For {{$eventDetails->name}}</a>
@endif
   
    <table class="table table-striped table-hover">

        <thead>
            <tr>
                <th scope="col">Sl No.</th>
                <th scope="col">Name</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($bookings) > 0)
                @foreach ($bookings as $key => $booking)
                    <tr>
                        <td scope="row">{{ $bookings->firstitem() + $key }}</td>
                        <td scope="row">{{ $booking->user->name}}</td>
                        <td scope="row">
                          <a href="{{ route('bookings.destroy',$booking->id) }}"  onclick="event.preventDefault();
                            document.getElementById('cancel-booking-form').submit();" class="btn btn-danger p-1">Cancel Booking</a>
                         <form id="cancel-booking-form"  action="{{ route('bookings.destroy', $booking->id) }}" method="POST"
                        class="d-none">
                        @csrf
                        @method('DELETE')
                    </form></td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No Events Found</td>
                </tr>
            @endif

        </tbody>
    </table>
    @if (count($bookings) > 0)
        {{ $bookings->links() }}
    @endif
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Description</h1>

                </div>
                <div id="modalBody" class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.querySelectorAll('.viewDescriptionBtn').forEach(viewBtn => {
            viewBtn.addEventListener('click', function() {
                document.querySelector('#modalBody').innerText = this.dataset.description;
            })
        });
    </script>
@endpush
