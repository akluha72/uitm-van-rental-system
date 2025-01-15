<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('van', 'customer')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('van', 'customer')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'approved']);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking approved successfully.');
    }

    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'rejected']);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking rejected successfully.');
    }

    public function getData()
    {
        $bookings = Booking::with(['user', 'van'])->select('bookings.*');

        return DataTables::of($bookings)
            ->addColumn('customer', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->addColumn('van', function ($row) {
                return $row->van->name ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.bookings.show', $row->id) . '" class="text-blue-500">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

