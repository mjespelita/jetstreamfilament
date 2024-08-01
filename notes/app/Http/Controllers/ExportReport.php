<?php

namespace App\Http\Controllers;

use App\Models\Ins;
use App\Models\Stocks;
use App\Smark\Smark;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExportReport extends Controller
{
    public function exportReportProcess()
    {

        $exportable = [];

        $ins = Ins::all();

        foreach ($ins as $key => $value) {
            array_push($exportable, array(
                'product_name' => Stocks::where('id', $value['product'])->value('name'),
                'receipt_number' => $value['receipt_number'],
                'driver_supplier' => $value['name'],
                'quantity' => $value['quantity'],
                'date' => Carbon::parse($value['created_at'])->format('F j, Y (l) H:i:s')
            ));
        }

        Smark::_downloadExcelAs('Product Ins', array(
            array(
                'product_name' => "Product Name",
                'receipt_number' => "Receipt Number",
                'driver_supplier' => "Driver / Supplier",
                'quantity' => "Quantity Delivered",
                'data' => "Date"
            )
            ), $exportable);
    }
}
