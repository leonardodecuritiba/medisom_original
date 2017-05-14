<?php

class Permission extends Eloquent
{

    public $timestamps = false;
    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';

    static public function add($params = array())
    {
        $permission_id = 0;
        $name = '';
        $method = '';
        $parent = 0;
        $order = 0;
        $default = 0;
        $get_parent = '';

        extract($params, EXTR_OVERWRITE);

        $check = Permission::where('method', '=', $method)->count();

        if (!$check) {
            if ($get_parent != '') {
                $parents = Permission::where('method', '=', $get_parent)->get();
                $parent = (count($parents) > 0) ? $parents[0]->permission_id : 0;
            }

            $permission = new Permission;
            $permission->name = $name;
            $permission->method = $method;
            $permission->parent = $parent;
            $permission->order = $order;
            $permission->default = $default;

            $permission->save();

        }
    }

    static public function edit($params = array())
    {
        $permission_id = 0;
        $name = '';
        $method = '';
        $parent = 0;
        $order = 0;
        $default = 0;
        $get_parent = '';

        extract($params, EXTR_OVERWRITE);

        $check = Permission::where('method', '=', $method)->count();

        if ($check) {
            if ($get_parent != '') {
                $parents = Permission::where('method', '=', $get_parent)->get();
                $parent = (count($parents) > 0) ? $parents[0]->permission_id : 0;
            }

            $pid = Permission::where('method', '=', $method)->get();
            $permission_id = (count($pid) > 0) ? $pid[0]->permission_id : 0;

            $permission = Permission::find($permission_id);
            $permission->name = $name;
            $permission->method = $method;
            $permission->parent = $parent;
            $permission->order = $order;
            $permission->default = $default;

            $permission->save();

        }
    }

    static public function remove($params = array())
    {
        $permission_id = 0;
        $method = '';

        extract($params, EXTR_OVERWRITE);

        $check = Permission::where('method', '=', $method)->count();

        if ($check) {

            DB::table('permissions')->where('method', '=', $method)->delete();

        } else {
            $check = Permission::where('permission_id', '=', $permission_id)->count();

            if ($check) {
                DB::table('permissions')->where('permission_id', '=', $permission_id)->delete();
            }
        }
    }

    public function tree()
    {
        $permissions = Permission::all();

        $childs = array();

        foreach ($permissions as $item)
            $childs[$item->parent][] = $item;

        foreach ($permissions as $item) if (isset($childs[$item->permission_id]))
            $item->childs = $childs[$item->permission_id];

        $tree = (count($childs)) ? $childs[0] : $childs;

        return $tree;
    }
}