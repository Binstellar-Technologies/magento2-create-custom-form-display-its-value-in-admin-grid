## Magento2 - Create custom form & display its value in Admin Grid


> In this extension we have created a Custom Form in Magento2 frontend & displayed it's value in admin grid. In order to do the same please install the extension.

> The Grid output you can see under Admin > Binstellar > Freehomemeasure Form Details 

> Additional we have also added code for getting this values via GraphQL


## Installation Steps

Step 1 : Download the Zip file from Github & Unzip it
Step 2 : Create a directory under app/code/Binstellar/Freehomemeasure
Step 3 : Upload the files & folders from extracted package to app/code/Binstellar/Freehomemeasure
Step 4 : Go to the Magento2 Root directory & run following commands

php bin/magento setup:upgrade 
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush

