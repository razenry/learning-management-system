'use client';

import { useQueryClient } from '@tanstack/react-query';
import { useEffect } from 'react';
import { echo } from '@/lib/echo';
import { toast } from 'sonner';

export function useRealtime(channel: string, event: string, queryKeys: string[][], message?: string) {
  const queryClient = useQueryClient();

  useEffect(() => {
    if (!echo) return;

    const subscription = echo.channel(channel).listen(event, (data: any) => {
      console.log(`Realtime Event: ${event}`, data);
      
      // Invalidate related queries
      queryKeys.forEach((key) => {
        queryClient.invalidateQueries({ queryKey: key });
      });

      if (message) {
        toast.info(message);
      }
    });

    return () => {
      echo?.leaveChannel(channel);
    };
  }, [channel, event, queryKeys, queryClient, message]);
}
