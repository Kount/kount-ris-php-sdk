#!/usr/bin/env bash


set -e
set -u

# decrypt the private key
echo "$SSH_PRIVATE_KEY" > ./gitlab-deploy-key
chmod 400 ./gitlab-deploy-key

# set the git username/email to be able to perform git operations
echo git version: $(git --version)
git config --global user.name "@sanjee"
git config --global user.email "sanjeev@gmail.com"

# set the push URL differently to leverage SSH protocol
git remote set-url --push origin git@gitlab.com:gitlab-ci-cd-pipeine/phpcicdproject.git
git remote -v

# getting version from setting.ini file
# eval $(cat settings.ini)
# echo $vers
vers=$(awk -F "=" '/SDK_VERSION/ {print $2}' src/settings.ini)
echo $vers

# set the git tag to the current version
VERSION=$vers
git tag -a $VERSION -m "Setting version as tag during build."

# push the git tag
# leverage GIT_SSH option to use a dedicated SSH key
# see https://git-scm.com/docs/git#git-codeGITSSHcode for documentation of this feature
echo 'ssh -i ./gitlab-deploy-key -o UserKnownHostsFile=/dev/null -o StrictHostKeyChecking=no $*' > ssh
chmod +x ssh
GIT_SSH='./ssh' git push origin $VERSION