#!/usr/bin/python

# Usage:
#  >>> python DateConverter.py "Monday 12 Aug 2018"
#  >>> 2018,8,12,21
#  The format is year, month, day, hour (24 hr format)

# You need to install:
# python 3.6
# pip install --upgrade natty
# pip install --upgrade JPype=0.6.3

# How do you call it from PHP?
# exec("python DateConverter.py 'The Date Information'",$output);
# var_dump($output);

import sys
from natty import DateParser

def ConvertDate(date):

	if (type(date) is str):
		dp = DateParser(date)
		return dp.result()

	print ("ERROR: You need to parse a string instead of other types.")
	return None

if __name__ == '__main__':
	res = ConvertDate(sys.argv[1])
	# print ("Year: " + str(res[0].year))
	# print ("Month: " + str(res[0].month))
	# print ("Day: " + str(res[0].day))
	# print ("Hour: " + str(res[0].hour))
	# print ("Minute: " + str(res[0].minute))
	# print ("Seconds: " + str(res[0].second))

	for i in range(len(res)):
		print (str(res[i].year) + "," + str(res[i].month) + "," + str(res[i].day) + "," + str(res[i].hour) + ";")
