
# Getting Started

## Set your environment URLs
1. Open index.php and locate the Environment section.
2. Update the proper urls for each environment.

## Create Facebook app
1. Login to http://developers.facebook.com and create an a new app with two testing version. One named <project name> production and one named <project name> development.
2. Use your local dev domain for the 'Site URL' under the Website section and then use the same domain for the other Canvas and Page Tab settings.
3. Do the same for the staging location.

## Update Facebook config files
There are facebook config files available for each location. Please copy and paste your facebook id and secret for each.
application/config/development/facebook.php
application/config/production/facebook.php
application/config/staging/facebook.php
