#!/bin/sh 
readonly APP_PATHNAME=./datacollect_control_server
PROC_ID=`ps -ef|grep $APP_PATHNAME|grep -v grep|awk '{print $2}'`
if [ X"$PROC_ID" != X ]
then
    echo "$APP_PATHNAME is running, begin to kill old instance"
    ps -ef | grep $APP_PATHNAME | grep -v grep | awk '{printf("kill -9 %s\n",$2)}' | sh
    if [ -e $APP_PATHNAME ] ; then
        $APP_PATHNAME $1
    else
        echo "$APP_PATHNAME is not in current directory,Please change to correct directory"
        exit 2
    fi
else
    if [ -e $APP_PATHNAME ] ; then
        echo "$APP_PATHNAME is not running, begin to start"
        $APP_PATHNAME $1
    else
        echo "$APP_PATHNAME is not in current directory,Please change to correct directory"
        exit 2
    fi
fi
