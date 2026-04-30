<?php

namespace App\Modules\Reports\Services;

use App\Modules\Reports\Repositories\ReportRepository;

class ReportService
{
    public function __construct(private ReportRepository $reportRepository) {}

    public function getFinanceReport(array $filters = [])
    {
        return $this->reportRepository->getFinanceSummary($filters);
    }

    public function getAttendanceReport(array $filters = [])
    {
        return $this->reportRepository->getAttendanceReport($filters);
    }

    public function getHafizReport(array $filters = [])
    {
        return $this->reportRepository->getHafizReport($filters);
    }

    public function getDashboardSummary()
    {
        return [
            'finance' => $this->getFinanceReport(),
            'attendance' => $this->getAttendanceReport(),
            'hafiz' => $this->getHafizReport(),
        ];
    }
}
