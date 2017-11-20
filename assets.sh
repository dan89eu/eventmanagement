#!/bin/bash

cd public
zip ../assets.zip -q -r assets/
cd ..
aws s3 cp assets.zip s3://eventmanangemt/ --grants read=uri=http://acs.amazonaws.com/groups/global/AllUsers --profile eventmanangement