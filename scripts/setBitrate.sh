#!/bin/sh

BITRATE=$1
PEAKBITRATE=$2
MODE=$3
v4l2-ctl --device=/dev/video0 --set-ctrl=video_bitrate_mode=$MODE
v4l2-ctl --device=/dev/video0 --set-ctrl=video_bitrate=$BITRATE

if [ "$MODE" -eq "1" ]; then
   v4l2-ctl --device=/dev/video0 --set-ctrl=video_peak_bitrate=$PEAKBITRATE
fi
