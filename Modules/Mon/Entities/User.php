<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Spatie\Permission\Traits\HasRoles;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 * @property  $sex
 * @property  $expired_at
 * @property  $active_at
 * @package Modules\Mon\Entities
 */

class User extends Authenticatable implements MustVerifyEmail, JWTSubject {
	use Notifiable, HasRoles, SoftDeletes;
	const TYPE_ADMIN = 1;
	const TYPE_USER = 2;

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;

	const MALE = 'nam';
	const FEMALE = 'nam';

    protected   $guard_name = ['api', 'web'];
	protected $table = 'users';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password', 'email_verified_at', 'activated', 'last_login', 'type', 'username','status', 'phone',
        'birth_day','department_id','sex','active_at', 'expired_at', 'identification', 'need_change_password', 'created_by'
	];
    protected $appends = ['sex_text', 'status_text'];

    protected $casts = [
        'active_at' => 'datetime:Y-m-d',
        'expired_at' => 'datetime:Y-m-d',
        'birth_day' => 'datetime:Y-m-d',
    ];
	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

    protected function sexText(): Attribute
    {
        return new Attribute(
            get: fn () => $this->sex == self::MALE? 'Nam': 'Nữ'
        );
    }
    protected function statusText(): Attribute
    {
        return new Attribute(
            get: fn () => $this->expired_at && Carbon::createFromFormat('Y-m-d H:i:s', $this->expired_at)->gt(Carbon::now()) ? 'Hoạt động': 'Không hoạt động'
        );
    }

	public function tokens() {
		return $this->hasMany(UserToken::class, 'user_id', 'id');
	}

	/**
	 * Lấy thông tin profile
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function profile() {
		return $this->hasOne(Profile::class, 'user_id', 'id');
	}

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department() {
        return $this->belongsTo(Department::class, 'department_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

	public function getFirstToken() {
		return $this->tokens()->first();
	}

	public function getFirstTokenKey() {
		$userToken = $this->tokens()->first();

		if ($userToken === null) {
			return '';
		}

		return $userToken->access_token;
	}

	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	public function getJWTCustomClaims()
	{
		return [
			'user_id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
		];
	}
}
