#!/bin/sh
echo "Log:hey!the script is running!<br/>"
cd "`dirname "$0"`"
sudo python scanner.py
echo "Log:hey!scanner just worked!<br/>"
