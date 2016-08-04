# mantisbt-bitbucket-integration
PHP Checkin handler for MantisBT using Bitbucket's webhook

## Installation
Add checkingit.php and checkinggit.log to the root of your MantisBT installation.
See config_inc_sample.php for required config settings, these settings need to be set in your config_inc.php

## Set-up
Go to the "Webhooks" section of the repository settings at Bitbucket and add the url to the checkingit.php in your MantisBT installation, e.g.:
http://mantis.yoursite.com/checkingit.php

Set the "Triggers" option to "Repository Push", so the hook will be called on each time you use the "git push" command