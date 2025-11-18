#!/usr/bin/env bash

set -euo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$REPO_ROOT"

VERSION_FILE="$REPO_ROOT/version.txt"
README_FILE="$REPO_ROOT/README.md"

if [[ ! -f "$VERSION_FILE" ]]; then
  echo "version.txt not found in $REPO_ROOT" >&2
  exit 1
fi

CURRENT_VERSION="$(tr -d '[:space:]' < "$VERSION_FILE")"

if [[ -z "$CURRENT_VERSION" ]]; then
  echo "version.txt is empty" >&2
  exit 1
fi

IFS='.' read -r MAJOR MINOR PATCH <<< "$CURRENT_VERSION"
PATCH=$((PATCH + 1))
NEW_VERSION="${MAJOR}.${MINOR}.${PATCH}"

echo "$NEW_VERSION" > "$VERSION_FILE"

if [[ -f "$README_FILE" ]]; then
  perl -0pi -e "s/version-${CURRENT_VERSION}/version-${NEW_VERSION}/g; s/# versions : \\* ${CURRENT_VERSION}/# versions : * ${NEW_VERSION}/g" "$README_FILE"
fi

COMMIT_MESSAGE="${1:-}"
if [[ -z "$COMMIT_MESSAGE" ]]; then
  COMMIT_MESSAGE="Increase version number to $NEW_VERSION"
fi

git add .
git commit -m "$COMMIT_MESSAGE"
git tag "v$NEW_VERSION"

CURRENT_BRANCH="$(git symbolic-ref --quiet --short HEAD)"

if [[ -z "$CURRENT_BRANCH" ]]; then
  echo "Unable to determine current branch" >&2
  exit 1
fi

remotes=()
if git remote | grep -qx "origin"; then
  remotes+=("origin")
fi
if git remote | grep -qx "gitlab"; then
  remotes+=("gitlab")
fi

if [[ ${#remotes[@]} -eq 0 ]]; then
  echo "No git remotes named 'origin' or 'gitlab' found" >&2
  exit 1
fi

for remote in "${remotes[@]}"; do
  git push "$remote" "$CURRENT_BRANCH"
  git push "$remote" --tags
done

echo "Release $NEW_VERSION pushed successfully."

