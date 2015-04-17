#!/bin/bash
set -e

CI_VERSION=3.0.0
LODASH_VERSION=3.7.0
BOOTSTRAP_VERSION=3.3.4
FA_VERSION=4.3.0
CI_REST_VERSION=2.7.1

DIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
BUILD_DIR=${DIR}/CodeIgniter-Bootstrap

# PRE
rm -rf ${BUILD_DIR}
rm -rf .tmp
mkdir .tmp
pushd .tmp

# CODEIGNITER
wget https://github.com/bcit-ci/CodeIgniter/archive/${CI_VERSION}.zip -O codeigniter.zip
unzip codeigniter.zip
mv CodeIgniter-${CI_VERSION} ${BUILD_DIR}
mkdir ${BUILD_DIR}/assets
mkdir ${BUILD_DIR}/assets/js
mkdir ${BUILD_DIR}/assets/css
mkdir ${BUILD_DIR}/assets/fonts

# LODASH
wget https://raw.githubusercontent.com/lodash/lodash/${LODASH_VERSION}/lodash.min.js
mv lodash.min.js ${BUILD_DIR}/assets/js

# BOOTSTRAP
wget https://github.com/twbs/bootstrap/releases/download/v${BOOTSTRAP_VERSION}/bootstrap-${BOOTSTRAP_VERSION}-dist.zip
unzip bootstrap-${BOOTSTRAP_VERSION}-dist.zip
pushd bootstrap-${BOOTSTRAP_VERSION}-dist
mv css/bootstrap.css.map ${BUILD_DIR}/assets/css
mv css/bootstrap.min.css ${BUILD_DIR}/assets/css
mv fonts/* ${BUILD_DIR}/assets/fonts
mv js/bootstrap.min.js ${BUILD_DIR}/assets/js
popd

# FONT AWESOME
wget http://fortawesome.github.io/Font-Awesome/assets/font-awesome-${FA_VERSION}.zip -O font-awesome.zip
unzip font-awesome.zip
pushd font-awesome-${FA_VERSION}
mv css/* ${BUILD_DIR}/assets/css
mv fonts/* ${BUILD_DIR}/assets/fonts
popd

# CI REST SERVER
wget https://github.com/chriskacerguis/codeigniter-restserver/archive/${CI_REST_VERSION}.zip -O codeigniter-restserver.zip
unzip codeigniter-restserver.zip
pushd codeigniter-restserver-${CI_REST_VERSION}
mv application/libraries/Format.php ${BUILD_DIR}/application/libraries
mv application/libraries/REST_Controller.php ${BUILD_DIR}/application/libraries
sed -i .bak "s/\'xml\'/\'json\'/" application/config/rest.php
mv application/config/rest.php ${BUILD_DIR}/application/config
popd

# POST
popd

# COPY
rsync -av ${DIR}/files/ ${BUILD_DIR}/

# ARCHIVE
zip -r CodeIgniter-Bootstrap.zip CodeIgniter-Bootstrap

# CLEANUP
rm -rf .tmp
rm -rf ${BUILD_DIR}