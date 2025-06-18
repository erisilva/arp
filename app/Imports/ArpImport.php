<?php
namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ArpImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {
            // Skip empty rows
            if ($row->filter(function($cell) { return !empty($cell); })->isEmpty()) {
                continue; // Skip rows where all cells are empty
            }

            if (strtolower($row->first()) === 'arp') {
                $setores = [];
                for ($i = 8; $i < count($row); $i++) {
                    if (empty($row[$i])) {
                        break; // Stop when an empty cell is found
                    }
                    $setores[] = $row[$i];
                }
            } else {
                // 1 - Verifica se o campo arp já foi cadastrado no sistema
                $arp = \App\Models\Arp::where('arp', $row[0])->first();

                // 2 - Se não existir, cadastra a nova ARP
                if (!$arp) {
                    $arp = \App\Models\Arp::create([
                        'arp' => $row[0],
                        'pac' => $row[1],
                        'pe' => $row[2],
                        'vigenciaInicio' => $this->parseExcelDate($row[3]),
                        'vigenciaFim' => $this->parseExcelDate($row[4]),
                    ]);
                }

                // 3 - Verifica/cadastra objeto pelo código sigma (coluna F) e descrição (coluna G)
                $objeto = \App\Models\Objeto::where('sigma', $row[5])->first();
                if ($objeto) {
                    if ($objeto->descricao !== $row[6]) {
                        $objeto->descricao = $row[6];
                        $objeto->save();
                    }
                } else {
                    $objeto = \App\Models\Objeto::create([
                        'sigma' => $row[5],
                        'descricao' => $row[6],
                    ]);
                }

                // 4 - Verifica/cadastra item na ARP
                $item = \App\Models\Item::where('arp_id', $arp->id)
                    ->where('objeto_id', $objeto->id)
                    ->first();

                $valor = number_format(floatval(str_replace(',', '.', $row[7])), 2, '.', '');

                if ($item) {
                    if ($item->valor != $valor) {
                        $item->valor = $valor;
                        $item->save();
                    }
                } else {
                    $item = \App\Models\Item::create([
                        'arp_id' => $arp->id,
                        'objeto_id' => $objeto->id,
                        'valor' => $valor,
                    ]);
                }

                // 5 - O item já foi tratado acima, $item contém o registro atualizado/criado

                // 6 - Loop pelos setores (a partir da coluna I)
                foreach ($setores as $idx => $siglaSetor) {
                    $colIndex = 8 + $idx;
                    $valorCota = $row[$colIndex] ?? null;
                    if ($valorCota === null || $valorCota === '') {
                        continue;
                    }

                    // Busca setor pelo campo texto (sigla)
                    $setor = \App\Models\Setor::where('sigla', $siglaSetor)->first();
                    if (!$setor) {
                        // Se não existir, pode criar ou pular, dependendo da regra de negócio
                        continue;
                    }

                    // 7 - Verifica/cadastra cota
                    $cota = \App\Models\Cota::where('item_id', $item->id)
                        ->where('setor_id', $setor->id)
                        ->first();

                    if ($cota) {
                        $cota->quantidade = $valorCota;
                        $cota->save();
                    } else {
                        \App\Models\Cota::create([
                            'item_id' => $item->id,
                            'setor_id' => $setor->id,
                            'quantidade' => $valorCota,
                            'empenho' => 0,
                        ]);
                    }

                }
            }
        }
    }

    /**
     * Parse Excel date value to Y-m-d format.
     */
    private function parseExcelDate($value)
    {
        if (empty($value)) {
            return null;
        }

        // If it's already a Carbon or DateTime object
        if ($value instanceof \Carbon\Carbon || $value instanceof \DateTime) {
            return $value->format('Y-m-d');
        }

        // If it's a numeric value (Excel serial date)
        if (is_numeric($value)) {
            try {
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // If it's a string in d/m/Y format
        if (\Carbon\Carbon::hasFormat($value, 'd/m/Y')) {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }

        // Try to parse as Y-m-d
        if (\Carbon\Carbon::hasFormat($value, 'Y-m-d')) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
        }

        return null;
    }
}

