<?php

namespace App\Http\Controllers\CP\OrderLogs;

use App\Exports\OrderLogsExport;
use App\Http\Controllers\Controller;
use App\Models\OrderLogs;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class OrderLogsController extends Controller
{
    public function index()
    {
        $types = OrderLogs::distinct()->pluck('data');
        $users = User::pluck('name', 'id');

        return view('CP.order_logs.index', [
            'types' => $types->combine($types),
            'users' => $users,
        ]);
    }

    public function list(Request $request)
    {
        $order = collect($request->get('order', [ 'desc' ]))->first();
        $column = data_get($order, 'column', 'created_at');
        if( !isset(OrderLogs::$LIST_COLUMNS_ORDERABLE[ $column ]) ) {
            $column = 'created_at';
        } else {
            $column = OrderLogs::$LIST_COLUMNS_ORDERABLE[ $column ];
        }
        $dir = data_get($order, 'dir', 'desc');

        $orderMethod = $column !== 'order_id' ? "orderBy" : "orderByOrderIdentifier";
        $orderMethodArgs = $column !== 'order_id' ? [ $column, $dir ] : [ $dir ];

        $order_logs = OrderLogs::query()
                               ->$orderMethod(
                                   ...$orderMethodArgs
                               )
                               ->when(request('user_id'), fn($query) => $query->where('user_id', request('user_id')))
                               ->when(request('created_at'), fn($query) => $query->whereDate('created_at', request('created_at')))
                               ->when(request('name', request('type')), function($query) {
                                   return $query->where(function(Builder $q) {
                                       $value = request('name', request('type'));
                                       $columns = [
                                           'id' => fn($v) => [ $v ],
                                           'data' => fn($v) => [ 'like', "%{$v}%" ],
                                       ];

                                       if( request('type') ) {
                                           $columns = array_only($columns, [ 'data' ]);
                                       }

                                       foreach( $columns as $column => $columnQuery ) {
                                           $q = $q->orWhere($column, ...$columnQuery($value));
                                       }

                                       $q = $q->orWhereHas('order', fn($oq)=>$oq->where('identifier', $value));
                                       // if( is_numeric($value) ) {
                                       //     $q = $q->byOrderIdentifier($value);
                                       // }

                                       return $q;
                                   });
                               });

        return DataTables::of($order_logs)
                         ->addColumn('id', fn(OrderLogs $order_logs) => $order_logs->id)
                         ->addColumn('order_id', fn(OrderLogs $order_logs) => $order_logs->order_identifier ?? '-')
                         ->addColumn('user_id', fn(OrderLogs $order_logs) => $order_logs->user()->value('name') ?? '-')
                         ->addColumn('data', fn(OrderLogs $order_logs) => $order_logs->data ?? '-')
                         ->addColumn('created_at', fn(OrderLogs $order_logs) => $order_logs->created_at->format($order_logs->getDateFormat()))
                         ->make(true);
    }

    public function export(Request $request)
    {
        $order = explode(',', $request->get('order'));
        if( count($order) !== 2 ) {
            $order = null;
        }
        $data = $request->merge(compact('order'))
                        ->only([
                                   'name',
                                   'type',
                                   'user_id',
                                   'created_at',
                                   'order',
                               ]);
        $data = collect($data)
            ->filter(fn($v) => !is_null($v));
        $column = head($order) ?: 0;
        if( !isset(OrderLogs::$LIST_COLUMNS_ORDERABLE[ $column ]) ) {
            $column = 'created_at';
        } else {
            $column = OrderLogs::$LIST_COLUMNS_ORDERABLE[ $column ];
        }
        $dir = last($order) ?: 'desc';

        $orderMethod = $column !== 'order_id' ? "orderBy" : "orderByOrderIdentifier";
        $orderMethodArgs = $column !== 'order_id' ? [ $column, $dir ] : [ $dir ];
        $order_logs = OrderLogs::query()
                               ->$orderMethod(
                                   ...$orderMethodArgs
                               )
                               ->when($data->get('user_id'), fn($query) => $query->where('user_id', $data->get('user_id')))
                               ->when($data->get('created_at'), fn($query) => $query->whereDate('created_at', $data->get('created_at')))
                               ->when($data->get('name', $data->get('type')), fn($query) => $query->where(function(Builder $q) use ($data, $request) {
                                   $value = $data->get('name', $data->get('type'));
                                   $columns = [
                                       'id' => fn($v) => [ $v ],
                                       'data' => fn($v) => [ 'like', "%{$v}%" ],
                                   ];

                                   if( $data->get('type') ) {
                                       $columns = array_only($columns, [ 'data' ]);
                                   }

                                   foreach( $columns as $column => $columnQuery ) {
                                       $q = $q->orWhere($column, ...$columnQuery($value));
                                   }

                                   if( is_numeric($value) ) {
                                       $q = $q->byOrderIdentifier($value);
                                   }

                                   return $q;
                               }))
                               ->get();

        return Excel::download(new OrderLogsExport($order_logs), OrderLogs::trans('plural') . '.xlsx');
    }
}
