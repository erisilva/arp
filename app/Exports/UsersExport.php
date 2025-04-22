<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class UsersExport implements FromQuery, WithHeadings
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
    * php artisan make:export UsersExport --model=User
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
        $query = User::query()->select('name', 'email')->orderBy('name', 'asc');

        // Verifica se o modelo User tem o escopo filter ou aplica filtro manualmente
        if ($this->filter) {
            if (method_exists(User::class, 'scopeFilter')) {
                return $query->filter($this->filter);
            } else {
                return $query->where('name', 'like', "%{$this->filter}%")
                            ->orWhere('email', 'like', "%{$this->filter}%");
            }
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ["Nome", "E-mail"];
    }
}
