## Magento2 - Create custom form & display its value in Admin Grid


> In this extension we have created a Custom Form in Magento2 frontend & displayed it's value in admin grid. In order to do the same please install the extension.

> The Grid output you can see under Admin > Binstellar > Freehomemeasure Form Details 

> Additional we have also added code for getting this values via GraphQL

&nbsp;
&nbsp;

## Installation Steps

##### Step 1 : Download the Zip file from Github & Unzip it
##### Step 2 : Create a directory under app/code/Binstellar/Freehomemeasure
##### Step 3 : Upload the files & folders from extracted package to app/code/Binstellar/Freehomemeasure
##### Step 4 : Go to the Magento2 Root directory & run following commands

php bin/magento setup:upgrade

php bin/magento setup:di:compile

php bin/magento setup:static-content:deploy -f

php bin/magento cache:flush

### Frontend Output

![image1](https://user-images.githubusercontent.com/123800304/215443052-02054c02-f4fc-4fcf-9481-7849f3dc1487.png)


### Admin Menu
![image2](https://user-images.githubusercontent.com/123800304/215443495-7af2013c-d8bd-4545-948a-b3a02a593a7b.png)


### Admin Grid
![image4](https://user-images.githubusercontent.com/123800304/215443611-afa4fef7-08fe-4693-8955-d6f02dd038f6.png)


### More Details for each form
![image3](https://user-images.githubusercontent.com/123800304/215443818-78da8033-4ae3-4cad-90d0-6bccde802607.png)


&nbsp;
&nbsp;

## Note : We have tested this option in Magento ver. 2.4.5-p1
