<?php

namespace App\Http\Controllers\API;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\JSONResponse;
use File;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    function get_all()
    {
        try {
            $get = DB::select("SELECT a.*,b.category_name FROM items a JOIN category_items b ON a.category_id = b.id");
            return JSONResponse::success(
                $get,
                'Get Data Success',
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

    function get_new()
    {
        try {
            $get = DB::select("SELECT a.*,b.category_name FROM items a JOIN category_items b ON a.category_id = b.id ORDER BY a.id DESC LIMIT 3");
            return JSONResponse::success(
                $get,
                'Get Data Success',
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

    function get_populer()
    {
        try {
            $get = DB::select("SELECT a.*,b.category_name FROM items a JOIN category_items b ON a.category_id = b.id ORDER BY RAND() LIMIT 7");
            return JSONResponse::success(
                $get,
                'Get Data Success',
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

    function search(Request $request)
    {
        try {
            $request->validate(
                [
                    'content' => 'required'
                ]
            );
            $get = DB::select(
                "SELECT a.*,b.category_name 
                FROM items a 
                JOIN category_items b ON a.category_id = b.id
                WHERE a.item_name LIKE '%$request->content%' OR b.category_name LIKE '%$request->content%' "
            );
            return JSONResponse::success(
                $get,
                'Get Data Success',
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

    function get($id)
    {
        try {
            $get = Item::find($id);
            return JSONResponse::success(
                $get,
                'Get Data Success',
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

    function store(Request $request)
    {

        try {
            $request->validate(
                [
                    'category_id' => 'required',
                    'item_name' => 'required',
                    'item_stock' => 'required',
                    'item_price' => 'required',
                    'file' => 'required|mimes:png,jpg,bmp'
                ]
            );

            $file_name = 'ITEMS_' . time() . '.' . $request->file->extension();

            $request->file->move(public_path('assets/img/items'), $file_name);

            $query = Item::insert(
                [
                    'category_id' => $request->category_id,
                    'item_name' =>  $request->item_name,
                    'item_stock' =>  $request->item_stock,
                    'item_price' =>  $request->item_price,
                    'item_img' => $file_name
                ]
            );

            if ($query) {
                return JSONResponse::success(
                    [
                        "message" => "Item Inserted"
                    ],
                    'Insert Success',
                );
            }
        } catch (Exception $e) {

            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Insert Failed',
                500
            );
        }
    }

    function update($id, Request $request)
    {
        try {
            $request->validate(
                [
                    'category_id' => 'required',
                    'item_name' => 'required',
                    'item_stock' => 'required',
                    'item_price' => 'required'
                ]
            );

            $data = Item::find($id);

            if ($request->file) {

                $this->removeImage($data['item_img']);

                $request->validate(
                    [
                        'file' => 'required|mimes:png,jpg,bmp'
                    ]
                );

                $file_name = 'ITEMS_' . time() . '.' . $request->file->extension();

                $request->file->move(public_path('assets/img/items'), $file_name);
                $data->item_img = $file_name;
            }

            $data->category_id = $request->category_id;
            $data->item_name = $request->item_name;
            $data->item_stock = $request->item_stock;
            $data->item_price = $request->item_price;

            if ($data->save()) {
                return JSONResponse::success(
                    [
                        "message" => "Item Updated",
                        $data
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
                'Update Failed',
                500
            );
        }
    }

    function delete($id)
    {
        try {
            $get = Item::find($id);
            if ($get) {
                // Remove File
                $this->removeImage($get['item_img']);

                // Remove Data From Database
                $get->delete();

                return JSONResponse::success(
                    [
                        "status" => 1,
                        "message" => "Item Deleted"
                    ],
                    'Delete Success',
                );
            } else {
                return JSONResponse::success(
                    [
                        "status" => 0,
                        "message" => "No Item to Delete"
                    ],
                    'Delete Failed',
                );
            }
        } catch (Exception $e) {
            return JSONResponse::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $e
                ],
                'Delete Failed',
                500
            );
        }
    }

    function removeImage(String $file_name)
    {
        if (File::exists(public_path('assets/img/items/' . $file_name))) {
            File::delete(public_path('assets/img/items/' . $file_name));
        } else {
            // dd('File does not exists.');
        }
    }
}
