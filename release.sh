#!/bin/bash

# The purpose of this bash script is to generate a .zip archive for PHP SDK.

# Target folder for the .zip archive.
FOLDER='sdkphp/'

# Version number taken from src/settings.ini configuration file.
VERS=$(awk -F "=" '/SDK_VERSION/ {print $2}' src/settings.ini)

# Function generating timestamp for the .zip archive name.
timestamp() {
  date +"%Y%m%d%H%M%S"
}
# Timestamp variable to receive result from timestamp().
TIMESTAMP=$(timestamp)

# Generating the .zip archive deliverable with a timestamp and a version number in the root directory of the project.
# Note : If you are running a Windows operating system you have to install .zip package to git bash(assuming that is what you are using for running this script)
# You can do that via GoW : https://github.com/bmatzelle/gow/wiki . Here you can find a description of GoW and detailed guide on how to add packages to your git bash console.
zip -r "Sdk-Ris-Php-$VERS-$TIMESTAMP.zip" . -x vendor/\* -x build/\* -x .git/\* $FOLDER

if [ $? -ne 0 ]
then
	echo 'Errors occurred while creating .zip archive.'
	exit $?
fi
