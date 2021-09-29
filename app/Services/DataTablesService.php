<?php

namespace App\Services;

use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataTablesService
{
    public function create(array $data)
    {
        $show = ($data['modul'] === 'users.transactions' && !isset($data['is_admin'])) ? "dashboard.{$data['modul']}.show" : "admin.{$data['modul']}.show";

        $edit = "admin.{$data['modul']}.edit";

        $delete = $data['modul'] === 'users.carts' ? "dashboard.{$data['modul']}.destroy" : "admin.{$data['modul']}.destroy";

        $datatables = DataTables::of($data['data'])
                ->addIndexColumn()
                ->editColumn('created_at', function($item)
                {
                    return Carbon::parse($item->created_at)->toDayDateTimeString();
                })
                ->addColumn('action', function($item) use($data, $show, $edit, $delete)
                {
                    if ($data['modul'] === 'users')
                    {
                        return '
                        <div class="inline-flex">
                            <a href="'.route($show, $item).'"><span class="px-2 mr-2 text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Show</span></a>
                            <form action="'.route($delete, $item).'" method="POST" onsubmit="return confirm("Are you sure?");">'.
                                method_field('delete') . csrf_field().'
                                <input type="submit" class="px-1 mr-2 text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                            </form>
                        </div>';
                    }
                    
                    if ($data['modul'] === 'users.transactions')
                    {
                        return '
                            <div class="inline-flex">
                                <a href="'.route($show, [$item->user, $item]).'"><span class="px-2 mr-2 text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Show</span></a>
                            </div>';
                    }

                    if ($data['modul'] === 'users.carts')
                    {
                        return '
                            <div class="inline-flex">
                                <form action="'.route($delete, [$item->user, $item]).'" method="POST" onsubmit="return confirm("Are you sure?");">'.
                                    method_field('delete') . csrf_field().'
                                    <input type="submit" class="px-1 mr-2 text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                                </form>
                            </div>';
                    }
                    
                    return '
                        <div class="inline-flex">
                            <a href="'.route($edit, $item).'"><span class="px-2 mr-2 text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-600 hover:text-indigo-900">Edit</span></a>
                            <form action="'.route($delete, $item).'" method="POST" onsubmit="return confirm("Are you sure?");">'.
                                method_field('delete') . csrf_field().'
                                <input type="submit" class="px-1 mr-2 text-xs leading-5 font-semibold rounded-full text-red-600 hover:text-red-900 cursor-pointer" value="Delete">
                            </form>
                        </div>';
                })
                ->rawColumns(['action']);
        
        if ($data['modul'] === 'users.carts')
        {
            $datatables->editColumn('product_id', function($item)
            {
                return $item->product->name;
            })->editColumn('purchase_price', function($item)
            {
                return 'Rp. '.number_format($item->purchase_price, 2);
            })->editColumn('total_each_product', function($item)
            {
                return 'Rp. '.number_format($item->total_each_product, 2);
            });
        }

        if ($data['modul'] === 'users.transactions' && ($data['is_admin'] ?? false))
        {
            $datatables->editColumn('user_id', function($item)
            {
                return $item->user->name;
            });
        }

        return $datatables->make();
    }
}
