<?php

use \Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\DB;

class SensorController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sensor_fields = ['post_id', 'title', 'status', 'active', 'content'];
        if (Auth::user()->group_id == 1) {
            $user_fields = ['user_id', 'name', 'email'];
            $retorno = array_merge($sensor_fields, $user_fields);
            $sensors = DB::table('posts')->join('users', 'posts.post_author', '=', 'users.user_id')->where('type', '=', 'sensor')->get($retorno);
        } else {
            $sensors = DB::table('posts')->where('posts.post_author', '=', Auth::user()->user_id)->where('type', '=', 'sensor')->get();
        }

        $sensors = BaseController::getDataSensors($sensors);
//        return($sensors[0]->measures_str);exit;
        return View::make('admin.sensors.sensors', array('sensors' => $sensors, 'title' => 'Sensores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $authors = User::where('group_id', 4)->get(['user_id', 'name']);
        return View::make('admin.sensors.sensors-single',
            array('title' => 'Novo Sensor',
                'authors' => $authors,
                'DashboardPeriods' => array_slice(Base::$_DASHBOARD_PERIODS_, 0, 5),
                'Indicadores' => Base::$_INDICADORES_
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $sensor = Post::find($id);
        $sensors = BaseController::getDataSensors($sensor);
        $user = User::find($sensor->post_author);
//                    $authors = User::where('group_id',4)->get(['user_id','name']);
        $authors = User::all(['user_id', 'name']);
        return View::make('admin.sensors.sensors-single',
            array('sensor' => $sensor,
                'user' => $user,
                'title' => 'Editar Sensor',
                'authors' => $authors,
                'DashboardPeriods' => array_slice(Base::$_DASHBOARD_PERIODS_, 0, 5),
                'Indicadores' => Base::$_INDICADORES_,
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return Response
     */
    public function changeStatus($id)
    {
        $Sensor = Post::find($id);
        $Sensor->status = ($Sensor->status == 'publish') ? 'inactive' : 'publish';
        if ($Sensor->save()) {
            Session::flash('alert-code', 'SEN002S');
        } else {
            Session::flash('alert-code', 'SEN002D');
        }
        return Redirect::route('admin.sensores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $sensor_id
     * @return Response
     */
    public function testSensor($sensor_id)
    {
        $now = \Carbon\Carbon::now();
        $created = $now->toDateTimeString();
        $indicadores = Request::all();
        unset($indicadores['_token'], $indicadores['post_id']);

        $sensores_log = $indicadores;
        $sensores_log['post_id'] = $sensor_id;
        $sensores_log['created'] = $created;
        DB::table('sensores_log')->insert($sensores_log);

        Postmeta::update_or_insert(array(
                'post_id' => $sensor_id,
                'key' => 'last_activity',
                'value' => $created)
        );
        //Atualizar a sensormeta
        Sensormeta::update_or_insert([
            'sensor_id' => $sensor_id,
            'last_activity' => $created,
            'last_values' => $indicadores,
            'alert_day' => $now->format('Y-m-d')
        ]);

        Session::flash('alert-code', 'SEN006S');
        return Redirect::route('admin.sensores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int $id
     * @return Response
     */
    public function clearSensorLog($id)
    {
        Session::flash('alert-code', 'SEN005S');
        $per_batch = 250;
        $total_to_process = SensorLog::where('post_id', '=', $id)->count();
        for ($pg = 1; $pg <= $total_to_process; $pg += $per_batch) {
            SensorLog::clear($id, $per_batch, $pg);
        }
        return Redirect::route('admin.sensores.show', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function updateDashboard($id)
    {
        $data = Request::all();
        $dashboard['period'] = $data['dash_period'];
        foreach ($data['dash_measure'] as $key => $value) {
            $dashboard['values'][] = $value;
        }

        Postmeta::update_or_insert(array('post_id' => $id,
            'key' => 'visualization_dash',
            'value' => json_encode($dashboard))); //vai ser setado quando o sensor for criado
        Session::flash('alert-code', 'SEN002S');
        return Redirect::route('admin.sensores.show', $id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function updatePeriodDashboard($id)
    {
        $data = Request::all();
        $Postmeta = Postmeta::get_by($id, 'visualization_dash');
        $dashboard = json_decode($Postmeta->meta_value);
        $dashboard->period = $data['dash_period'];
        $Postmeta->meta_value = json_encode($dashboard);
        $Postmeta->save();
        Session::flash('alert-code', 'SEN002S');
        return Redirect::route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if (Post::existe_sensor_title(Input::get('title'))) {
            Session::flash('alert-code', 'SEN004D');
            return Redirect::back()->withInput();
        }
        $slug = BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));
        $url = Option::get('url_site') . '/admin/sensores/' . $slug;

        $regras = [

            'title' => 'required',
            'measures' => 'required',
        ];

        //executando validação
        $validacao = Validator::make(Input::all(), $regras);

        //se a validação deu errado
        if ($validacao->fails()) {
            Session::flash('alert-code', 'SEN001D');
            return Redirect::back();
        } else {
            $agora = new DateTime('now');
            $vars = array_merge(Input::all(), array(
                'content' => json_encode(Input::get('measures')),
                'status' => 'publish',
                'parent' => Auth::id(),
                'order' => 0,
                'type' => Input::get('type'),
                'slug' => Input::get('type') . '-' . $slug,
                'url' => URL::route('home') . '/admin/sensores/' . $slug
            ));
            unset($vars['post_id']); //tirando o post_id = 0
            $content = array(
                "alert_time" => 0, //acho que nao está sendo usado, vamos investifar e tirar
                "alert_type" => '',
                "alert_num" => 0,
                "alert_day" => $agora->format('d-m-Y'),
                "last_alert" => $agora->format('Y-m-d H:i'),
                "last_activity" => $agora->format('Y-m-d H:i'),
                'alerts_count_' . $agora->format('dmY') => 0,
                "visualization_dash" => '[{"values":["laeq"],"period":["u1"]}]',
            );
            $post_id = Post::update_or_insert($vars);
            if ($post_id) {
                //Inserindo os alerts
                AlertController::inicializaAlertsSensor($post_id, $content);
                Session::flash('alert-code', 'SEN001S');
            } else {
                Session::flash('alert-code', 'SEN001D');
            }
        }
        return Redirect::route('admin.sensores.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        $sensor = Post::find($id);
        $slug = BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));
        $url = Option::get('url_site') . '/admin/sensores/' . $slug;
        $vars = array_merge(Input::all(), array(
            'content' => json_encode(Input::get('measures')),
            'type' => 'sensor',
            'slug' => $slug,
            'url' => $url,
        ));

        $sensor_postmeta = array(
            "alert_type" => (Input::get('alert_type') != NULL) ? json_encode(Input::get('alert_type')) : Input::get('alert_type'),
            "alert_time" => Input::get('alert_time'),
            "alert_day" => Input::get('alert_day'),
        );

        foreach ($sensor_postmeta as $key => $value) {
            Postmeta::update_or_insert(array('post_id' => $sensor->post_id, 'key' => $key, 'value' => $value));
        }

        if ($sensor->update($vars)) {
            Session::flash('alert-code', 'SEN002S');
        } else {
            Session::flash('alert-code', 'USR002D');
        }
        return Redirect::route('admin.sensores.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $post_ids = Post::where('parent', $id)->lists('post_id');
        foreach ($post_ids as $pid) {
            ReportController::removeReport($pid);
        }
        Post::remove($id);
        if (Post::removeDataSensor($id)) {
            Session::flash('alert-code', 'SEN003S');
        } else {
            Session::flash('alert-code', 'SEN003D');
        }
        return Redirect::route('admin.sensores.index');
    }

}
