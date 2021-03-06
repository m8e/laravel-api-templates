<?php

namespace Preferred\Domain\Companies\Repositories;

use Preferred\Domain\Companies\Contracts\CompanyRepository;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Infrastructure\Abstracts\AbstractEloquentRepository;
use Spatie\QueryBuilder\QueryBuilder;

class EloquentCompanyRepository extends AbstractEloquentRepository implements CompanyRepository
{
    private $defaultSort = '-created_at';

    private $defaultSelect = [
        'id',
        'name',
        'is_active',
        'max_users',
        'created_at',
        'updated_at',
    ];

    private $allowedFilters = [
        'is_active',
    ];

    private $allowedSorts = [
        'updated_at',
        'created_at',
    ];

    private $allowedIncludes = [];

    public function findByFilters()
    {
        $perPage = (int)request()->get('limit');
        $perPage = $perPage >= 1 && $perPage <= 100 ? $perPage : 20;

        return QueryBuilder::for(Company::class)
            ->select($this->defaultSelect)
            ->allowedFilters($this->allowedFilters)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->defaultSort($this->defaultSort)
            ->paginate($perPage);
    }
}
