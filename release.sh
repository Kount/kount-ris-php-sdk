#!/bin/bash

# The purpose of this bash script is to generate a release version and a .zip archive for PHP SDK.
# Make sure you have created a release branch with the latest changes committed and pushed, ready for merging to master.
# You must specify the release version number in the src/settings.ini file as a value of the 'VERSION_NUMBER' variable.
# In order for this script to run successfully you must have performed these several steps:
#
#  - install composer on your machine and add composer.json to the root of the project.
#  - add phpunit and phpDocumentor to composer.json, preferably in 'require-dev' section.
#  - create release branch for latest release changes following the following naming convention: 'release/(version number)'.

# Target folder for the .zip archive.
FOLDER='sdkphp/'

# Version number taken from src/settings.ini configuration file.
VERS=$(awk -F "=" '/VERSION_NUMBER/ {print $2}' src/settings.ini)

# Branch variable containing current branch. Must be the current release branch.
branch=$(git symbolic-ref --short HEAD)

# Function generating timestamp for the .zip archive name.
timestamp() {
  date +"%Y%m%d%H%M%S"
}
# Timestamp variable to receive result from timestamp().
TIMESTAMP=$(timestamp)

if [[ ! $VERS ]]
then
	echo 'VERSION_NUMBER in settings.ini is not set. Make sure you have set a version number corresponding to the release branch.';
	exit 1;
fi

if [ $branch != "release/$VERS" ]
then
	echo 'You are not in the correct branch! Switch to the release/$VERS branch with $VERS being set from settings.ini in order to pull the latest changes.';
	exit 1;
fi

git status
git fetch
git pull origin $branch

if [ $? -ne 0 ]
then
	echo 'Errors occurred while trying to pull the latest changes from release branch.'
	exit $?
fi

# Install composer dependencies.
composer install

if [ $? -ne 0 ]
then
	echo 'Errors occurred while installing composer dependencies. Make sure you have installed composer on your machine.'
	exit $?
fi

# Run phpunit tests with configuration file phpunit.xml found in the root of the project.
vendor/bin/phpunit --configuration phpunit.xml

if [ $? -ne 0 ]
then
	echo 'Errors occurred while running tests. Make sure you have added phpunit in composer.json or your tests pass correctly.'
	exit $?
fi
echo 'Tests passed successfully!'

# Generating PHP Documentation via phpDocumentator.
vendor/bin/phpdoc -d src/ -t phpdocs/

if [ $? -ne 0 ]
then
	echo 'Errors occurred while creating documentation. Make sure you have added phpdocumentor to composer.json or composer.phar.'
	exit $?
fi

# Switch branch to master and merge release changes.
git checkout master
git merge release/$VERS --no-edit

# Commit and push in master.
git push origin master

# Tag master branch with release version.
git tag -a v$VERS -m 'Version $VERS'
git push --tags

git tag
git status

# Generating the .zip archive deliverable with a timestamp and a version number in the root directory of the project.
# Note : If you are running a Windows operating system you have to install .zip package to git bash(assuming that is what you are using for running this script)
# You can do that via GoW : https://github.com/bmatzelle/gow/wiki . Here you can find a description of GoW and detailed guide on how to add packages to your git bash console.
zip -r "Sdk-Ris-Php-$VERS-$TIMESTAMP.zip" . -x vendor/\* -x build/\* $FOLDER

if [ $? -ne 0 ]
then
	echo 'Errors occurred while creating .zip archive.'
	exit $?
fi
