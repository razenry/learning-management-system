'use client';

import { useEffect, useState } from 'react';
import { echo } from '@/lib/echo';
import { Badge } from '@/components/ui/badge';
import { Wifi, WifiOff } from 'lucide-react';

export function RealtimeIndicator() {
  const [isConnected, setIsConnected] = useState(false);

  useEffect(() => {
    if (!echo) return;

    const checkConnection = () => {
      // Echo doesn't have a direct 'connected' property easily accessible
      // We check the underlying pusher connection
      const status = (echo as any).connector.pusher.connection.state;
      setIsConnected(status === 'connected');
    };

    checkConnection();
    
    (echo as any).connector.pusher.connection.bind('state_change', (states: any) => {
      setIsConnected(states.current === 'connected');
    });

    return () => {
      (echo as any).connector.pusher.connection.unbind('state_change');
    };
  }, []);

  return (
    <div className="flex items-center gap-2">
      {isConnected ? (
        <Badge variant="outline" className="bg-green-500/10 text-green-500 border-green-500/20 flex gap-1 items-center">
          <Wifi className="w-3 h-3" /> Realtime Active
        </Badge>
      ) : (
        <Badge variant="outline" className="bg-yellow-500/10 text-yellow-500 border-yellow-500/20 flex gap-1 items-center">
          <WifiOff className="w-3 h-3" /> Polling (Fallback)
        </Badge>
      )}
    </div>
  );
}
