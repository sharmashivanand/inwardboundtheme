#!/bin/bash
#sass --watch style.scss:style.min.css --style compressed &
#sass --watch style.scss:style.css --style expanded &

nohup scss --watch style.scss:style.min.css --style compressed &

nohup scss --watch style.scss:style.css --style nested &

echo SCSS watch running
