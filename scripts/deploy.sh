#!/bin/bash
 
REMOTE_USER="craigslittlebuddy"                    # your user name on the target server
REMOTE_ADDR="craigslittlebuddy.com"         # i.e. server.blah.com
REMOTE_PATH="/var/www/domains/craigslittlebuddy.com/www/htdocs" # remember to include trailing slash
 
if [ -d "../www" ] && [ -d "../action" ] && [ -d "../objects" ]
then
  rsync --progress -z -r \
    --exclude=".svn*" \
    --exclude=".DS_Store" \
    --exclude="setStage.sh" \
    --exclude="/cache" \
    --delete \
    ../* $REMOTE_USER@$REMOTE_ADDR:$REMOTE_PATH
  echo "craigslittlebuddy.com has been updated to match your local repository."
  exit 0
fi
 
echo "Dude, you can't run this from there. This script MUST be run from within the scripts directory, k?"