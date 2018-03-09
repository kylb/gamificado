<?php
namespace App\Controllers;

use App\Models\EssayBaseModel;
use App\Models\ReportBaseModel;
use Core\BaseController;
use Core\Redirect;
use Core\Validator;

class ReportController extends BaseController {

    private $report;
    protected $pdoLocal;

    public function __construct() {
        parent::__construct();
        $this->report = new ReportBaseModel;
    }

    public function create($id){
        $this->view->nome = "Reports";
        $this->view->acao = 'create';
        $essay = new EssayBaseModel($this->report->getPdo());
        $this->view->essay = $essay->find($id);
        $this->setPageTitle($this->view->nome);
        $this->renderView("reports/_form","layout");
    }

    public function store($request){
        $data = [
            'id_user'  => $request->post->id_user,
            'id_essay' => $request->post->id_essay,
            'conteudo' => $request->post->conteudo
        ];

        if(Validator::make($data,$this->report->rulesCreate(),$this->report)){
            Redirect::route("/painel", "layout");
            return;
        }

        try{
            $this->report->create($data);
            Redirect::route('/painel', [
                'success' => ['Report created with success.']
            ]);
            return;
        }catch(Exception $e){
            Redirect::route('/', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }

    }

    public function listar(){
        $this->view->nome = "Reports";
        $this->view->acao = 'listar';
        $this->view->reports = $this->report->All();
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("reports/listar","layout");
    }

    public function detalhar($id){
        $this->view->nome = "Reports";
        $this->view->acao = 'Detalhar';
        $this->view->reports = $this->report->find($id);
        $this->setPageTitle("{$this->view->nome}");
        $this->renderView("reports/detalhar","layout");
    }

    public function delete($id){
        try{
            if(!$this->auth->check() || $this->auth->tipo() != 1 ){
                Redirect::route('/painel', [
                    'errors' => ['Ahaaa! Você não pode fazer isso.']
                ]);
                return;
            }
            $this->report->delete($id);
            Redirect::route('/report/listar', [
                'success' => ['Report deletado with success.']
            ]);
            return;
        }catch(\Exception $e){
            Redirect::route('/painel', [
                'errors' => [$e->getMessage()]
            ]);
            return;
        }
    }


}
