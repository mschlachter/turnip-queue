#!/usr/bin/env bash

changedFiles="$(git diff-tree -r --name-only --no-commit-id ORIG_HEAD HEAD)"

checkForChangedFiles() {
    echo "$changedFiles" | grep --quiet "$1" && eval "$2"
}

packageJsonHasChanged() {
  echo "Changes to package-lock.json detected, installing updates"
  npm i
}

checkForChangedFiles package-lock.json packageJsonHasChanged
