<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
// use App\User;
use App\UserProject;
use Illuminate\Support\Facades\Auth;
use View, Redirect;

class ProjectController extends BaseController
{
    public $pageId = 1;
    public function __construct()
    {
        parent::__construct();
        View::share('pageId', $this->pageId);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        View::share('hideMenu', true); // Fungsinya untuk menyembunyikan menu dari halaman yang akan dipanggil.
        View::share('hideHome', true);

        return view('project.view-project');
    }

    public function save(Request $request)
    {
        // dd($request->all());die(); // Untuk melihat semua parameter yang dilempar dari view
        $isUpdate = false;
        if (!empty($request->id)) {
            $model = Project::with('userProjects')->find($request->id);
            $isUpdate = true;
        } else {
            $model = new Project;
        }
        $model->project_name = $request->prjname;
        $model->description = $request->prjDescription;
        $model->start_datetime = $request->dateFrom;
        $model->finish_datetime = $request->dateTo;
        $model->pic = Auth::user()->id; // Mengambil ID user yang sedang login
        $model->message_board = "";
        $model->save();

        // Hapus dulu user yang di-assign sebelumya ke project ini, biar jangan duplikat.
        $teamMember = $model->userProjects->pluck('user_id')->toArray();
        foreach ($teamMember as $memberId) {
            if (!in_array($memberId, $request->team_member)) {
                $hapus = UserProject::where(['project_id' => $model->id, 'user_id' => $memberId])->delete();
            }
        }
        // Now save appropriate user who assign in this project
        // dd($model->userProjects->pluck('user_id')->toArray());
        if (!empty($request->team_member)) {
            foreach ($request->team_member as $userId) {
                if (in_array($userId, $model->userProjects->pluck('user_id')->toArray())) {
                    // Jika user sudah ada, then do nothing
                } else {
                    $userProject = new UserProject;
                    $userProject->project_id = $model->id;
                    $userProject->user_id = $userId;
                    $userProject->save();
                }
            }
        }
        // dd($model->toArray());die();
        if ($isUpdate) {
            return redirect()->route('project.view', ['id' => $model->id])->with('status', 'Project successfully created!');
        }
        return redirect('list-project')->with('status', 'Data successfully saved!');
    }

    public function listProject()
    {
        View::share('hideMenu', true);
        $datas = Project::with('user')->get();
        
        return View('project.list-project', ['datas' => $datas]);
    }

    public function view($id)
    {
        $project = Project::with('userProjects.user')->find($id);
        if ($project) {
            return view('project.view-project', ['project' => $project]);
        }
    }

    public function viewTeam()
    {
        return view('project.view-project-team');
    }

    public function messageBoard($id)
    {
        $project = Project::find($id);
        if ($project) {
            return view('project.message-board')->with(['project' => $project]);
        }
    }

    public function messageBoardSave($id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->message_board = request('prjDescription');
            $project->save();
        }
        return Redirect::route('message-board.create', ['id' => $project->id])->with(['project' => $project]);
    }

    public function viewMessage()
    {
        return view('project.view-message-board');
    }
   
}
