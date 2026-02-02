<?php

namespace Database\Seeders;

use App\Models\SchoolOutgoingFedexFieldMapping;
use App\Models\SchoolReturnFedexFieldMapping;
use Illuminate\Database\Seeder;

class FedexReportsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSchoolOutgoing();
        $this->seedSchoolReturn();
    }

    private function seedSchoolOutgoing(): void
    {
        $rows = SchoolOutgoingFedexFieldMapping::all();
        $i = 1;
        foreach ($rows->sortBy('id') as $row) {
            $row->order = $i++;
            if (strtolower($row->fedex_field) === 'servicetype' || $row->fedex_field === 'service_Type') {
                $row->fedex_field = 'service_type';
            }
            $row->save();
        }
    }

    private function seedSchoolReturn(): void
    {
        $rows = SchoolReturnFedexFieldMapping::all();
        if ($rows->isEmpty()) return;

        // Словник для пошуку об'єктів за назвою fedex_field
        $map = $rows->keyBy(fn($item) => strtolower($item->fedex_field));

        $getField = function($name) use ($map) {
            return $map->get(strtolower($name));
        };

        $newOrder = collect();

        // 1. Колонку A залишаємо на місці
        $newOrder->push($getField('reference')); // A

        // 2. Переносимо блок T-AA на місце B.
        // Починаємо з U (SenderCompany), як ви і зауважили.
        $blockFields = [
            'SenderCompany',       // U
            'senderContactNumber', // V
            'senderEmail',         // W
            'senderLine1',         // X
            'senderCity',          // Y
            'senderState',         // Z
            'senderPostCode',      // AA
            'SenderContactName',   // T (замикає блок перенесених колонок)
        ];

        foreach ($blockFields as $name) {
            if ($f = $getField($name)) $newOrder->push($f);
        }

        // 3. Swap C and B (тепер вони йдуть ПІСЛЯ блоку відправника)
        // У файлі (6).csv: C = recipientCity, B = recipientLine2
        $newOrder->push($getField('recipientCity'));  // Колишня C
        $newOrder->push($getField('recipientLine2')); // Колишня B

        // 4. Додаємо всі інші поля, які не були використані вище
        $usedIds = $newOrder->filter()->pluck('id')->toArray();

        // Поля, що залишилися (D-S та інші)
        $remainingFields = [
            'recipientState', 'recipientPostcode', 'recipientContactNumber',
            'recipientEmail', 'invoiceNumber', 'packageWeight', 'length',
            'width', 'height', 'department', 'poNumber', 'recipientLine1',
            'numberOfPackages', 'recipientCountry', 'packageType', 'serviceType',
            'weightUnits', 'RecipientEmailLanguage', 'RecipientExceptionnotification',
            'RecipientDeliverynotification', 'SenderExceptionnotification',
            'senderCountry', 'currencyType', 'Last Updated', 'RecipientContactName'
        ];

        foreach ($remainingFields as $name) {
            if ($f = $getField($name)) {
                if (!in_array($f->id, $usedIds)) {
                    $newOrder->push($f);
                    $usedIds[] = $f->id;
                }
            }
        }

        // На випадок, якщо в БД є поля, яких немає в списку вище
        $absoluteRemaining = $rows->whereNotIn('id', $usedIds);
        $finalList = $newOrder->filter()->concat($absoluteRemaining);

        // 5. Записуємо новий порядок у базу
        $i = 1;
        foreach ($finalList as $row) {
            $row->order = $i++;
            // Уніфікуємо назву service_type
            if (strtolower($row->fedex_field) === 'servicetype' || $row->fedex_field === 'service_type') {
                $row->fedex_field = 'service_type';
            }
            $row->save();
        }
    }
}