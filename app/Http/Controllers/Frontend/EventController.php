<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\View\View;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::with('createdBy')->paginate(10);
        $events->getCollection()->transform(function ($event) {
            $startDate = Carbon::parse($event->start_at)->format('d M Y') ?? '';
            $endDate = Carbon::parse($event->end_at)->format('d M Y') ?? '';
            $totalDuration = Carbon::parse($event->start_at)->diffForHumans($event->end_at, true) ?? '';


            $event->created_by = $event->createdBy->name ?? 'No Name Specified';
            $event->create_time = $event->created_at->diffForHumans() ?? '';
            $event->time = $startDate . ' To ' . $endDate . ' (' . $totalDuration . ')';
            return $event;
        });
        
        return view('public.event.index', compact('events'));
    }
}
