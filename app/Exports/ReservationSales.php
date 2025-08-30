<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReservationSales implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $status;
    protected $start_date;
    protected $end_date;

    public function __construct($status = null, $start_date = null, $end_date = null)
    {
        $this->status = $status;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        $query = Reservation::with('lot', 'customer', 'approved');

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->start_date && $this->end_date) {
            $query->whereBetween('reserved_at', [$this->start_date, $this->end_date]);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Lot Number',
            'Customer',
            'Downpayment Price',
            'Reserved Date',   // <-- Added Reserved Date
            'Approved Date',
            'Approved By',
            'Status',
        ];
    }

   public function map($reservation): array
    {
        return [
            $reservation->id,
            $reservation->lot->lot_number ?? '-',
            isset($reservation->customer)
                ? $reservation->customer->fname . ' ' . ($reservation->customer->mi ? $reservation->customer->mi . '. ' : '') . $reservation->customer->lname
                : '-',
            $reservation->total_downpayment_price,
            $reservation->reserved_at ? \Carbon\Carbon::parse($reservation->reserved_at)->format('Y-m-d h:i A') : '-', // Reserved Date with time
            $reservation->approved_date ? \Carbon\Carbon::parse($reservation->approved_date)->format('Y-m-d h:i A') : '-', // Approved Date with time
            isset($reservation->approved)
                ? $reservation->approved->fname . ' ' . ($reservation->approved->mi ? $reservation->approved->mi . '. ' : '') . $reservation->approved->lname
                : '-',
            $reservation->status,
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Header style
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => Color::COLOR_WHITE],
                'name' => 'Century Gothic',
                'size' => 14,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1E6E2B'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Alternate row colors and data font
        for ($row = 2; $row <= $highestRow; $row++) {
            $sheet->getStyle("A{$row}:{$highestColumn}{$row}")->applyFromArray([
                'font' => [
                    'name' => 'Century Gothic',
                    'size' => 11,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => $row % 2 == 0 ? 'FFFFFFFF' : 'FFF0F0F0'],
                ],
            ]);
        }

        // Border for all cells
        $sheet->getStyle("A1:{$highestColumn}{$highestRow}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
