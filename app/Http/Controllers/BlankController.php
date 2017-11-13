<?php

namespace App\Http\Controllers;

use App\Services\BlankServ;
use Illuminate\Http\Request;

class BlankController extends Controller
{
    protected $blank_serv;

    public function __construct(BlankServ $blank_serv)
    {
        $this->blank_serv = $blank_serv;
    }
    public function save_blank(Request $request)
    {
        if(!$request->has('sel_blank') or (int)$request->sel_blank==0){ return "3"; }

        return $this->blank_serv->save_blank($request);
    }

    public function get_blank_type(Request $request)
    {
        return $this->blank_serv->get_blank_type($request);
    }
    public function get_blank_list(Request $request)
    {
        return $this->blank_serv->get_blank_list($request);
    }

    public function del_blank(Request $request)
    {
        if ($request->ajax() and $request->has('idb') and $request->has('tblank')
            and (int)$request->idb>0 and (int)$request->tblank>0)
        {
            return $this->blank_serv->del_blank($request);
        }
        return "2";
    }
}