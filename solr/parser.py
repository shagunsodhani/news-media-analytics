try:
	import time
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

try:
	import datetime
except ImportError as exc:
	print("Error: failed to import settings module ({})".format(exc))

def date_to_timestamp(stime):
	stime = stime.split(' ')
	date = stime[0]
	temp = date.split("/")
	a = []
	a.append(int(temp[2]))
	a.append(int(temp[0]))
	a.append(int(temp[1]))
	date = stime[1].split(':')
	for i in date:
		a.append(int(i))
	a = datetime.datetime(a[0], a[1], a[2], a[3], a[4]).timetuple() 
	return time.mktime(a)
	
def parse(filename):

	count = 1

	parser = open(filename, "r")

	for i in parser:
		res = ""
		line = i.split(",")

		stime = str(line[2]).strip()
		stime = int(date_to_timestamp(stime))

		etime = str(line[3]).strip()
		etime = int(date_to_timestamp( etime ))

		res=str(count)+","+str(line[1])+","+str(stime)+","+str(etime)+","+str(line[4])+","+str(line[5])
		print res
		count+=1

filename = "Data/1.csv"
parse(filename)
