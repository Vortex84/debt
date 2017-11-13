<?php
namespace App\Repositories\Blank;

use App\Models\Blank_type;
use App\Models\Blank_jur;
use App\Models\Blank_control;

class BlankRepository implements IBlankRepository
{
    public function get_blank_bydb($datain)
    {
        return Blank_type::where('type_bt',(int)$datain['type'])->whereRaw('iddb IN (0,'.$datain['sid'].')')->get();
    }
    public function get_blank_byid($idbt)
    {
        return Blank_type::find((int)$idbt);
    }
    public function get_blank_type($sid)
    {
        return Blank_type::whereRaw("type_bt IN (2,3,4,5) and iddb IN (0,".(int)$sid.")")->orderby('title_bt')->get();
    }
    public function get_blank_list($sid)
    {
        return Blank_jur::BlankList($sid);
    }

    public function get_blank_jur_bydb_type($datain)
    {
        return Blank_jur::where('iddb',$datain['sid'])->where('type',$datain['type'])->first();
    }
    public function insert_blank_jur($datain)
    {
        return Blank_jur::insert($datain);
    }

    public function del_blank_jur($datain)
    {
        return Blank_jur::where('idblj', (int)$datain['iddb'])->where('iddb', (int)$datain['sid'])->delete();
    }

    public function get_blank_ctrl_db_type($datain)
    {
        return Blank_control::where('iddb',(int)$datain['iddb'])->where('type_bl',(int)$datain['type_bl'])->first();
    }


}