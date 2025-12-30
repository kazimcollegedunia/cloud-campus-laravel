<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;
use App\Models\Tenant;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getAllStudent($dataPass = [])
    {
        $date = $dataPass['from_date'] ?? null;

        $query =  $this->model
            ->leftJoin('attendances as a', function ($join) use ($date) {
                $join->on('a.user_id', '=', 'users.id');
                if ($date) {
                    $join->where('a.date', '=', $date);
                }
            })
            ->join('students as s', 's.user_id', '=', 'users.id')
            ->where('users.role', 'student')
            ->where('users.tenant_id', $dataPass['tenant_id']);

            if(isset($dataPass['class_id']) && $dataPass['class_id'] !== null){
                $query->where('s.class_id', $dataPass['class_id']);
            }
            
            if(isset($dataPass['section']) && $dataPass['section'] !== null){
                $query->where('s.section', $dataPass['section']);
            }
            
             return  $query->select($dataPass['select'])
            ->get();

            // dd($query->toRawSql());
    }

    public function createUser(array $data){
        try{
            return  User::create([
                'tenant_id' => $data['tenant_id'],
                'name'      => $data['name'],
                'email'     => $data['email'] ?? null,
                'phone'     => $data['phone'] ?? 99999999999,
                'password'  => isset($data['password']) ? $data['password'] : bcrypt('password'),
                'role'      => isset($data['role']) ? $data['role'] : 'student',
            ]);
        
        }catch(Exception $e){
             writeLog(
                action: "DB Action fail",
                description: "User freation fail",
                request: $data,
                response: [],
                status: "Fail"
            );
        }
        
    }

    public function tenantDetails($dataPass){
        $dataArr =   Tenant::where('id',$dataPass['tenant_id'])->select('id','school_name','subdomain')->first();
        return $dataArr;
        
    }
}


