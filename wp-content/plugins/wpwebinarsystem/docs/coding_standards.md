# WebinarPress Coding Standards

## Linting
All JS code is linted with `eslint` using the `.eslintrc` file from the project folder. All code should be free of linting issues before submitting.

## Feature branches
All new features should be created in a feature branch based on `pro-stable`. Before staring a new feature you should create a new branch including the GitHub issue ID and a short description. For example:

`123-improve-webinar-setup-flow`

**Feature branches should not be merged into pro-stable until they have been tested & approved.**

## Commit Messages
Commit messages should include the GitHub issue ID at the start so they are automatically referenced in GitHub. For example:

`git commit -m "#123 Improve webinar setup flow"`