<?php

namespace App\Exports;

use App\Models\Objeto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class ObjetosExport implements FromQuery, WithHeadings
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
    * php artisan make:export PermissionsExport --model=Objeto
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
        $query = Objeto::query()->select('sigma', 'descricao')->orderBy('sigma', 'asc');

        // Verifica se o modelo Objeto tem o escopo filter ou aplica filtro manualmente
        if ($this->filter) {
            if (method_exists(Objeto::class, 'scopeFilter')) {
                return $query->filter($this->filter);
            } else {
                return $query->where('sigma', 'like', "%{$this->filter}%")
                            ->orWhere('descricao', 'like', "%{$this->filter}%");
            }
        }

        return $query;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ["Sigma", "Descrição"];
    }
}
