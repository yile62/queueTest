<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UpdateField implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $data;


    public function __construct(int $userId, array $data)
    {
        $this->userId = $userId;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        # 数据库字段更新
//        $user = User::find($this->userId);
//        if ($user) {
//            $user->update($this->data);
//        }
//

        $lockKey = 'update_user_data_' . $this->userId;
        $lock = Cache::lock($lockKey, 100); // 100秒钟的锁

        if ($lock->get()) {

            Log::channel('daily')->info('正在执行更改');
            try {
                $user = User::find($this->userId);
                if ($user) {
                    $user->update($this->data);
                    Log::channel('daily')->info('更改完成');
                }
            } finally {
                $lock->release();
                Log::channel('daily')->info('锁已释放');
            }
        }else{
            Log::channel('daily')->info('被锁住');
        }
    }
}
