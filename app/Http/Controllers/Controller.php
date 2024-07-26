<?php

namespace App\Http\Controllers;

use App\Jobs\UpdateField;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function testQueueByDB()
    {
        #新增数据
//        $model       = new User;
//        $model->name = 'First Name'.mt_rand(10,99);
//        $model->email = mt_rand(10000000,99999999).'@qq.com';
//        $model->password = 'xxxx123';
//        $model->save();

        #调度队列任务修改数据
        $userId = 1;
        $data   = ['name' => 'New Name'.mt_rand(10,99)];
        UpdateField::dispatch($userId, $data);
    }

    public function test()
    {
        dd(123);
    }
}
