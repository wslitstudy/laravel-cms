<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Requests\Admin\ManageRequest;
use App\Lib\Entity\ManageGroup;
use App\Lib\Entity\ManageUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ManageController extends Controller
{
    public $manage;

    /**
     * @power 权限管理|管理员管理
     * @rank 1
     */
    public function index()
    {
        return $this->render('admin.manage.index', [
            'list' => ManageUser::with('roles')->get()
        ]);
    }

    /**
     * @power 权限管理|管理员管理@添加
     */
    public function create()
    {
        return $this->render('admin.manage.create', [
            'roles' => ManageGroup::all()
        ]);
    }

    /**
     * @power 权限管理|管理员管理@添加
     */
    public function store(ManageRequest $request)
    {
        $service = new \App\Lib\Model\Rbac\Users\Service();

        $groupIds = $request->input('group_id');

        DB::beginTransaction();
        try {
            $entity = new \App\Lib\Entity\ManageUser();
            $entity->name = $request->input('manage_name');
            $entity->password_salt = $service->getPasswordSalt();
            $entity->password = $service->getPassword($request->input('password'), $entity->getPasswordSalt());

            if (!$entity->save()) {
                throw new \Exception('保存失败');
            }

            foreach ($groupIds as $groupId) {
                $result = \App\Lib\Entity\ManageUserGroup::addInfo($entity->getId(), $groupId);
                if (!$result) {
                    throw new \Exception('保存失败');
                }
            }

            DB::commit();

            return response(['code' => 0, 'message' => '添加成功', 'url' => url('/admin/manage')]);
        } catch (\Exception $e) {
            DB::rollBack();

            throw new AdminException($e->getMessage());
        }
    }


    /**
     * @power 权限管理|管理员管理@编辑
     */
    public function edit($id)
    {
        try {
            $this->checkInfo($id);
        } catch (\Exception $exception) {
            throw new AdminException($exception->getMessage());
        }


        return $this->render('admin.manage.edit', [
            'roles' => ManageGroup::all(),
            'groupIds' => \App\Lib\Entity\ManageUserGroup::getGroupsByUserId($id),
            'info' => $this->manage
        ]);
    }

    /**
     * @power 权限管理|管理员管理@编辑
     */
    public function update(ManageRequest $request, $id)
    {
        try {
            $this->checkInfo($id);
        } catch (\Exception $exception) {
            throw new AdminException($exception->getMessage());
        }

        $service = new \App\Lib\Model\Rbac\Users\Service();

        $groupIds = $request->input('group_id');

        DB::beginTransaction();
        try {
            $this->manage->name = $request->input('manage_name');
            if ($password = $request->input('password')) {
                $this->manage->password = $service->getPassword($password, $this->manage->getPasswordSalt());
            }

            if ($this->manage->save() === false) {
                throw new \Exception('保存失败');
            }

            foreach ($groupIds as $groupId) {
                $result = \App\Lib\Entity\ManageUserGroup::addInfo($this->manage->getId(), $groupId);
                if (!$result) {
                    throw new \Exception('保存失败');
                }
            }

            DB::commit();

            return response(['message' => '编辑成功', 'code' => 0, 'url' => url('/admin/manage')]);
        } catch (\Exception $e) {
            DB::rollBack();

            throw new AdminException($e->getMessage());
        }
    }

    /**
     * @power 权限管理|管理员管理@禁用
     */
    public function destroy($id)
    {
        try {
            $this->checkInfo($id);
        } catch (\Exception $exception) {
            throw new AdminException($exception->getMessage());
        }

        $this->manage->forbidden_time = time();

        if (!$this->manage->save()) {
            throw new AdminException('禁用失败');
        }

        return response(['message' => '禁用成功', 'code' => 0]);

    }

    /**
     * @power 权限管理|管理员管理@解禁
     * @method DELETE
     */
    public function disabled($id)
    {
        try {
            $this->checkInfo($id);
        } catch (\Exception $exception) {
            throw new AdminException($exception->getMessage());
        }

        $this->manage->forbidden_time = 0;

        if (!$this->manage->save()) {
            throw new AdminException('解禁失败');
        }

        return response(['message' => '解禁成功', 'code' => 0]);
    }

    private function checkInfo($id)
    {
        $entity = \App\Lib\Entity\ManageUser::find($id);
        if (!$entity) {
            throw new \Exception('对象不存在');
        }
        if ($entity->isDefault()) {
            throw new \Exception('默认用户不能编辑');
        }

        $this->manage = $entity;
    }
}
