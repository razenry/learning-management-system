'use client';

import { DashboardLayout } from '@/components/dashboard-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useRealtimeAttendance } from '@/hooks/realtime';
import { useQuery } from '@tanstack/react-query';
import apiClient from '@/lib/api-client';
import { Badge } from '@/components/ui/badge';
import { QrCode, UserCheck } from 'lucide-react';

export default function AttendancePage() {
  useRealtimeAttendance();

  const { data: attendances, isLoading } = useQuery({
    queryKey: ['attendance'],
    queryFn: async () => {
      const res = await apiClient.get('/admin/reports/attendance');
      return res.data.data;
    },
    refetchInterval: 15000,
  });

  return (
    <DashboardLayout>
      <div className="space-y-8">
        <div className="flex items-center justify-between">
          <h3 className="text-2xl font-bold">Realtime Attendance</h3>
          <div className="flex gap-4">
            <Badge className="bg-blue-500/10 text-blue-400 border-blue-500/20 px-3 py-1">
              Active Session: 2
            </Badge>
          </div>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          {/* QR Generator Mock */}
          <Card className="bg-slate-900/50 border-slate-800">
            <CardHeader>
              <CardTitle className="text-lg flex items-center gap-2">
                <QrCode size={20} className="text-blue-400" /> Session QR
              </CardTitle>
            </CardHeader>
            <CardContent className="flex flex-col items-center justify-center py-10">
              <div className="w-48 h-48 bg-white p-4 rounded-xl shadow-lg shadow-blue-500/10 mb-6">
                <div className="w-full h-full bg-slate-200 animate-pulse flex items-center justify-center text-slate-400 text-xs text-center px-4">
                  QR Code will be generated here
                </div>
              </div>
              <p className="text-sm text-slate-400 text-center">
                Scan this code with the student app to record attendance.
              </p>
            </CardContent>
          </Card>

          {/* Attendance List */}
          <Card className="lg:col-span-2 bg-slate-900/50 border-slate-800">
            <CardHeader>
              <CardTitle className="text-lg flex items-center gap-2">
                <UserCheck size={20} className="text-emerald-400" /> Attendance Stream
              </CardTitle>
            </CardHeader>
            <CardContent>
              <Table>
                <TableHeader className="border-slate-800">
                  <TableRow className="hover:bg-transparent border-slate-800">
                    <TableHead className="text-slate-400">Student</TableHead>
                    <TableHead className="text-slate-400">Class</TableHead>
                    <TableHead className="text-slate-400">Status</TableHead>
                    <TableHead className="text-slate-400 text-right">Count</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {isLoading ? (
                    [1, 2, 3, 4].map(i => (
                      <TableRow key={i}>
                        <TableCell><div className="w-32 h-4 bg-slate-800 rounded animate-pulse" /></TableCell>
                        <TableCell><div className="w-24 h-4 bg-slate-800 rounded animate-pulse" /></TableCell>
                        <TableCell><div className="w-16 h-4 bg-slate-800 rounded animate-pulse" /></TableCell>
                        <TableCell><div className="w-8 h-4 bg-slate-800 rounded ml-auto animate-pulse" /></TableCell>
                      </TableRow>
                    ))
                  ) : (
                    attendances.map((item: any) => (
                      <TableRow key={item.student_id} className="border-slate-800/50 hover:bg-slate-800/30 transition-colors">
                        <TableCell className="font-medium">{item.student?.name || `Student #${item.student_id}`}</TableCell>
                        <TableCell className="text-slate-400">Kelas 12 - SNBT</TableCell>
                        <TableCell>
                          <Badge variant="outline" className="bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                            Present
                          </Badge>
                        </TableCell>
                        <TableCell className="text-right font-mono">{item.presence_count}</TableCell>
                      </TableRow>
                    ))
                  )}
                </TableBody>
              </Table>
            </CardContent>
          </Card>
        </div>
      </div>
    </DashboardLayout>
  );
}
