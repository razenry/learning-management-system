'use client';

import { DashboardLayout } from '@/components/dashboard-layout';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { useRealtimeHafiz } from '@/hooks/realtime';
import { useQuery } from '@tanstack/react-query';
import apiClient from '@/lib/api-client';
import { Badge } from '@/components/ui/badge';
import { BookMarked, Trophy } from 'lucide-react';

export default function HafizPage() {
  useRealtimeHafiz();

  const { data: hafizData, isLoading } = useQuery({
    queryKey: ['hafiz-progress'],
    queryFn: async () => {
      const res = await apiClient.get('/admin/reports/hafiz');
      return res.data.data;
    },
    refetchInterval: 20000,
  });

  return (
    <DashboardLayout>
      <div className="space-y-8 animate-in slide-in-from-bottom-4 duration-500">
        <div className="flex items-center justify-between">
          <h3 className="text-2xl font-bold">Hafiz Progress Tracking</h3>
          <Badge className="bg-amber-500/10 text-amber-500 border-amber-500/20 px-3 py-1 flex gap-1 items-center">
            <Trophy size={14} /> Leaderboard Live
          </Badge>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {isLoading ? (
            [1, 2, 3].map(i => <Card key={i} className="h-48 bg-slate-900/50 border-slate-800 animate-pulse" />)
          ) : (
            hafizData.map((item: any, index: number) => (
              <Card key={item.student_id} className="bg-slate-900/50 border-slate-800 hover:border-blue-500/30 transition-all group overflow-hidden">
                <CardHeader className="flex flex-row items-center gap-4">
                  <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-emerald-500 flex items-center justify-center text-xl font-bold">
                    {index + 1}
                  </div>
                  <div>
                    <CardTitle className="text-lg">{item.student?.name || `Student #${item.student_id}`}</CardTitle>
                    <p className="text-sm text-slate-400">Target: 30 Juz</p>
                  </div>
                </CardHeader>
                <CardContent className="space-y-4">
                  <div className="flex justify-between items-end">
                    <div className="space-y-1">
                      <p className="text-xs text-slate-500 uppercase tracking-widest font-bold">Current Progress</p>
                      <p className="text-2xl font-bold text-emerald-400">{item.last_juz} <span className="text-sm text-slate-500">Juz</span></p>
                    </div>
                    <div className="text-right">
                      <p className="text-xs text-slate-500">Last update</p>
                      <p className="text-sm font-medium">Just now</p>
                    </div>
                  </div>
                  
                  <div className="h-2 bg-slate-800 rounded-full overflow-hidden">
                    <div 
                      className="h-full bg-gradient-to-r from-blue-500 via-emerald-500 to-blue-500 bg-[length:200%_auto] animate-gradient transition-all duration-1000" 
                      style={{ width: `${(item.last_juz / 30) * 100}%` }}
                    />
                  </div>
                  
                  <div className="flex items-center gap-2 text-xs text-slate-400 bg-slate-800/30 p-2 rounded-lg">
                    <BookMarked size={14} className="text-blue-400" />
                    <span>Total {item.total_entries} entries recorded</span>
                  </div>
                </CardContent>
              </Card>
            ))
          )}
        </div>
      </div>
    </DashboardLayout>
  );
}
