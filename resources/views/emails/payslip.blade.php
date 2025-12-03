<x-mail::message>
    # Halo, {{ $employeeName }}

    Slip gaji Anda untuk periode **{{ $period }}** telah dirilis dan siap dilihat.

    Mohon cek rekening bank Anda.

    ### Informasi Gaji Ringkas
    | Deskripsi | Nilai |
    | :--- | :--- |
    | Gaji Pokok | Rp {{ number_format($payroll->base_salary, 0, ',', '.') }} |
    | Total Potongan | Rp {{ number_format($payroll->cut + $payroll->absence_deduction, 0, ',', '.') }} |
    | Gaji Bersih (Perkiraan) | Rp {{ number_format($payroll->base_salary + $payroll->allowance - $payroll->cut - $payroll->absence_deduction, 0, ',', '.') }} |

    Jika Anda memiliki pertanyaan, silakan hubungi tim HR.

    Terima kasih,
    Teamable
</x-mail::message>
