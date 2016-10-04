## Upgrade Guide

The following upgrades assume that you have not tampered with the core of Canvas. If you have, you might want to make a backup or copy of your blog before
making these changes, since it will erase anything not part of the official release.

#### Step 1: Download your data
In your blog, navigate to `/admin/tools` and click **DOWNLOAD ARCHIVE**. This will gather all the data you have created/uploaded and will save it to a 
`.zip` on your computer. 

#### Step 2: Remove the current installation
Remove the blog project directory and delete the database.

#### Step 3: Re-install Canvas
Follow the [7 step installation process](https://github.com/austintoddj/canvas#installation).

#### Step 4: Re-import your data
After you've completed the installation, you can re-import your data and uploads from the archive you downloaded from [step 1](https://github.com/austintoddj/canvas/blob/master/UPGRADE.md#step-1-download-your-data).
