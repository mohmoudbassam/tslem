<?php

namespace App\Http\Controllers\CP\TaslemMaintenance;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderSharer;
use App\Models\OrderSharerReject;
use App\Models\User;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\OrderService;
use App\Models\OrderSpecilatiesFiles;

class TaslemMaintenance extends Controller
{
    public function index()
    {
        return view('CP.taslem_maintenance_layout.index');
    }
}
