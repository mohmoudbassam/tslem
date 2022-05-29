<?php

namespace App\Http\Controllers\CP\RaftCompany;

use App\Http\Controllers\Controller;


class RaftCompanyController extends Controller{
    public function index() {
        return view("CP.raft_company.index");
    }

}
