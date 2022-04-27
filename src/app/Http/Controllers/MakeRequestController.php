<?php

namespace App\Http\Controllers;

use App\Jobs\RequestApiJob;
use App\Models\UserRandom;

class MakeRequestController extends Controller
{
    /**
     * FOR TRIGERRING JOBS
     * 
     * @param int $results
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserRandom::orderBy('created_at','desc')->first();

        $users = [];
        if ($data != null) {
            $users = [
                'mean'      => $data->mean,
                'median'    => $data->median,
                'data'      => json_decode($data->data, true),
            ];
        } else {
            $users = [
                'mean'      => 0,
                'median'    => 0,
                'data'      => [],
            ];
        }

        // return $users['data'];
        return view('view', compact('users'));
    }
}
