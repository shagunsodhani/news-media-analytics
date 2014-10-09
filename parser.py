try:
	import db
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import time
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import datetime
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

count = 0
headline = []
sdate = []
edate = []
source = []
url = []

def date_to_timestamp(stime):
	return time.mktime(datetime.datetime.strptime(stime, "%m/%d/%Y %H:%M").timetuple())

parser = open("1.csv", "r")
for i in parser:
	line = i.split(",")
	headline.append(str(line[1]))
	stime = date_to_timestamp(str(line[2])) 
	etime = date_to_timestamp(str(line[3]))
	edate.append(str(etime))
	sdate.append(str(stime))
	source.append(str(line[4]))
	url.append(str(line[5]))