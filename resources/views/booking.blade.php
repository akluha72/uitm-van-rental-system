@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold">Booking for {{ $van->model }}</h1>
    <p>Capacity: {{ $van->capacity }}</p>
    <p>Rental Rate: RM{{ number_format($van->rental_rate, 2) }}</p>
    <form action="{{ route('bookings.store') }}" method="POST" class="mt-4">
        @csrf
        <input type="hidden" name="van_id" value="{{ $van->id }}">
        <div class="mb-4">
            <label for="start_date">Start Date</label>
            <input type="date" id="start_date" name="start_date" required class="border rounded p-2">
        </div>
        <div class="mb-4">
            <label for="end_date">End Date</label>
            <input type="date" id="end_date" name="end_date" required class="border rounded p-2">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Confirm Booking</button>
    </form>
</div>
@endsection
