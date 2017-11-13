<?php
namespace App\Repositories\Blank;

interface IBlankRepository
{

    public function get_blank_bydb($datain);
    public function get_blank_byid($idbt);
    public function get_blank_type($sid);
    public function get_blank_list($sid);

    public function get_blank_jur_bydb_type($datain);
    public function insert_blank_jur($datain);
    public function del_blank_jur($datain);

    public function get_blank_ctrl_db_type($datain);

}
