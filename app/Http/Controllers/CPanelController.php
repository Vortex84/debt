<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PageProcessorServ;
use App\Services\PageFilterServ;
use App\Services\CPanelServ;
use App\Services\SystemServ;
use App\Repositories\Listdl\IListRepository;

class CPanelController extends Controller
{
    protected $pageserv;
    protected $filter;
    protected $cp_serv;
    protected $sys_serv;
    protected $listdl;

    public function __construct(PageProcessorServ $pageserv,
                                PageFilterServ $filter,
                                CPanelServ $cp_serv,
                                SystemServ $sys_serv,
                                IListRepository $listdl
                                )
    {
        $this->pageserv = $pageserv;
        $this->filter = $filter;
        $this->cp_serv = $cp_serv;
        $this->sys_serv = $sys_serv;
        $this->listdl = $listdl;
    }

    public function index(Request $request)
    {
        $sub = $request->session()->get('sub');
        $sid = $request->session()->get('sid');

        $request->session()->put('f', 29);
        $pg = (int)$request->page;

        $lim_pg = $this->pageserv->lim_pg();

        $flt = $this->filter->filter_construct();
        $flt['flt_sql'].= $this->filter->favor_flt();

        // Всего должников
        $total = $this->listdl->count_dl();

        // Всего должников по фильтру
        $selected = $this->listdl->count_filter_dl($flt['flt_sql']);

        $pgn = $this->pageserv->pagination($selected,$lim_pg['lim'],$pg);
        //Сортировка
        $sort = $this->pageserv->sort_flt();

        $datain = array('flt_sql'=>$flt['flt_sql'],'ord_by'=>$sort['ord_by'],'order'=>$sort['order'],'pg'=>$pg,
                        'lim'=>$lim_pg['lim'],'sub'=>$sub);

        $list_q = $this->listdl->get_list_dl($datain);

        $prepare_data = $this->cp_serv->prepare_data($list_q,array('sub'=>$sub,'sid'=>$sid));

        return view('cpanel',['data_cp'     => $prepare_data['data_cp'], 'lim_sel'  => $lim_pg['lim_sel'],             'pgn'  => $pgn,
                              'print_blank' => $prepare_data['pr_bl'],   'selected' => $selected,                      'sort' => $sort['cls'],
                              'all_flt'     => $flt['flt_html'],         'ftxt'     => $prepare_data['favor']['ftxt'], 'sub'  => $sub,
                              'deliv'       => $prepare_data['deliv'],   'area'     => $prepare_data['area'],          'sid'  => $sid,
                              'datab'       => $prepare_data['datab'],   'fid'      => $prepare_data['favor']['fid'],
                              'datac'       => $prepare_data['datac'],   'fcl'      => $prepare_data['favor']['fcl'],
                              'total'       => $total]);
    }

    function save_comm_kur(Request $request)
    {
        if ($request->ajax() and $request->has('iddl') and (int)$request->iddl>0)
        {
            $this->listdl->update_comm_forcurator(array('iddl'=>$request->iddl,'forkcom_dl'=>$this->sys_serv->strip_data($request->comm)));
            return "1";
        }
        return "0";
    }
    function get_comm_kur(Request $request)
    {
        if ($request->ajax() and $request->has('iddl') and (int)$request->iddl>0)
        {
            $res = $this->listdl->get_comm_curator($request->iddl);
            return htmlspecialchars($res->forkcom_dl);
        }
        return "0";
    }
    function cl_comm_save(Request $request)
    {
        if ($request->ajax() and $request->has('cid') and $request->has('dat'))
        {
            $this->listdl->update_comm_dl(array('iddl'=>$request->cid,'comm_dl'=>$this->sys_serv->strip_data($request->dat)));
            return json_encode("1");
        }
        return json_encode("0");
    }
}