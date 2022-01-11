# WebinarPress Dev Setup
The JS parts of WebinarPress are compiled using Webpack and compiled into a single bundle. 

# WordPress Setup
I personally use MAMP to setup WordPress sites on my Mac because it makes it easy to restore to certain points which is great for testing pre-release versions.

Once WordPress is setup you can clone the project repo directly into the WordPress `/wp-content/plugins` folder and activate the plugin inside WordPress.

## Prerequisite:
- Node `11.9.0` (I recommend using `nvm` to make switching easier between projects)
- npm >= `6.5.0`

## Project setup
1. `cd <project_folder>/wpws-js`
2. `npm install`

## Development
1. `cd <project_folder>/wpws-js`
2. `npm watch`

## Build
1. `cd <project_folder>/wpws-js`
2. `npm build`

