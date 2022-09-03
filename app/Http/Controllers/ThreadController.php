<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->threads = Thread::all();
    }

    public function index()
    {
        return view('threads/index', ['threads' => $this->threads]);
    }
}
