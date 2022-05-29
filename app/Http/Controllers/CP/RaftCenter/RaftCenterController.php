<?php

namespace App\Http\Controllers\CP\RaftCenter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BeneficiresCoulumns;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;

class RaftCenterController extends Controller{

    public function index() {
        return view("CP.raft_center.index");
    }
}