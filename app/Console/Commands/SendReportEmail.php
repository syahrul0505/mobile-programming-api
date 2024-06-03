<?php

namespace App\Console\Commands;

use App\Models\Absen;
use App\Models\Order;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SendReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send email report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $filename = 'report-' . now()->format('Y-m-d') . '.xlsx';

        $data = Order::all();
        Excel::store(new class($data) implements FromCollection, WithHeadings, WithStyles {
            private $data;

            public function __construct($data)
            {
                $this->data = $data;
            }

            public function collection()
            {
                // Select only the desired columns and add an incrementing column
                $filteredData = $this->data->map(function ($item, $index) {
                    $richText = new \PhpOffice\PhpSpreadsheet\RichText\RichText();

                    $item->orderDetail->each(function ($order, $menuIndex) use ($richText, $item) {
                        $text = ($menuIndex + 1) . '. ' . $order->restaurant->name . ' | QTY: ' . $order->qty . '| Harga: ' . $order->price_discount;
                        $richText->createTextRun($text);

                        // Add a break for all runs except the last one
                        if ($menuIndex < count($item->orderDetail) - 1) {
                            $richText->createText("\n");
                        }
                    });

                    return [
                        $index + 1, // Incrementing column
                        $item->user->name,
                        $item->created_at,
                        $richText, // Modified to include menu names from many-to-many relationship
                        $item->total_price,
                        $item->modal,
                        $item->metode_pembayaran,
                    ];
                });
                return $filteredData;
            }

            public function headings(): array
            {
                // Define column headers
                return [
                    'No',
                    'Nama Karyawan',
                    'Tanggal',
                    'Menu',
                    'Total Harga',
                    'Modal',
                    'Metode Pembayaran',
                ];
            }

            public function styles(Worksheet $sheet)
            {
                // Merge and center the title row
                $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getFont()->setBold(true);

                // Set the title text
                $sheet->setCellValue('A1', 'DAILY REPORT');

                // Set the column headers in row 2
                $sheet->fromArray([$this->headings()], null, 'A2');

                // Set the data starting from row A3
                $sheet->fromArray($this->collection()->toArray(), null, 'A3');

                // Apply styles to the title row
                $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Apply styles to the column headers
                $sheet->getStyle('A2:' . $sheet->getHighestColumn() . '2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Apply styles to the data rows
                $sheet->getStyle('A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ]);

                // Auto-size all columns
                foreach (range('A', $sheet->getHighestColumn()) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Set left alignment for cells in column D starting from row 3
                $sheet->getStyle('D3:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                // Set the height to auto-fit content for rows 3 and onwards
                foreach (range(3, $sheet->getHighestRow()) as $row) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }
            }
        }, $filename, 'xlsx');

        $this->sendEmail($filename);
    }

    private function sendEmail($filename)
    {
        $toEmail = 'sahriramadan000@gmail.com';
        $subject = 'Daily Report';
        $attachmentPath = storage_path("app/reports/$filename");

        // Send email with attachment
        $this->mailReport($toEmail, $subject, $attachmentPath);
    }

    private function mailReport($toEmail, $subject, $attachmentPath)
    {
        // Use the Mail facade to send email
        Mail::send([], [], function ($message) use ($toEmail, $subject, $attachmentPath) {
            $message->to($toEmail)
                    ->subject($subject)
                    ->attach($attachmentPath);
        });
    }
}
