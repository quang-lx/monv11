<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Mon\Entities\ConfigDisplay;
use Modules\Mon\Repositories\Eloquent\UserRepository;

class UsersExport implements FromView
{
    protected $request;
    protected $data_export = [];
    protected $columns_export;
    public function __construct($request)
    {
        $this->request = $request;
        $this->columns_export = [
            [
                'col_name' => 'username',
                'name' =>  trans('backend::user.label.username'),
            ],
            [
                'col_name' => 'name',
                'name' =>  trans('backend::user.label.name'),
            ],
            [
                'col_name' => 'email',
                'name' =>  trans('backend::user.label.email'),
            ],
            [
                'col_name' => 'phone',
                'name' =>  trans('backend::user.label.phone'),
            ],
            [
                'col_name' => 'sex',
                'name' =>  trans('backend::user.label.sex'),
            ],
            [
                'col_name' => 'birth_day',
                'name' =>  trans('backend::user.label.birth_day'),
            ],
            [
                'col_name' => 'identification',
                'name' =>  trans('backend::user.label.identification'),
            ],
            [
                'col_name' => 'created_at',
                'name' => trans('backend::user.label.created_at'),
            ],
            [
                'col_name' => 'updated_at',
                'name' =>  trans('backend::user.label.updated_at'),
            ],
            [
                'col_name' => 'status',
                'name' =>  trans('backend::user.label.status'),
            ],
            [
                'col_name' => 'created_by',
                'name' =>  trans('backend::user.label.created_by'),
            ],
        ];
    }
    public function view(): View
    {
        $user_repo = new UserRepository(new User);
        $query = $user_repo->queryGetUsers($this->request);

        $query->chunk(100, function ($users) {
            foreach ($users as $user) {
                $this->data_export[] = $user->toArray();
            }
        });
        $config_play = ConfigDisplay::where('table_name', 'user')->orderBy('position','asc')->get();
        if ($config_play) {
            $this->columns_export = $this->formatConfigPlay($config_play);
        }
        return view('exports.user', [
            'users' => $this->data_export,
            'columns' => $this->columns_export
        ]);
    }

    public function formatConfigPlay($config_play) 
    {
        $columns_export = [];
        foreach ($config_play as $column) {

            $columns_export[] = [
                'col_name' => $column->col_name,
                'name' => trans('backend::user.label.'.$column->col_name)
            ];
        }
        return $columns_export;
    }
    
}
