<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Schema;

class CustomersExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $customers;
    protected $isSelectedExport;
    
    public function __construct($customers, $isSelectedExport = false)
    {
        $this->customers = $customers;
        $this->isSelectedExport = $isSelectedExport;
    }
    
    public function collection()
    {
        return $this->customers;
    }
    
    public function headings(): array
    {
        $headings = [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Orders Count',
            'Total Spent',
            'Last Order Date',
            'Joined Date',
        ];

        // Add status if column exists
        if (Schema::hasColumn('users', 'status')) {
            array_splice($headings, 4, 0, ['Status']);
        }

        return $headings;
    }
    
    public function map($customer): array
    {
        $lastOrder = $customer->orders()->latest()->first();
        $totalSpent = $customer->orders()->where('status', 'completed')->sum('total');
        
        $data = [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone ?? 'N/A',
            $customer->orders_count ?? 0,
            $totalSpent ? 'Rp ' . number_format($totalSpent, 0, ',', '.') : 'Rp 0',
            $lastOrder ? $lastOrder->created_at->format('d-m-Y H:i') : 'Never',
            $customer->created_at ? $customer->created_at->format('d-m-Y H:i') : 'N/A',
        ];

        // Add status if column exists
        if (Schema::hasColumn('users', 'status')) {
            array_splice($data, 4, 0, [$customer->status ?? 'active']);
        }

        return $data;
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header
            1 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFF']], 
                  'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => '4CAF50']]],
            
            // Style untuk seluruh data
            'A1:H1' => ['font' => ['bold' => true]],
        ];
    }
}