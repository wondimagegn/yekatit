#!/bin/bash

# Taken from http://book.cakephp.org/view/846/Running-Shells-as-cronjobs

# To use it in CRON:

# /var/www/vhosts/wmis.dev/app/vendors/cakeshell myscript -cli /usr/bin -console /var/www/wmis.dev/cake/console/ -app /var/www/wmis.dev/app/

TERM=dumb
export TERM
cmd="cake"
while [ $# -ne 0 ]; do
    if [ "$1" = "-cli" ] || [ "$1" = "-console" ]; then 
        PATH=$PATH:$2
        shift
    else
        cmd="${cmd} $1"
    fi
    shift
done
$cmd
