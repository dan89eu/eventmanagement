#!/bin/bash

zip vendor.zip -q -r vendor/
aws s3 cp vendor.zip s3://eventmanangemt/ --grants read=uri=http://acs.amazonaws.com/groups/global/AllUsers --profile eventmanangement