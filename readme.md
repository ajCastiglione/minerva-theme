# Automated local development setup for Wordpress

This package includes my custom theme based on the wordpress theme Bones and my installed dependencies.

## Setup

For node modules - `npm install`

To launch dev server with browser sync (once MAMP is running) - `gulp`

### MAMP Config and WordPress install

<ol>
<li>Install MAMP</li>
<li>Click "start servers" in the MAMP application</li>
<li>Create database named after the development site (or however you'd prefer to name it)</li>
<li>In the folder explorer - MAMP->htdocs->"Your file name here". Paste wordpress files directly into this folder</li>
<li>If you have default port settings: localhost:8888/your-folder-name-here</li>
<li>Follow the setup instructions provided by the wordpress installer</li>
<li>Wordpress is up and running!</li>
</ol>

### GulpJs and Browsersync - my settings / setup

<ol>
<li>Install gulpJS into your working directory</li>
<li>Install gulp-cli globally and browsersync locally (my preference)</li>
<li>Setup gulpfile.js to watch whatever files you'd like</li>
<li>Add a default gulp task to watch the chosen files</li>
<li>Final step: type "gulp" into the command line and you're good to go!</li>
</ol>

## Dependencies

<ul>
<li>NodeJS</li>
<li>NPM</li>
<li>GulpJS</li>
<li>Wordpress theme - Bones (modified)</li>
<li>MAMP</li>
<li>WordPress</li>
</ul>

## Updates

6/4/18: Updated setup / config. Removed the need for ruby and compass watch. Figured out weird pathing issue from earlier that didn't allow the use of gulp to compile scss.
