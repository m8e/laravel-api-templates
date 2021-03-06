<?php

namespace App\Repositories;

use App\Contracts\ProfileRepository;
use App\Models\Profile;
use Ramsey\Uuid\Uuid;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentProfileRepository extends AbstractEloquentRepository implements ProfileRepository
{
    private $defaultSort = '-created_at';

    private $defaultSelect = [
        'name',
        'google2fa_enable',
        'locale',
        'created_at',
        'updated_at',
    ];

    private $allowedFilters = [
        'google2fa_enable',
        'locale',
    ];

    private $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    public function findByFilters()
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        return QueryBuilder::for(Profile::class)
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }

    public function setNewEmailTokenConfirmation($userId)
    {
        $this->withoutGlobalScopes()
            ->findOneByCriteria(['user_id' => $userId])
            ->update([
                'email_token_confirmation' => Uuid::uuid4(),
            ]);
    }
}
