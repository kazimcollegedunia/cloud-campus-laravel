<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllStudent($dataPass = [])
    {
        $date = $dataPass['date'] ?? null;

        $query =  $this->model
            ->leftJoin('attendances as a', function ($join) use ($date) {
                $join->on('a.user_id', '=', 'users.id');
                if ($date) {
                    $join->where('a.date', '=', $date);
                }
            })
            ->join('students as s', 's.user_id', '=', 'users.id')
            ->where('users.role', 'student');

            if(isset($dataPass['class_id']) && $dataPass['class_id'] !== null){
                $query->where('s.class_id', $dataPass['class_id']);
            }
            
            if(isset($dataPass['section']) && $dataPass['section'] !== null){
                $query->where('s.section', $dataPass['section']);
            }
            
            return $query->select($dataPass['select'])
            ->get();
    }
}
