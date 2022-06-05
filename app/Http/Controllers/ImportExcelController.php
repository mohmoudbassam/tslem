<?php

namespace App\Http\Controllers;


use App\Imports\LocationImport;
use App\Models\RaftCompanyBox;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportExcelController extends Controller
{
    public function import()
    {
        $data = Excel::toArray(new LocationImport(), request()->file('file'));
        foreach ($data as $_date) {
            foreach ($_date as $_d) {
                if ($_d[0]) {
                    RaftCompanyBox::query()->create([
                       'raft_company_location_id'=>6,
                        'box'=>$_d[0],
                        'camp'=>$_d[1].'/'.$_d[2]
                    ]);
                }
            }
        }
    }
}
