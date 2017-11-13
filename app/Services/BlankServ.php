<?php

namespace App\Services;

use App\Repositories\Blank\IBlankRepository;

class BlankServ
{
    protected $blank;

    public function __construct(IBlankRepository $blank)
    {
        $this->blank = $blank;
    }

    public function save_blank($request)
    {
        if ($request->isMethod('post') and $request->hasFile('blankfile')) {
            $size_file = $request->file('blankfile')->getClientSize();

            if ($size_file < 10000000 and $size_file != 0)
            {
                $ext = $request->blankfile->extension();

                if ($ext=="docx")
                {
                    $type_blank = (int)$request->sel_blank;

                    $r = $this->blank->get_blank_byid($type_blank);

                    $filename = $r->file_name;

                    $sub = $request->session()->get('sub');
                    $sid = $request->session()->get('sid');

                    if(!file_exists(base_path('public/docs/').$sub."/jur_blanks")){
                        mkdir(base_path('public/docs/').$sub."/jur_blanks",0755,true);
                    }

                    if($request->file('blankfile')->move(base_path('public/docs/').$sub."/jur_blanks/", $filename.".docx"))
                    {

                        $datain = array('iddb'=>$sid,'type'=>$type_blank);
                        $q = $this->blank->get_blank_jur_bydb_type($datain);

                        if(count($q)==0){

                            $this->blank->insert_blank_jur($datain);
                        }
                        return "1";
                    }else{ return "2"; }
                } else { return "5"; }
            } else { return "4"; }
        }
        return "0";
    }

    public function get_blank_type($request)
    {
        $sid = $request->session()->get('sid');

        $q = $this->blank->get_blank_type($sid);

        $b2 = $b3 = $b4 = $b5 = array();
        foreach($q as $r){
            $arr_bt = array('title_bt'=>$r->title_bt,'type'=>$r->type,'idblj'=>$r->idblj);

            if($r->type_bt=="2"){      $b2[] = $arr_bt;
            }elseif($r->type_bt=="3"){ $b3[] = $arr_bt;
            }elseif($r->type_bt=="4"){ $b4[] = $arr_bt;
            }elseif($r->type_bt=="5"){ $b5[] = $arr_bt; }
        }

        $list = view('forms.blank_type',['b2'=>$b2,'b3'=>$b3,'b4'=>$b4,'b5'=>$b5]);
        return $list;
    }
    public function get_blank_list($request)
    {
        $sid = $request->session()->get('sid');

        $q = $this->blank->get_blank_list($sid);

        $sud = $sogl = $isp = $bank = array();

        foreach($q as $r)
        {
            $arr_temp = array();
            if($r->type_bt=="2" or $r->type_bt=="3" or $r->type_bt=="4" or $r->type_bt=="5")
            {
                $arr_temp = array('title_bt'=>$r->title_bt,'type'=>$r->type,'idblj'=>$r->idblj);
            }

            if($r->type_bt=="2"){       $sud[]  = $arr_temp;
            }elseif($r->type_bt=="3"){  $sogl[] = $arr_temp;
            }elseif($r->type_bt=="4"){  $isp[]  = $arr_temp;
            }elseif($r->type_bt=="5"){  $bank[] = $arr_temp;  }
        }

        $list = view('forms.list_blank',['sud'=>$sud,'sogl'=>$sogl,'isp'=>$isp,'bank'=>$bank]);
        return $list;
    }

    public function del_blank($request)
    {
        $sub = $request->session()->get('sub');
        $sid = $request->session()->get('sid');
        $type_blank = (int)$request->tblank;

        $r = $this->blank->get_blank_byid($type_blank);

        if(count($r)>0)
        {
            $filename = $r->file_name;

            if ($filename != "" and file_exists(base_path('public/docs/').$sub."/jur_blanks/".$filename.".docx")) {
                if (!unlink(base_path('public/docs/').$sub."/jur_blanks/".$filename.".docx")) {
                    return "3";
                }
            }

            $this->blank->del_blank_jur(array('idblj'=>$request->idb,'iddb'=>$sid));

            return "1";
        }
        return "2";
    }
}