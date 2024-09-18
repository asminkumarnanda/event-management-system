@section('title', 'Events')

@extends('layouts.app')

@section('content')
@section('sectionHeading', 'Events')

<div class="table-responsive small ">
    <a href="{{ route('events.create') }}" class="btn btn-primary mb-4">Create Event</a>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">Sl No.</th>
                <th scope="col">Name</th>
                <th scope="col">Date</th>
                <th scope="col">Time</th>
                <th scope="col">Total Slots</th>
                <th scope="col">Available Slots</th>
                <th scope="col">Action</th>

            </tr>
        </thead>
        <tbody>
            @if (count($events) > 0)
                @foreach ($events as $key => $event)
                    <tr>
                        <td scope="row">{{ $events->firstitem() + $key }}</td>
                        <td scope="row">{{ $event->name }}</td>
                        <td scope="row">{{ date('d-m-Y', strtotime($event->date)) }}</td>
                        <td scope="row">{{ date('h:i A', strtotime($event->time)) }}</td>
                        <td scope="row">{{ $event->total_slots }}</td>
                        <td scope="row">{{ $event->available_slots }}</td>
                        @if (Auth::user()->hasRole('Admin'))
                            <td><a href="{{ route('events.edit', $event->id) }}" class="btn btn-secondary p-1">Edit</a>
                                <a href="{{ route('events.destroy', $event->id) }}"
                                    onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();"
                                    class="btn btn-dark p-1">Delete</a></td>
                            <form id="delete-form" action="{{ route('events.destroy', $event->id) }}" method="POST"
                                class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">No Events Found</td>
                </tr>
            @endif

        </tbody>
    </table>
    @if (count($events) > 0)
        {{ $events->links() }}
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
