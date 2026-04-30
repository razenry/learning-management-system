'use client';

import { useAuthStore } from '@/store/useAuthStore';
import { useRouter } from 'next/navigation';
import { useEffect } from 'react';
import { RealtimeIndicator } from './realtime-indicator';
import { Button } from './ui/button';
import { LogOut, LayoutDashboard, Users, BookOpen, QrCode, FileText, Bell } from 'lucide-react';
import Link from 'next/link';

export function DashboardLayout({ children }: { children: React.ReactNode }) {
  const { user, logout, isAuthenticated } = useAuthStore();
  const router = useRouter();

  useEffect(() => {
    if (!isAuthenticated()) {
      router.push('/login');
    }
  }, [isAuthenticated, router]);

  if (!user) return null;

  return (
    <div className="flex h-screen bg-slate-950 text-slate-50">
      {/* Sidebar */}
      <aside className="w-64 border-r border-slate-800 bg-slate-900/50 backdrop-blur-xl flex flex-col">
        <div className="p-6 border-b border-slate-800">
          <h1 className="text-xl font-bold bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
            LMS Razenry
          </h1>
        </div>
        
        <nav className="flex-1 p-4 space-y-2">
          <SidebarItem href="/dashboard" icon={<LayoutDashboard size={20} />} label="Dashboard" />
          
          {(user.roles ?? []).some(r => r.name === 'admin' || r.name === 'superadmin') && (
            <SidebarItem href="/dashboard/reports" icon={<FileText size={20} />} label="Reports" />
          )}
          
          {(user.roles ?? []).some(r => r.name === 'guru') && (
            <>
              <SidebarItem href="/dashboard/attendance" icon={<QrCode size={20} />} label="Attendance" />
              <SidebarItem href="/dashboard/classes" icon={<BookOpen size={20} />} label="Classes" />
            </>
          )}

          <SidebarItem href="/dashboard/lms" icon={<Users size={20} />} label="Materials" />
        </nav>

        <div className="p-4 border-t border-slate-800">
          <div className="flex items-center gap-3 mb-4 px-2">
            <div className="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center font-bold">
              {user.name[0]}
            </div>
            <div className="flex-1 truncate">
              <p className="text-sm font-medium truncate">{user.name}</p>
              <p className="text-xs text-slate-400 truncate capitalize">{(user.roles ?? [])[0]?.name ?? 'user'}</p>
            </div>
          </div>
          <Button variant="ghost" className="w-full justify-start text-slate-400 hover:text-red-400 hover:bg-red-400/10" onClick={logout}>
            <LogOut size={20} className="mr-2" /> Logout
          </Button>
        </div>
      </aside>

      {/* Main Content */}
      <main className="flex-1 flex flex-col overflow-hidden">
        <header className="h-16 border-b border-slate-800 flex items-center justify-between px-8 bg-slate-900/30">
          <div className="flex items-center gap-4">
            <h2 className="text-lg font-semibold">Welcome back, {user.name.split(' ')[0]}</h2>
            <RealtimeIndicator />
          </div>
          <div className="flex items-center gap-4">
            <Button variant="ghost" size="icon" className="text-slate-400">
              <Bell size={20} />
            </Button>
          </div>
        </header>
        
        <div className="flex-1 overflow-y-auto p-8 custom-scrollbar">
          {children}
        </div>
      </main>
    </div>
  );
}

function SidebarItem({ href, icon, label }: { href: string; icon: React.ReactNode; label: string }) {
  return (
    <Link href={href}>
      <div className="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-400 hover:text-blue-400 hover:bg-blue-400/10 transition-all duration-200 cursor-pointer group">
        <span className="group-hover:scale-110 transition-transform duration-200">{icon}</span>
        <span className="font-medium text-sm">{label}</span>
      </div>
    </Link>
  );
}
