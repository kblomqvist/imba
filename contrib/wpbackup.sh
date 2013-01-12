#!/bin/bash
#
# Install:
#   nano wpbackup.sh # Setup backup properties
#   chmod 701 wpbackup.sh
#
#  Check list:
#   - Be sure that you have MySQL privilege to LOCK TABLES, otherwise
#     database backup won't work.
#
# Usage:
#
#  Create a quick copy:
#   ./wpbackup.sh
#
#  Create a named copy:
#   ./wpbackup.sh daily
#
# Setting up crontab:
#   1 1 * * * /path/to/wpbackup.sh daily
#   2 2 * * 7 /path/to/wpbackup.sh weekly
#   3 3 1 * * /path/to/wpbackup.sh monthly
#
# Copyright (c) 2012 Kim Blomqvist
# All rights reserved.
#
# GPL License
#

# Your wordpress site name
SITENAME=""

# Absolute path where to put backup files; WITHOUT trailing slash
DEST_FOLDER="/path/to/bak"

# Which files to backup, or add to tarball
TAR_FILES="-C /path/to www"

# Patterns to be excluded from tarball
TAR_EXCLUDE="--exclude=Zend"

# Database access
DB_USER=""
DB_PASSWD=""
DB_HOST="localhost"

# Which db and table prefix
DB_DATABASE=""
DB_TABLE_PREFIX="wpfi_"

#########################################################################
# Script starts here
#########################################################################

if [ "$#" -eq 1 ]
then
        SUFFIX=$1
else
        SUFFIX=`date +%F`
fi

TARBALL="$SITENAME-$SUFFIX.tar.gz"
SQLDUMP="$SITENAME-$SUFFIX.sql"

# Change folder to destination
cd $DEST_FOLDER

# Take mysql dump
mysqldump -h$DB_HOST -u$DB_USER -p$DB_PASSWD $DB_DATABASE \
        $(mysql -h$DB_HOST -u$DB_USER -p$DB_PASSWD -D $DB_DATABASE \
        -Bse "show tables like '$DB_TABLE_PREFIX%'") > $SQLDUMP && chmod 600 $SQLDUMP

# Copies wordpress directory
tar -zcf $TARBALL $TAR_EXCLUDE $SQLDUMP $TAR_FILES && chmod 600 $TARBALL

# Do some cleanings
rm $SQLDUMP

echo "Wordpress backup file created: $TARBALL"
exit 0
