#!/bin/bash
  
while read LINE 
do
    #php save_html.php "$LINE"
    wkhtmltopdf "$LINE".html msu"$LINE".pdf
    #sleep 5
done < $1

#php update_vendor_inactive.php 0058265
