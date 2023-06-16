<?php

namespace App\Imports;

use App\Models\Dpt;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class DptImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading
{
    private $desaId;
    private $user;

    public function __construct($desaId, Authenticatable $user)
    {
        $this->desaId = $desaId;
        $this->user = $user;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $dateOfBirth = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_lahir']);
        $formattedDateOfBirth = $dateOfBirth->format('Y-m-d');

        if (!$row['nama']) {
            return;
        };

        return new Dpt([
            "desa_id" =>  $this->desaId,
            "name" => $row['nama'],
            "is_voters" => "1",
            "date_of_birth" => $formattedDateOfBirth,
            "indentity_number" => $row['nik'],
            "phone_number" => $row['no_hp'],
            "gender" => $row['jenis_kelamin'],
            "created_by" => $this->user->id,
            "updated_by" => $this->user->id,
        ]);
    }

    public function uniqueBy()
    {
        return 'indentity_number, phone_number';
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
