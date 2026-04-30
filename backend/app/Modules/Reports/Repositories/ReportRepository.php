<?php

namespace App\Modules\Reports\Repositories;

use App\Models\Payment;
use App\Modules\Attendance\Models\Attendance;
use App\Modules\Hafiz\Models\HafizProgress;
use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function getFinanceSummary(array $filters = [])
    {
        $query = Payment::where('status', 'paid');

        if (isset($filters['start_date'])) {
            $query->whereDate('paid_at', '>=', $filters['start_date']);
        }
        if (isset($filters['end_date'])) {
            $query->whereDate('paid_at', '<=', $filters['end_date']);
        }

        $totalIncome = $query->sum('amount');
        
        $monthlyIncome = Payment::where('status', 'paid')
            ->select(DB::raw('SUM(amount) as amount'), DB::raw("to_char(paid_at, 'YYYY-MM') as month"))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'total_income' => $totalIncome,
            'monthly_income' => $monthlyIncome
        ];
    }

    public function getAttendanceReport(array $filters = [])
    {
        $query = Attendance::with(['student', 'session.classRoom']);

        if (isset($filters['class_id'])) {
            $query->whereHas('session', function($q) use ($filters) {
                $q->where('class_id', $filters['class_id']);
            });
        }

        return $query->select('student_id', DB::raw('count(*) as presence_count'))
            ->groupBy('student_id')
            ->get();
    }

    public function getHafizReport(array $filters = [])
    {
        return HafizProgress::with('student')
            ->select('student_id', DB::raw('count(*) as total_entries'), DB::raw('MAX(juz) as last_juz'))
            ->groupBy('student_id')
            ->orderBy('last_juz', 'DESC')
            ->get();
    }
}
