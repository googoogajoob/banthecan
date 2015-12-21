#!/bin/bash

fileName="banthecan-DB-Structure"
today=`date +%d%b%Y`
archiveName=$fileName
archiveName+=_$today.sql
mv $fileName.sql $archiveName
mysqldump -u root -p --no-data banthecan-demo > $fileName.sql
