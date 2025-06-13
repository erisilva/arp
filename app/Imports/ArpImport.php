<?php
namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ArpImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            # the first row is the header, I need to read the cells from I (8) until the cell is empty and insert into a vector all rows values, this vector is gonna record the setors from import
            if (empty($row[0])) {
                continue; // Skip empty rows
            }
            static $firstRowProcessed = false;
            if (!$firstRowProcessed) {
                $setor = [];
                for ($i = 8; $i < count($row); $i++) {
                    if (empty($row[$i])) {
                        break; // Stop when an empty cell is found
                    }
                    $setor[] = $row[$i];
                }
                $firstRowProcessed = true;
            }


            // Here you can     process the $setor array as needed, e.g., save it to the database or perform other operations
        }

        dd($setor); // Debugging: print the setor array
    }
}

