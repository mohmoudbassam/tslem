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
                                    ->where('is_published',4);

        if($q->raft_company_box_id){
            $query = $query->where('raft_company_box_id',$q->raft_company_box_id);
        }

                                    

        return DataTables::of($query->get())->make(true);
    }
}
