<?php

namespace App\Http\Controllers\CP\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SessionController extends Controller
{
    public function index()
    {
        return view("CP.session.index");
    }

    public function list(Request $request)
    {
        $query = \App\Models\Session::ByLocation(auth()->user()->raft_company_type)
                                    ->with('RaftCompanyLocation', 'RaftCompanyBox')
                                    ->published()
                                    ->when(request('raft_company_box_id'), function ($q) {
                                        $q->where('raft_company_box_id', request('raft_company_box_id'));
                                    });

        return DataTables::of($query->get())->make(true);
    }
}
