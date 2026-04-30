import { create } from 'zustand';
import { persist } from 'zustand/middleware';

interface Role {
  id: number;
  name: string;
  guard_name: string;
}

interface User {
  id: number;
  name: string;
  email: string;
  role_id: number;
  phone?: string;
  roles: Role[];
}

interface AuthState {
  user: User | null;
  token: string | null;
  setAuth: (user: User, token: string) => void;
  logout: () => void;
  isAuthenticated: () => boolean;
  hasRole: (role: string) => boolean;
  getPrimaryRole: () => string;
}

export const useAuthStore = create<AuthState>()(
  persist(
    (set, get) => ({
      user: null,
      token: null,
      setAuth: (user, token) => {
        if (typeof window !== 'undefined') {
          localStorage.setItem('auth_token', token);
        }
        // Ensure roles is always an array
        const safeUser = {
          ...user,
          roles: user.roles ?? [],
        };
        set({ user: safeUser, token });
      },
      logout: () => {
        if (typeof window !== 'undefined') {
          localStorage.removeItem('auth_token');
        }
        set({ user: null, token: null });
      },
      isAuthenticated: () => !!get().token,
      hasRole: (role) => {
        const user = get().user;
        if (!user) return false;
        return (user.roles ?? []).some((r) => r.name === role);
      },
      getPrimaryRole: () => {
        const user = get().user;
        if (!user || !user.roles || user.roles.length === 0) return 'user';
        return user.roles[0].name;
      },
    }),
    {
      name: 'auth-storage',
      version: 2, // Bumped to clear stale sessions missing roles
      migrate: (persistedState: any, version: number) => {
        if (version < 2) {
          // Old sessions don't have roles, force logout
          return { user: null, token: null };
        }
        return persistedState;
      },
    }
  )
);
