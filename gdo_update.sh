#!/bin/bash
cd "$(dirname "$0")"

CORE="$(dirname "$0")"

find . -iname ".git" -type d -exec sh -c "cd $CORE && cd {} && cd .. && pwd && LANG=en_GB LC_ALL=en_GB git pull  && git submodule update --recursive --remote && sleep 1" \;
