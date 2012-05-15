#!/bin/sh


if [ -f cat.pid ]; then
   read pid < cat.pid
   kill $pid
   rm cat.pid
fi

if [ -f vlc.pid ]; then
   read pid < vlc.pid
   kill $pid
   rm vlc.pid
fi
