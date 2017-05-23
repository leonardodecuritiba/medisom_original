<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface
{

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password', 'remember_token');

    static public function allowed($method = '')
    {

        if ($method == '') {
            $method = 'route-' . Route::currentRouteName();
        }


        $permissions = DB::table('permissions')
            ->join('group_permission', 'group_permission.permission_id', '=', 'permissions.permission_id')
            ->join('groups', 'groups.group_id', '=', 'group_permission.group_id')
            ->join('users', 'users.group_id', '=', 'groups.group_id')
            ->where('users.user_id', '=', Auth::user()->user_id)
            ->where('permissions.method', '=', $method)
            ->count();
//        dd($permissions);
//            ->count();
//        dd(Auth::user()->user_id);
//		return $permissions;
//


        return $permissions;
    }

    /**
     * [update_or_insert atualiza ou insere novo registro]
     * @param  array $params [registros referentes as colunas da tabela]
     * @return [integer]         [retorna id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $user_id = 0;
        $name = '';
        $email = '';
        $password = '';
        $group_id = 2;
        $parent = 0;

        extract($params, EXTR_OVERWRITE);

        $password = Hash::make($password);

        if ($user_id) {
            $user = User::find($user_id);
        } else {
            $user = new User();
        }
        $user->name = $name;

        if ($password != '') {
            $user->password = $password;
        }

        if (!$user_id) {
            $user->email = $email;
            $user->group_id = $group_id;
            $user->parent = $parent;
        }

        $user->save();

        if ($user_id) {
            $params['user_id'] = $user_id;
        } else {
            $params['user_id'] = ($user->id) ? $user->id : DB::getPdo()->lastInsertId();
        }

        #UserTaxonomy::update_or_insert($params);

        return $params['user_id'];
    }

    /**
     * [remove exclui permanentemente o registro do id informado]
     * @param  integer $user_id [id do registro a excluir]
     * @return [bool]
     */
    static public function remove($user_id = 0)
    {

        $user = User::where('user_id', '=', $user_id);
        if ($user->delete())
            return true;
        else
            return false;
    }

    public function sensors_published()
    {
        $query = DB::table('posts')->where('type', 'sensor')->where('status', 'publish');
        if ($this->group_id == 1) {
            $sensors = $query->join('users', 'posts.post_author', '=', 'users.user_id')->get();
        } else {
            $sensors = $query->where('post_author', Auth::id())->get();
        }
        return $sensors;
    }

    //testa se o usuário é admin

    public function usermeta($user_id = '', $key = '')
    {
        return Usermeta::get(($user_id == '') ? $this->user_id : $user_id, $key);
    }

    public function sensors()
    {
        return $this->hasMany('Post', 'post_author', 'user_id')->where('type', 'sensor');
    }

    public function alerts_user()
    {
        return Alerts::whereIn('sensor_id', $this->sensors->lists('post_id'))->where('admin_id', NULL)->get();
    }

    public function alerts_admin()
    {
        return Alerts::where('admin_id', $this->user_id)->get();
    }

    public function alerts()
    {
        return $this->hasMany('Alerts', 'admin_id');
    }

    public function is_admin()
    {
        return ($this->group_id == 1) ? 1 : 0;
    }

}
