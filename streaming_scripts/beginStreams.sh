#!/bin/bash

CAT_PID=cat.pid
VLC_PID=vlc.pid

DEVICE=/dev/video0
HTTP_PORT=8181
HTTP_FILE=livestream.ts

HLS_LOCATION=/var/www/streaming
HOST_PATH=http://glendora.philgomez.com/streaming
M3U8_NAME=mystream.m3u8
SEGMENT_NAME=mystream-########.ts
SEGMENT_LENGTH=3
NUM_SEGMENTS=15
DELETE_SEGMENTS=true

# Before we start clean up old ts files
rm $HLS_LOCATION/*.ts >/dev/null 2>&1

(cat /dev/video0 & echo $! >$CAT_PID) | cvlc -vvv - --sout "#duplicate{dst=http{dst=:$HTTP_PORT/$HTTP_FILE},dst=std{access=livehttp{seglen=$SEGMENT_LENGTH,delsegs=$DELETE_SEGMENTS,numsegs=$NUM_SEGMENTS,index=$HLS_LOCATION/$M3U8_NAME,index-url=$HOST_PATH/$SEGMENT_NAME},mux=ts{use-key-frames},dst=$HLS_LOCATION/$SEGMENT_NAME}}" >/dev/null 2>&1 & 
echo $! >$VLC_PID

