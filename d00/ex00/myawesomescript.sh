#!/bin/sh

if [ "$1" ]; then
    curl -s "$1" | grep href | cut -d '"' -f2
else
    echo "usage: $0 <bit.ly URL>"
    exit 1
fi