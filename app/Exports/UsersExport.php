<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Modules\Mon\Repositories\Eloquent\UserRepository;

class UsersExport implements FromView
{
    protected $request;
    protected $data_export;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $user_repo = new UserRepository(null);
        $query = $user_repo->queryGetUsers($this->request);

        $query->chunk(100, function ($users) {
            foreach ($users as $user) {
                $this->data_export = array_merge($this->data_export, $user);
            }
        });

        return view('exports.user', [
            'users' => $this->data_export,
            'column' => $this->data_export
        ]);
    }
}
