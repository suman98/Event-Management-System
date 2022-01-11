<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Location;

class EventController extends Controller
{
        public function __construct(Event $event,Location $location)
    {
        $this->event = $event;
        $this->location = $location;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = $this->event
            ->where(function($query){
                $event_type = request('type');
                if ($event_type == 'up-comming') {
                    return $query->where('start_date','>=',date('Y-m-d'));
                } elseif ($event_type == 'finished') {
                    return $query->where('start_date','<',date('Y-m-d'));
                }
            })
            ->with('user:id,name','location:id,name')
            ->orderBy('start_date')->paginate(20);
        $page_title = "Events";
        return inertia('Home',compact('events','page_title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = "Events  Create";
        $location = $this->location->get(['name','id']);
        return inertia('events/CreateEdit',compact('location','page_title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'title'=>'required|unique:events,title',
            'start_date'=>'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $attributes = $request->only('title','start_date','end_date','description','location_id');
        $attributes['user_id'] = auth()->id();
        $this->event->create($attributes);

        return inertia()->location('/events');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $page_title = "Events  Show";
        $event = $this->event->findOrFail($id);
        $location = $this->location->get(['name','id']);
        $readonly = true;
        $title = $page_title;
        return inertia('events/CreateEdit',compact('event','location','page_title','readonly','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = "Events  Edit";
        $event = $this->event->findOrFail($id);
        $location = $this->location->get(['name','id']);
        $title ='Edit Event #'.$id;
        return inertia('events/CreateEdit',compact('event','location','title','page_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate([
            'title'=>'required|unique:events,title,'.$id,
            'start_date'=>'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $event = $this->event->findOrFail($id);

        $attributes = $request->only('title','start_date','end_date','description','location_id');

        $event->update($attributes);

        return inertia()->location(url()->previous());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->event->find($id)->delete();
        return ['status'=>'ok','deleted_id'=>$id];
    }
}
