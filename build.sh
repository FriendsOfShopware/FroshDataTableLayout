#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$(git tag | tail -n 1)
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

# Remove old release
rm -rf FroshDataTableLayout FroshDataTableLayout-*.zip

# Build new release
mkdir -p FroshDataTableLayout
git archive ${commit} | tar -x -C FroshDataTableLayout
composer install --no-dev -n -o -d FroshDataTableLayout
zip -x "*build.sh*" -x "*.MD" -r FroshDataTableLayout-${commit}.zip FroshDataTableLayout