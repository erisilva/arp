<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class RolesExport implements FromQuery, WithHeadings
{
    use Exportable;

    /**
     * @var mixed
     */
    protected $filter;

    /**
    * @param mixed $filter
    * @return void
    *
    * php artisan make:export RolesExport --model=Role
    *
    * https://laravel-excel.com/
    */
    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * @return Builder
     */
    public function query()
    {
        $query = Role::query()->select('name', 'description')->orderBy('id', 'asc');

        // Verifica se o modelo Role tem o escopo filter ou aplica filtro manualmente
        if ($this->filter) {
            if (method_exists(Role::class, 'scopeFilter')) {
                return $query->filter($this->filter);
            } else {
                return $query->where('name', 'like', "%{$this->filter}%")
                            ->orWhere('description', 'like', "%{$this->filter}%");
            }
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ["Nome", "Descrição"];
    }
}
