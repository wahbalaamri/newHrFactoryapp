<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Clients extends Model
{
    use HasFactory, SoftDeletes;
    // table name
    protected $table = 'clients';
    //fields
    protected $fillable = [
        'name',
        'name_ar',
        'country',
        'industry',
        'client_size',
        'partner_id',
        'logo_path',
        'phone',
        'webiste',
        'use_sections',
    ];

    //relationship focal point
    public function focalPoint()
    {
        return $this->hasMany(FocalPoints::class, 'client_id', 'id');
    }
    //relationship sectors
    public function sectors()
    {
        return $this->hasMany(Sectors::class, 'client_id', 'id');
    }
    //relationship get all departments
    public function departments()
    {
        //return all departments of this client
        $departments = [];
        foreach ($this->sectors as $sector) {
            foreach ($sector->companies as $company) {
                foreach ($company->departments as $department) {
                    $departments[] = $department;
                }

            }
        }
        return $departments;
    }
    //relationship with surveys
    public function surveys()
    {
        return $this->hasMany(Surveys::class, 'client_id', 'id');
    }
    //hasMany Employees
    public function employeesData()
    {
        return $this->hasMany(Employees::class, 'client_id');
    }
    //hasMany subscriptions
    public function subscriptions()
    {
        return $this->hasMany(ClientSubscriptions::class, 'client_id');
    }
}
