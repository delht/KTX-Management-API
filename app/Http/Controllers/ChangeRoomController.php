<?php

namespace App\Http\Controllers;

use App\Models\ChangeRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChangeRoomController extends Controller
{
    function index()
    {
        return response()->json(ChangeRoom::all(), Response::HTTP_OK);
    }


    


    

}
