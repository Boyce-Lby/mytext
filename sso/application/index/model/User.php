<?php 
namespace app\index\model;

use think\Model;

class User extends Model
{
	protected $autoWriteTimestamp = true;
    protected $insert             = [
        'status' => 1,
    ];
    protected $type       = [
        // 设置birthday为时间戳类型（整型）
        'birthday' => 'timestamp',
    ];
    protected $field = [
        'id'          => 'int',
        'create_time' => 'int',
        'update_time' => 'int',
        'nickname', 'password', 'email', 'birthday', 
    ];
}