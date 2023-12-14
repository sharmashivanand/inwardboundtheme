#!/bin/sh
nohup sass --trace --style expanded --watch style.scss:style.css &
nohup sass --trace --style compressed --watch style.scss:style.min.css &
echo "watching. carry on…"

