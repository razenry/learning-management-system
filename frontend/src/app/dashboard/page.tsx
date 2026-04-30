'use client';

import { DashboardLayout } from '@/components/dashboard-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useRealtimeReports, useRealtimeAttendance, useRealtimeHafiz } from '@/hooks/realtime';
import { useQuery } from '@tanstack/react-query';
import apiClient from '@/lib/api-client';
import { Skeleton } from '@/components/ui/skeleton';
import { Badge } from '@/components/ui/badge';
import { TrendingUp, Users, BookOpen, Heart } from 'lucide-react';

export default function DashboardPage() {
  // Activate Realtime Hooks
  useRealtimeReports();
  useRealtimeAttendance();
  useRealtimeHafiz();

  const { data: summary, isLoading } = useQuery({
    queryKey: ['dashboard-summary'],
    queryFn: async () => {
      const res = await apiClient.get('/admin/reports/dashboard');
      return res.data.data;
    },
    refetchInterval: 10000, // Fallback polling 10s
  });

  if (isLoading) {
    return (
      <DashboardLayout>
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {[1, 2, 3, 4].map((i) => (
            <Skeleton key={i} className="h-32 bg-slate-800 rounded-xl" />
          ))}
        </div>
      </DashboardLayout>
    );
  }

  return (
    <DashboardLayout>
      <div className="space-y-8 animate-in fade-in duration-500">
        <h3 className="text-2xl font-bold">LMS Overview</h3>
        
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <StatCard 
            title="Total Revenue" 
            value={`Rp ${summary.finance.total_income.toLocaleString()}`} 
            icon={<TrendingUp className="text-emerald-400" />} 
            trend="+12% from last month"
          />
          <StatCard 
            title="Active Students" 
            value={summary.attendance.length} 
            icon={<Users className="text-blue-400" />} 
            trend="Live Update"
          />
          <StatCard 
            title="Classes Today" 
            value="8" 
            icon={<BookOpen className="text-orange-400" />} 
            trend="Upcoming: 3"
          />
          <StatCard 
            title="Hafiz Progress" 
            value={`${summary.hafiz.length} Students`} 
            icon={<Heart className="text-rose-400" />} 
            trend="New progress today"
          />
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <Card className="bg-slate-900/50 border-slate-800 backdrop-blur-sm">
            <CardHeader>
              <CardTitle className="text-lg flex items-center justify-between">
                Financial Report
                <span className="text-xs font-normal text-slate-400">Monthly breakdown</span>
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {summary.finance.monthly_income.map((item: any) => (
                  <div key={item.month} className="flex items-center justify-between group">
                    <span className="text-slate-400 group-hover:text-slate-200 transition-colors">{item.month}</span>
                    <div className="flex-1 mx-4 h-2 bg-slate-800 rounded-full overflow-hidden">
                      <div 
                        className="h-full bg-gradient-to-r from-blue-500 to-emerald-500 transition-all duration-1000" 
                        style={{ width: `${(item.amount / summary.finance.total_income) * 100}%` }}
                      />
                    </div>
                    <span className="font-semibold">Rp {parseInt(item.amount).toLocaleString()}</span>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>

          <Card className="bg-slate-900/50 border-slate-800 backdrop-blur-sm">
            <CardHeader>
              <CardTitle className="text-lg">Recent Attendance</CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-4">
                {summary.attendance.slice(0, 5).map((item: any) => (
                  <div key={item.student_id} className="flex items-center justify-between p-3 rounded-lg bg-slate-800/30 hover:bg-slate-800/50 transition-colors">
                    <div className="flex items-center gap-3">
                      <div className="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">
                        {item.student?.name[0] || 'S'}
                      </div>
                      <div>
                        <p className="text-sm font-medium">{item.student?.name || 'Siswa'}</p>
                        <p className="text-xs text-slate-400">Checked in just now</p>
                      </div>
                    </div>
                    <Badge variant="outline" className="bg-emerald-500/10 text-emerald-500 border-emerald-500/20">
                      Present
                    </Badge>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </DashboardLayout>
  );
}

function StatCard({ title, value, icon, trend }: { title: string, value: any, icon: React.ReactNode, trend: string }) {
  return (
    <Card className="bg-slate-900/50 border-slate-800 hover:border-slate-700 transition-all hover:shadow-lg hover:shadow-blue-500/5">
      <CardHeader className="flex flex-row items-center justify-between pb-2">
        <CardTitle className="text-sm font-medium text-slate-400">{title}</CardTitle>
        {icon}
      </CardHeader>
      <CardContent>
        <div className="text-2xl font-bold">{value}</div>
        <p className="text-xs text-slate-500 mt-1 flex items-center gap-1">
          {trend}
        </p>
      </CardContent>
    </Card>
  );
}
