<?php

namespace App\Http\Controllers\API;

use App\Models\CategoryItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\JSONResponse;
use Exception;

class CategoryItemController extends Controller
{
    function get_all()
    {
        try {
            $get = CategoryItem::get();
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
            $get = CategoryItem::find($id);
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
                ['category_name' => 'required']
            );

            $query = CategoryItem::insert(
                [
                    "category_name" => $request->category_name
                ]
            );

            if ($query) {
                return JSONResponse::success(
                    [
                        "message" => $request->category_name . " Inserted"
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
                ['category_name' => 'required']
            );

            $data = CategoryItem::find($id);

            $data->category_name = $request->category_name;

            if ($data->save()) {
                return JSONResponse::success(
                    [
                        "message" => $request->category_name . " Updated"
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
            $get = CategoryItem::find($id);
            if ($get) {
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
}
