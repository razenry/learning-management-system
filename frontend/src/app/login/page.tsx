'use client';

import { useState } from 'react';
import { useAuthStore } from '@/store/useAuthStore';
import { useRouter } from 'next/navigation';
import apiClient from '@/lib/api-client';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { toast } from 'sonner';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const setAuth = useAuthStore((state) => state.setAuth);
  const router = useRouter();

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);
    try {
      const res = await apiClient.post('/auth/login', { email, password });
      setAuth(res.data.data.user, res.data.data.token);
      toast.success('Welcome to LMS Razenry!');
      router.push('/dashboard');
    } catch (err: any) {
      toast.error(err.response?.data?.message || 'Login failed');
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-slate-950 p-4">
      <div className="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-900/20 via-slate-950 to-slate-950 -z-10" />
      
      <Card className="w-full max-w-md bg-slate-900/50 border-slate-800 backdrop-blur-xl">
        <CardHeader className="text-center">
          <CardTitle className="text-3xl font-bold bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">
            LMS Razenry
          </CardTitle>
          <CardDescription className="text-slate-400">
            Enter your credentials to access the portal
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleLogin} className="space-y-4">
            <div className="space-y-2">
              <Input
                type="email"
                placeholder="Email Address"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
                className="bg-slate-800/50 border-slate-700 text-slate-100 placeholder:text-slate-500"
                required
              />
            </div>
            <div className="space-y-2">
              <Input
                type="password"
                placeholder="Password"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                className="bg-slate-800/50 border-slate-700 text-slate-100 placeholder:text-slate-500"
                required
              />
            </div>
            <Button className="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-semibold transition-all duration-300" disabled={isLoading}>
              {isLoading ? 'Signing in...' : 'Sign In'}
            </Button>
          </form>
          
          <div className="mt-6 text-center space-y-2">
            <p className="text-xs text-slate-500 uppercase font-semibold tracking-wider">Default Accounts</p>
            <div className="grid grid-cols-2 gap-2">
              <QuickLogin email="superadmin@lms.com" label="Superadmin" onClick={setEmail} />
              <QuickLogin email="admin@lms.com" label="Admin" onClick={setEmail} />
              <QuickLogin email="guru@lms.com" label="Guru" onClick={setEmail} />
              <QuickLogin email="siswa@lms.com" label="Siswa" onClick={setEmail} />
            </div>
          </div>
        </CardContent>
      </Card>
    </div>
  );
}

function QuickLogin({ email, label, onClick }: { email: string, label: string, onClick: (e: string) => void }) {
  return (
    <button 
      onClick={() => onClick(email)}
      className="text-xs py-1 px-2 rounded bg-slate-800/50 text-slate-400 hover:bg-slate-800 hover:text-blue-400 transition-colors"
    >
      {label}
    </button>
  );
}
