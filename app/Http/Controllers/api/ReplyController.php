<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Reply;
use App\Ticket;
use App\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $file_id = Str::random(15);
        $reply = new Reply();
        $reply->name = $request->name;
        $reply->email = $request->email;
        $reply->message = $request->message;
        $reply->user_id = $request->user_id;
        $reply->ticket_id = $request->ticket_id;
        $reply->file_id = $file_id;
        $reply->date = $request->date;
        $reply->save();

        if ($request->has('uploads') && !empty($request->file('uploads'))) {
            foreach ($request->file('uploads') as $upload) {
                $filename = time().rand(3, 2). '.'.$upload->getClientOriginalExtension();

                $upload->move('uploads/', $filename);

                $file = new File();
                $file->file_name = $filename;
                $file->ticketing_id = $file_id;
                $file->save();
            }
        }

        $ticket = Ticket::find($request->ticket_id);
        $ticket->status = "Replied";
        $ticket->save();


        $replies = Reply::with('files')->with('user:id,name,role')->where('ticket_id', '=', $request->ticket_id)->orderBy('id', 'DESC')->get();
        return  $replies;
    }

    public function test()
    {
        $replies = Reply::with('files')->with('user:id,name,role')->orderBy('id', 'DESC')->get();
        return $replies;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
