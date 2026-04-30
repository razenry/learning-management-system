'use client';

import { useRealtime } from './useRealtime';

export function useRealtimeAttendance() {
  useRealtime(
    'attendance',
    'AttendanceUpdated',
    [['attendance'], ['dashboard-summary']],
    'Ada pembaruan absensi siswa!'
  );
}

export function useRealtimeHafiz() {
  useRealtime(
    'hafiz',
    'HafizUpdated',
    [['hafiz-progress'], ['dashboard-summary']],
    'Progres hafalan siswa diperbarui.'
  );
}

export function useRealtimeReports() {
  useRealtime(
    'reports',
    'ReportUpdated',
    [['finance-report'], ['dashboard-summary']],
    'Laporan keuangan telah diperbarui.'
  );
}
