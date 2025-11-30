<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MessageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['store']),
            new Middleware('role:super_admin,admin', except: ['store']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Daftar Pesan';
        // $newMessage = Message::where('is_read', 0)->count();
        $messages = Message::latest()->get();
        return view('dashboard.messages.index', compact('title', 'messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email:dns',
            'subject' => 'required|max:255',
            'message' => 'required|string'
        ]);


        Message::create($validatedData);
        return redirect()->back()->with('success', 'Pesan Berhasil Dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        $title = 'Detail Pesan';
        if($message->is_read == 0)
        {
            $message->update(['is_read' => 1]);
        }
        // $newMessage = Message::where('is_read', 0)->count();
        return view('dashboard.messages.show', compact('title', 'message'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        Message::destroy($message->id);
        return redirect(route('messages.index'))->with('success', 'Pesan berhasil dihapus.');
    }
     public function updateStatus(Message $message)
    {
        if($message->is_read == 0 ) {
            $is_read = 1;
        } else {
            $is_read = 0;
        }
        $message->update(['is_read' => $is_read]);
        return redirect( route('messages.index') )->with('success', 'Pesan ditandai sebagai: '. ($is_read == 0 ? 'Belum Dibaca' : 'Sudah Dibaca'));
    }
}
