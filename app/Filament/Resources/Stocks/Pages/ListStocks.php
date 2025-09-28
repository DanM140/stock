<?php

namespace App\Filament\Resources\Stocks\Pages;

use App\Filament\Resources\Stocks\StockResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use App\Models\Stock;
use Filament\Actions;
class ListStocks extends ListRecords
{
    protected static string $resource = StockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Actions\Action::make('uploadCsv')
                ->label('Upload CSV')
                ->icon('heroicon-o-arrow-up-tray')
                ->modalHeading('Upload Stock CSV')
                ->modalButton('Import')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('CSV File')
                        ->acceptedFileTypes(['text/csv', 'text/plain'])
                        ->required()
                        ->storeFiles(false), // don’t save in storage, handle manually
                ])
              ->action(function (array $data): void {
    $file = $data['file'];
    $path = $file->getRealPath();
    $rows = array_map('str_getcsv', file($path));

    // Remove header row
    if (isset($rows[0]) && (
        str_contains(strtolower(implode(',', $rows[0])), 'company') ||
        str_contains(strtolower(implode(',', $rows[0])), 'date')
    )) {
        array_shift($rows);
    }

    $inserts = [];

    foreach ($rows as $row) {
        if (count($row) < 3 || !strtotime($row[2])) {
            continue;
        }

        $inserts[] = [
            'company'    => $row[0],
            'price'      => $row[1],
            'date'       => \Carbon\Carbon::parse($row[2])->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Insert in chunks to avoid memory issues
    foreach (array_chunk($inserts, 1000) as $chunk) {
        \DB::table('stocks')->insert($chunk);
    }

    \Filament\Notifications\Notification::make()
        ->title('CSV Imported')
        ->success()
        ->send();
}),
        ];
    }
}
