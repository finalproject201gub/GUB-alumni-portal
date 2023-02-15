<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminJobBoardController extends Controller
{
    public function index()
    {
        return "index";
    }

    public function create()
    {
        return view('backend.job-board.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

    public function edit()
    {

    }

    public function show()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
