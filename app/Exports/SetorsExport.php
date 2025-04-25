<?php

namespace App\Exports;

use App\Models\Setor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Database\Eloquent\Builder;

class SetorsExport implements FromQuery, WithHeadings
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
        $query = Setor::query()->select('sigla', 'descricao')->orderBy('sigla', 'asc');

        // Verifica se o modelo Setor tem o escopo filter ou aplica filtro manualmente
        if ($this->filter) {
            if (method_exists(Setor::class, 'scopeFilter')) {
                return $query->filter($this->filter);
            } else {
                return $query->where('sigla', 'like', "%{$this->filter}%")
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
        return ["Sigla", "Descrição"];
    }
}
