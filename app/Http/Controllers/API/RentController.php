<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Rent;
use App\Models\RentDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Helpers\JSONResponse;
use Illuminate\Support\Facades\DB;


class RentController extends Controller
{
    function add_rent(Request $request)
    {

        try {

            $inv_number = "#RCM-" . date("YmdHis");

            $insert_rent = Rent::insert(
                [
                    "cust_id" => $request->cust_id,
                    "invoice_number" => $inv_number,
                    "book_datetime" => Carbon::now(),
                    "payment_datetime" => null,
                    "rent_datetime_start" => $request->rent_start,
                    "rent_datetime_end" => $request->rent_end,
                    "return_datetime" => null,
                    "payment_status" => "Belum Dibayar",
                    "payment_file" => null,
                ]
            );

            if ($insert_rent) {


                $get_rent = Rent::where('invoice_number', $inv_number)->first();

                if ($get_rent) {

                    $items = [];

                    foreach ($request->items as $k => $item) {

                        $data = [
                            "rent_id" => $get_rent->id,
                            "item_id" => $item["item_id"],
                            "item_qty" => $item["qty"],
                            "rent_item_price" => $item["price"]
                        ];

                        $items[] = $data;
                    }

                    $insert_detail = RentDetail::insert($items);

                    if ($insert_detail) {

                        $rent = $this->get_data_rent($get_rent->id);

                        return JSONResponse::success(
                            $rent,
                            'Insert Rent Success',
                        );
                    }
                }
            }
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Add Rent Failed',
                500
            );
        }
    }

    function get_rent($id)
    {

        try {

            $rent = $this->get_data_rent($id);

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }

    function get_rent_booked($id)
    {
        try {

            $rent = [];

            if ($id != 0) {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Belum Dibayar')
                    ->where('rents.payment_datetime', '=', NULL)
                    ->where('rents.payment_file', '=', NULL)
                    ->where('rents.cust_id', '=', $id)
                    ->orderByDesc('rents.id')
                    ->get();
            } else {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Belum Dibayar')
                    ->where('rents.payment_datetime', '=', NULL)
                    ->where('rents.payment_file', '=', NULL)
                    ->orderByDesc('rents.id')
                    ->get();
            }

            foreach ($get_rent as $k => $v) {

                $get_rent_items = DB::table('rent_details')
                    ->select('rent_details.*', 'items.item_name', 'items.item_img')
                    ->join('items', 'rent_details.item_id', '=', 'items.id')
                    ->where('rent_details.rent_id', '=', $v->id)
                    ->get();
                $sum_price = DB::table('rent_details')->where('rent_id', $v->id)->sum('rent_item_price');

                $data = $v;
                $data->status = "Belum Dibayar";
                $data->items = $get_rent_items;
                $data->total_price = $sum_price;

                $rent[] = $data;
            }

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }
    function get_rent_waiting($id)
    {
        try {

            $rent = [];

            if ($id != 0) {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Belum Dibayar')
                    ->where('rents.payment_datetime', '!=', NULL)
                    ->where('rents.payment_file', '!=', NULL)
                    ->where('rents.cust_id', '=', $id)
                    ->orderByDesc('rents.id')
                    ->get();
            } else {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Belum Dibayar')
                    ->where('rents.payment_datetime', '!=', NULL)
                    ->where('rents.payment_file', '!=', NULL)
                    ->orderByDesc('rents.id')
                    ->get();
            }

            foreach ($get_rent as $k => $v) {

                $get_rent_items = DB::table('rent_details')
                    ->select('rent_details.*', 'items.item_name', 'items.item_img')
                    ->join('items', 'rent_details.item_id', '=', 'items.id')
                    ->where('rent_details.rent_id', '=', $v->id)
                    ->get();
                $sum_price = DB::table('rent_details')->where('rent_id', $v->id)->sum('rent_item_price');

                $data = $v;
                $data->status = "Menunggu Konfirmasi";
                $data->items = $get_rent_items;
                $data->total_price = $sum_price;

                $rent[] = $data;
            }

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }

    function get_rent_lunas($id)
    {
        try {

            $rent = [];

            if ($id != 0) {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '>', NOW())
                    ->where('rents.cust_id', '=', $id)
                    ->orderByDesc('rents.id')
                    ->get();
            } else {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '>', NOW())
                    ->orderByDesc('rents.id')
                    ->get();
            }

            foreach ($get_rent as $k => $v) {

                $get_rent_items = DB::table('rent_details')
                    ->select('rent_details.*', 'items.item_name', 'items.item_img')
                    ->join('items', 'rent_details.item_id', '=', 'items.id')
                    ->where('rent_details.rent_id', '=', $v->id)
                    ->get();
                $sum_price = DB::table('rent_details')->where('rent_id', $v->id)->sum('rent_item_price');

                $data = $v;
                $data->status = "Lunas";
                $data->items = $get_rent_items;
                $data->total_price = $sum_price;

                $rent[] = $data;
            }

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }

    function get_rent_dipinjam($id)
    {
        try {

            $rent = [];
            if ($id != 0) {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '<=', NOW())
                    ->where('rents.return_datetime', '=', NULL)
                    ->where('rents.cust_id', '=', $id)
                    ->orderByDesc('rents.id')
                    ->get();
            } else {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '<=', NOW())
                    ->where('rents.return_datetime', '=', NULL)
                    ->orderByDesc('rents.id')
                    ->get();
            }
            foreach ($get_rent as $k => $v) {

                $get_rent_items = DB::table('rent_details')
                    ->select('rent_details.*', 'items.item_name', 'items.item_img')
                    ->join('items', 'rent_details.item_id', '=', 'items.id')
                    ->where('rent_details.rent_id', '=', $v->id)
                    ->get();
                $sum_price = DB::table('rent_details')->where('rent_id', $v->id)->sum('rent_item_price');

                $data = $v;
                $data->status = "Dipinjam";
                $data->items = $get_rent_items;
                $data->total_price = $sum_price;

                $rent[] = $data;
            }

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }

    function get_rent_selesai($id)
    {
        try {

            $rent = [];

            if ($id != 0) {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '<=', NOW())
                    ->where('rents.return_datetime', '!=', NULL)
                    ->where('rents.cust_id', '=', $id)
                    ->orderByDesc('rents.id')
                    ->get();
            } else {
                $get_rent = DB::table('rents')
                    ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
                    ->join('customers', 'rents.cust_id', '=', 'customers.id')
                    ->where('rents.payment_status', '=', 'Lunas')
                    ->where('rents.rent_datetime_start', '<=', NOW())
                    ->where('rents.return_datetime', '!=', NULL)
                    ->orderByDesc('rents.id')
                    ->get();
            }

            foreach ($get_rent as $k => $v) {

                $get_rent_items = DB::table('rent_details')
                    ->select('rent_details.*', 'items.item_name', 'items.item_img')
                    ->join('items', 'rent_details.item_id', '=', 'items.id')
                    ->where('rent_details.rent_id', '=', $v->id)
                    ->get();
                $sum_price = DB::table('rent_details')->where('rent_id', $v->id)->sum('rent_item_price');

                $data = $v;
                $data->status = "Selesai";
                $data->items = $get_rent_items;
                $data->total_price = $sum_price;

                $rent[] = $data;
            }

            return JSONResponse::success(
                $rent,
                'Get Rent Success',
            );
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Get Data Failed',
                500
            );
        }
    }

    function get_data_rent($id)
    {
        $get_rent = DB::table('rents')
            ->select('rents.*', 'customers.cust_name', 'customers.cust_address', 'customers.cust_phone', 'customers.user_id')
            ->join('customers', 'rents.cust_id', '=', 'customers.id')
            ->where('rents.id', '=', $id)
            ->first();

        if ($get_rent) {
            $get_rent_items = DB::table('rent_details')
                ->select('rent_details.*', 'items.item_name', 'items.item_img')
                ->join('items', 'rent_details.item_id', '=', 'items.id')
                ->where('rent_details.rent_id', '=', $id)
                ->get();
            $sum_price = DB::table('rent_details')->where('rent_id', $id)->sum('rent_item_price');

            $rent = $get_rent;
            $rent->status = "Belum Dibayar";
            $rent->items = $get_rent_items;
            $rent->total_price = $sum_price;
        } else {
            $rent = "Kosong";
        }

        return $rent;
    }

    function update_rent_payment_status($id)
    {

        try {

            $rent = Rent::find($id);

            $rent->payment_status = 'Lunas';

            if ($rent->save()) {
                return JSONResponse::success(
                    [
                        "message" => "Rent Payment Status : Lunas",
                        $rent
                    ],
                    'Update Success',
                );
            }
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Update Data Failed',
                500
            );
        }
    }

    function update_rent_return_date($id)
    {

        try {

            $rent = Rent::find($id);

            $rent->return_datetime = Carbon::now();

            if ($rent->save()) {
                return JSONResponse::success(
                    [
                        "message" => "Rent Return Date Updated",
                        $rent
                    ],
                    'Update Success',
                );
            }
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Update Data Failed',
                500
            );
        }
    }

    function update_rent_payment_file($id, Request $request)
    {

        try {

            $rent = Rent::find($id);

            if ($request->file) {

                $request->validate(
                    [
                        'file' => 'required|mimes:png,jpg,bmp'
                    ]
                );

                $file_name = 'PAYMENTS_' . time() . '.' . $request->file->extension();

                $request->file->move(public_path('assets/img/payments'), $file_name);
                $rent->payment_file = $file_name;
                $rent->payment_datetime = Carbon::now();
            }

            if ($rent->save()) {
                return JSONResponse::success(
                    [
                        "message" => "Rent Payment File : Uploaded",
                        $rent
                    ],
                    'Update Success',
                );
            }
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Update Data Failed',
                500
            );
        }
    }
}
