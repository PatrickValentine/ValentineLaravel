<?php

namespace App\Helpers;

class FedexReportHelper
{
    /**
     * Stream a FedEx-formatted CSV for the given items and field mappings.
     *
     * @param \Illuminate\Support\Collection $items
     * @param \Illuminate\Support\Collection $mappings
     * @param string $fileName
     * @return \Illuminate\Http\StreamedResponse
     */
    public static function streamFedexCsv($items, $mappings, $fileName)
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$fileName}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $mappings->pluck('fedex_field')->toArray();

        $callback = function() use ($items, $mappings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($items as $item) {
                $row = [];

                foreach ($mappings as $map) {
                    if (!empty($map->our_field)) {
                        if ($map->our_field == "updated_at") {
                            $row[] = $item->{$map->our_field} ? $item->{$map->our_field}->format('Ymd') : "";
                        } else {
                            $value = $item->{$map->our_field} ?? '';
                            // Force Excel to treat as text for leading-zero values
                            if (preg_match('/^0\d+$/', $value)) {
                                $row[] = "\t" . $value;
                            } else {
                                $row[] = $value;
                            }
                        }
                    } elseif (!empty($map->common_value)) {
                        $row[] = $map->common_value;
                    } else {
                        $row[] = '';
                    }
                }

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}