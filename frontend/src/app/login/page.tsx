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
    if (!email || !password) {
      toast.error('Please enter both email and password');
      return;
    }
    
    setIsLoading(true);
    try {
      console.log('Attempting login to:', apiClient.defaults.baseURL);
      const res = await apiClient.post('/auth/login', { email, password });
      
      const { user, token } = res.data.data;
      setAuth(user, token);
      
      toast.success(`Welcome back, ${user.name}!`);
      router.push('/dashboard');
    } catch (err: any) {
      console.error('Login error:', err);
      const message = err.response?.data?.message || 'Connection refused. Check if the backend is running on port 8000.';
      toast.error(message);
    } finally {
      setIsLoading(false);
    }
  };

  const handleQuickLogin = (email: string) => {
    setEmail(email);
    setPassword('password');
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
            <Button 
              type="submit"
              className="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-semibold transition-all duration-300 shadow-lg shadow-blue-500/20" 
              disabled={isLoading}
            >
              {isLoading ? (
                <div className="flex items-center gap-2">
                  <div className="h-4 w-4 animate-spin rounded-full border-2 border-white border-t-transparent" />
                  <span>Signing in...</span>
                </div>
              ) : 'Sign In'}
            </Button>
          </form>
          
          <div className="mt-8 text-center space-y-3">
            <div className="relative">
              <div className="absolute inset-0 flex items-center"><span className="w-full border-t border-slate-800"></span></div>
              <div className="relative flex justify-center text-xs uppercase"><span className="bg-slate-900 px-2 text-slate-500">Demo Accounts</span></div>
            </div>
            <div className="grid grid-cols-2 gap-2">
              <QuickLogin email="superadmin@lms.com" label="Superadmin" onClick={handleQuickLogin} />
              <QuickLogin email="admin@lms.com" label="Admin" onClick={handleQuickLogin} />
              <QuickLogin email="guru@lms.com" label="Teacher" onClick={handleQuickLogin} />
              <QuickLogin email="siswa@lms.com" label="Student" onClick={handleQuickLogin} />
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
      type="button"
      onClick={() => onClick(email)}
      className="text-[10px] py-1.5 px-2 rounded bg-slate-800/30 text-slate-400 border border-slate-800/50 hover:bg-slate-800 hover:text-blue-400 hover:border-blue-500/30 transition-all duration-200"
    >
      {label}
    </button>
  );
}
