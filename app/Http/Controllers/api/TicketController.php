<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\File;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        $ticket = Ticket::where('customer_id', $user_id)
                    ->orderBy('date', 'DESC')->get();
        return $ticket;
    }

    public function agent($user_id)
    {
        $ticket = Ticket::where('agent_id', $user_id)
                    ->orderBy('date', 'DESC')->get();
        return $ticket;
    }

    public function admin()
    {
        $ticket = Ticket::with('agent:id,name')->orderBy('id', 'DESC')->get();
        return $ticket;
    }

    public function ticketDetail($ticket_id, $file_id)
    {
        $ticket = Ticket::where('id', '=', $ticket_id)->get();
        $files = File::where('ticketing_id', $file_id)->get();
        $replies = Reply::with('files')->with('user:id,name,role')->where('ticket_id', '=', $ticket_id)->orderBy('id', 'DESC')->get();

        $result = array("ticket" => $ticket, "files" => $files, "replies" => $replies);
        

        return $result;
    }

    public function ticketStatus($ticketID, $statusValue)
    {
        $ticket = Ticket::find($ticketID);
        if ($ticket->status != "Closed") {
            $ticket->status =  "Closed";
        } else {
            $ticket->status = "Replied";
        }

        $ticket->save();

        $ticket = Ticket::where('id', '=', $ticketID)->get();

        $result = array("ticket" => $ticket);

        return  $result;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticketing_id = Str::random(15);
        $ticket = new Ticket();
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->department = $request->department;
        $ticket->service = $request->service;
        $ticket->priority = $request->priority;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->customer_id = $request->customer_id;
        $ticket->file_id = $ticketing_id;
        $ticket->date = $request->date;
        
        if ($ticket->save()) {
            if ($request->has('uploads') && !empty($request->has('uploads'))) {
                foreach ($request->file('uploads') as $upload) {
                    $filename = time().rand(3, 2). '.'.$upload->getClientOriginalExtension();
  
                    $upload->move('uploads/', $filename);
  
                    /*   File::create([
                         'file_name' => $filename,
                         'ticketing_id' => $ticketing_id
                     ]); */

                    $file = new File();
                    $file->file_name = $filename;
                    $file->ticketing_id = $ticketing_id;
                    $file->save();
                }
            }

            return "success";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update($agent_id, $ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        $ticket->agent_id = $agent_id;

        if ($ticket->save()) {
            $ticket = Ticket::with('agent:id,name')->orderBy('id', 'DESC')->get();
            return $ticket;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
