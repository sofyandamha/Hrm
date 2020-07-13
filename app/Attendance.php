<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendancebulks';
    protected $fillable = ['id_employee','in_time','out_time','tanggal'];

    protected $columns = [
        'id_employee' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'in_time' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'out_time' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'tanggal' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'employee_name'=> [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Employee',
            'relation_field' => 'full_name'
        ],
        'employee_department'=> [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Employee',
            'relation_field' => 'id_department'
        ],
        'created_at'=> [
            'searchable' => true,
            'search_relation' => false,
        ],
        'updated_at'=> [
            'searchable' => true,
            'search_relation' => false,
        ]
    ];


    public function Employee()
    {
        return $this->hasOne(Employee::class,'scan_id','id_employee');
    }

    public function getEmployeeNameAttribute()
    {
        if (isset($this->Employee->full_name)) {
            return $this->Employee->full_name;
        } else {
            return 'No Name';
        }
    }

    public function getEmployeeDepartmentAttribute()
    {
        if (isset($this->Employee->id_department)) {
            return $this->Employee->id_department;
        } else {
            return 'No ID Department';
        }
    }
    public function getColumns()
    {
        return $this->columns;
    }
}
